<?php

namespace App\Http\Controllers\Employee;
use App\Http\Controllers\Controller;

use App\Attendance;
use App\Holiday;
use App\Rules\DateRange;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use phpDocumentor\Reflection\Location;

class AttendanceController extends Controller
{
    
    // Opens view for attendance register form
    public function create() {
        
        $employee = Auth::user()->employee;
        $data = [
            'employee' => $employee,
            'attendance' => null,
            'registered_attendance' => null
        ];
        $last_attendance = $employee->attendance->last();
        if($last_attendance) {
            if($last_attendance->created_at->format('d') == Carbon::now()->format('d')){
                $data['attendance'] = $last_attendance;
                if($last_attendance->registered)
                    $data['registered_attendance'] = 'yes';
            }
        }
        return view('employee.attendance.create')->with($data);
    }

    // Stores entry record of attendance
    public function store(Request $request, $employee_id) {
        $attendance = new Attendance([
                'employee_id' => $employee_id,
        ]);
        $attendance->save();
        $request->session()->flash('success', 'Attendance entry successfully logged');
        return redirect()->route('employee.attendance.create')->with('employee', Auth::user()->employee);
    }

    // Stores exit record of attendance
    public function update(Request $request, $attendance_id) {
        $attendance = Attendance::findOrFail($attendance_id);
        $attendance->registered = 'yes';
        $attendance->save();
        $request->session()->flash('success', 'Attendance exit successfully logged');
        return redirect()->route('employee.attendance.create')->with('employee', Auth::user()->employee);
    }

    
    public function index() {
        $employee = Auth::user()->employee;
        $attendances = $employee->attendance;
        $filter = false;
        if(request()->all()) {
            $this->validate(request(), ['date_range' => new DateRange]);
            if($attendances) {
                [$start, $end] = explode(' - ', request()->input('date_range'));
                $start = Carbon::parse($start);
                $end = Carbon::parse($end)->addDay();
                $filtered_attendances = $this->attendanceOfRange($attendances, $start, $end);
                // $leaves = $this->leavesOfRange($employee->leave, $start, $end);
                // $holidays = $this->holidaysOfRange(Holiday::all(), $start, $end);
                $attendances = collect();
                $count = $filtered_attendances->count();
                if($count) {
                    $first_day = $filtered_attendances->first()->created_at->dayOfYear;
                    $attendances = $this->get_filtered_attendances($start, $end, $filtered_attendances, $first_day, $count);
                }
                else{
                    while($start->lessThan($end)) {
                        $attendances->add($this->attendanceIfNotPresent($start ));
                        $start->addDay();
                    }
                }
                $filter = true;
            }   
        }
        if ($attendances)
            $attendances = $attendances->reverse()->values();
        $data = [
            'employee' => $employee,
            'attendances' => $attendances,
            'filter' => $filter
        ];
        return view('employee.attendance.index')->with($data);
    }

    public function get_filtered_attendances($start, $end, $filtered_attendances, $first_day, $count) {
        $found_start = false;
        $key = 1;
        $attendances = collect();
        while($start->lessThan($end)) {
            if (!$found_start) {
                if($first_day == $start->dayOfYear()) {
                    $found_start = true;
                    $attendances->add($filtered_attendances->first());
                } else {
                    $attendances->add($this->attendanceIfNotPresent($start));
                }
            } else {
                // iterating over the 2nd to .. n dates
                if ($key < $count) {
                    if($start->dayOfYear() != $filtered_attendances->get($key)->created_at->dayOfYear) {
                        $attendances->add($this->attendanceIfNotPresent($start));
                    }
                    else {
                        $attendances->add($filtered_attendances->get($key));
                        $key++;
                    }
                }
                else {
                    $attendances->add($this->attendanceIfNotPresent($start));
                }
            }
            $start->addDay();
        }

        return $attendances;
    }

    public function attendanceIfNotPresent($start) {
        $attendance = new Attendance();
        $attendance->created_at = $start;
        if($start->dayOfWeek == 0) {
            $attendance->registered = 'sun';
        }
         else {
            $attendance->registered = 'no';
        }

        return $attendance;
    }

     public function attendanceOfRange($attendances, $start, $end) {
        return $attendances->filter(function($attendance, $key) use ($start, $end) {
                    $date = Carbon::parse($attendance->created_at);
                    if ((intval($date->dayOfYear) >= intval($start->dayOfYear)) && (intval($date->dayOfYear) <= intval($end->dayOfYear)))
                        return true;
                })->values();
    }
}

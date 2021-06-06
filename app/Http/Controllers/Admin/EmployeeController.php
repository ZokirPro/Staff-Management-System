<?php

namespace App\Http\Controllers\Admin;

use App\Attendance;
use App\Department;
use App\Employee;
use App\Http\Controllers\Controller;
use App\Role;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\ImageManagerStatic as Image;
use function Ramsey\Uuid\v1;

class EmployeeController extends Controller
{
    public function index() {

        // $employees=Employee::with(['department','attendance','expense'])->get();
        $data = [
            'employees' => Employee::all()
        ];
        return view('admin.employees.index')->with($data);
    }
    public function create() {
        $data = [
            'departments' => Department::all(),
            'desgs' => ['Manager', 'Assistant Manager', 'Deputy Manager', 'Clerk']
        ];
        return view('admin.employees.create')->with($data);
    }

    public function store(Request $request) {
       
        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'desg' => 'required',
            'department_id' => 'required',
            'salary' => 'required|numeric',
            'email' => 'required|email',
            'photo' => 'image|nullable',
            'password' => 'required|confirmed|min:6'
        ]);
        
        $user = User::create([
            'name' => $request->first_name.' '.$request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
         
        $employeeRole = Role::where('name', 'employee')->first();
        $user->roles()->attach($employeeRole);
        $employeeDetails = [
            'user_id' => $user->id, 
            'first_name' => $request->first_name, 
            'last_name' => $request->last_name,
            'sex' => $request->sex, 
            'dob' => $request->dob, 
            'join_date' => $request->join_date,
            'desg' => $request->desg, 
            'department_id' => $request->department_id, 
            'salary' => $request->salary, 
            'photo'  => 'user.png'
        ];
        // Photo upload
        if ($request->hasFile('photo')) {
            // GET FILENAME
            $filename_ext = $request->file('photo')->getClientOriginalName();
            // GET FILENAME WITHOUT EXTENSION
            $filename = pathinfo($filename_ext, PATHINFO_FILENAME);
            // GET EXTENSION
            $ext = $request->file('photo')->getClientOriginalExtension();
            //FILNAME TO STORE
            $filename_store = $filename.'_'.time().'.'.$ext;
            // UPLOAD IMAGE
            // $path = $request->file('photo')->storeAs('public'.DIRECTORY_SEPARATOR.'employee_photos', $filename_store);
            // add new file name
            $image = $request->file('photo');
            $image_resize = Image::make($image->getRealPath());              
            $image_resize->resize(300, 300);
            $path=public_path('employee_photos/');
            if(!file_exists($path))
                mkdir($path, 666, true);
            $image_resize->save($path.$filename_store);
            $employeeDetails['photo'] = $filename_store;
        }
        
        Employee::create($employeeDetails);
        $request->session()->flash('success', 'Employee has been successfully added');
        return redirect()->route('admin.employees.index');
    }
    
    public function attendance(Request $request) {
        $data = [
            'date' => null
        ];
        if($request->all()) {
            $date = Carbon::create($request->date);
            $employees = $this->attendanceByDate($date);
            $data['date'] = $date->format('d M, Y');
        } else {
            $employees = $this->attendanceByDate(Carbon::now());
        }
        $data['employees'] = $employees;
        // dd($employees->get(4)->attendanceToday->id);
        return view('admin.employees.attendance')->with($data);
    }

    public function attendanceByDate($date) {
        $employees = DB::table('employees')->select('id', 'first_name', 'last_name', 'desg', 'department_id')->get();
        $attendances = Attendance::all()->filter(function($attendance, $key) use ($date){
            return $attendance->created_at->dayOfYear == $date->dayOfYear;
        });
        return $employees->map(function($employee, $key) use($attendances) {
            $attendance = $attendances->where('employee_id', $employee->id)->first();
            $employee->attendanceToday = $attendance;
            $employee->department = Department::find($employee->department_id)->name;
            return $employee;
        });
    }

    public function destroy($employee_id) {
        $employee = Employee::findOrFail($employee_id);
        $user = User::findOrFail($employee->user_id);
        // detaches all the roles
        DB::table('leaves')->where('employee_id', '=', $employee_id)->delete();
        DB::table('attendances')->where('employee_id', '=', $employee_id)->delete();
        DB::table('expenses')->where('employee_id', '=', $employee_id)->delete();
        $employee->delete();
        $user->roles()->detach();
        // deletes the users
        $user->delete();
        request()->session()->flash('success', 'Employee record has been successfully deleted');
        return back();
    }

    public function attendanceDelete($attendance_id) {
        $attendance = Attendance::findOrFail($attendance_id);
        $attendance->delete();
        request()->session()->flash('success', 'Attendance record has been successfully deleted!');
        return back();
    }

    public function edit(Request $request, $id)
    {
        
        $employee=Employee::find($id);
        $departments=Department::all();
        $desgs=['Manager', 'Assistant Manager', 'Deputy Manager', 'Clerk'];
        return view('admin.employees.edit',compact('employee','departments','desgs'));
    }

    public function search(Request $request)
    {   
        $name=$request['name'];
        $designation=$request['designation'];
        $department=$request['department'];
        $join_date_from=$request['join_date_from'];
        $join_date_to=$request['join_date_to'];
        $salary_from=$request['salary_from'];
        $salary_to=$request['salary_to'];

        $data=(new Employee)->newQuery()->with(['department'])->join('departments', 'departments.id', '=', 'employees.department_id');

        if($name!=null){
            $data=$data->where('first_name','like','%'.$name.'%');
        }

        if($designation!=null){
            $data=$data->where('desg','like','%'.$designation.'%');
        }
        
        if($department!=null){
            $data=$data->where('departments.name','like','%'.$department.'%');
        }

        if($join_date_from!=null){
            $data=$data->whereDate('employees.created_at','>=',$join_date_from);
        }

        if($join_date_to!=null){
            $data=$data->whereDate('employees.created_at','<=',$join_date_to);
        }

        if($salary_from!=null){
            $data=$data->where('salary','>=',$salary_from);
        }

        if($salary_to!=null){
            $data=$data->where('salary','<=',$salary_to);
        }

        $employees=$data->get();

         $data = [
            'employees' => $employees
        ];
        return view('admin.employees.index')->with($data);

    }
    }

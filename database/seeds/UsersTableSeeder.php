<?php

use App\Attendance;
use App\Department;
use \DateTime as DateTime;
use App\Role;
use App\User;
use App\Employee;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();
        DB::table('role_user')->truncate();
        DB::table('employees')->truncate();
        DB::table('departments')->truncate();
        DB::table('attendances')->truncate();
        $employeeRole = Role::where('name', 'employee')->first();
        $adminRole =  Role::where('name', 'admin')->first();

        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@admin.com',
            'password' => Hash::make('Password')
        ]);

        $employee = User::create([
            'name' => 'Zokir Gofurboyev',
            'email' => 'user@user.com',
            'password' => Hash::make('Password')
        ]);

        // 
        $employee->roles()->attach($employeeRole);
        $dob = new DateTime('1997-09-15');
        $join = new DateTime('2020-01-15');
        $admin->roles()->attach($adminRole);
        $employee = Employee::create([
            'user_id' => $employee->id,
            'first_name' => 'Zokir',
            'last_name' => 'Gofurboyev',
            'dob' => $dob->format('Y-m-d'),
            'sex' => 'Male',
            'desg' => 'Manager',
            'department_id' => '1',
            'join_date' => $join->format('Y-m-d'),
            'salary' => 10520.75
        ]);

        Department::create(['name' => 'Purcase']);
        Department::create(['name' => 'Sales']);
        Department::create(['name' => 'Finance']);
        Department::create(['name' => 'HR']);

    }
}

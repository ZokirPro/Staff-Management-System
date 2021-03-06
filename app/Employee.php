<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table='employees';
    protected $dates = ['created_at', 'dob','updated_at', 'join_date'];
    protected $fillable = ['user_id', 'first_name', 'last_name', 'sex', 'dob', 'join_date', 'desg', 'department_id', 'salary', 'photo'];
    
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
    public function user() {
        return $this->belongsTo('App\User');
    }

    public function department() {
        // return $this->hasOne('App\Department');
        return $this->belongsTo('App\Department');
    }

    public function attendance() {
        return $this->hasMany('App\Attendance');
    }

    public function expense() {
        return $this->hasMany('App\Expense');
    }
}

<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    //
    protected $fillable = ['employee_id','entry_time'];
    public function employee() {
        return $this->belongsTo('App\Employee');
    }
}

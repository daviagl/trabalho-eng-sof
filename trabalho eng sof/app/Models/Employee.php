<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $table = "employees";
    protected $fillable = ['name', 'cpf', 'email', 'phone', 'basesalary', 'department_id'];

    public function department()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
}
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * A Designation has many Employees
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}

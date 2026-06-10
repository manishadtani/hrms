<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
  
/**
 * Department Model
 * 
 * MERN equivalent:
 * const Department = mongoose.model('Department', departmentSchema);
 * 
 * Relationships:
 * - A department HAS MANY employees
 *   (jaise MongoDB mein populate karte ho — yahan Eloquent relationship use hoti hai)
 */
class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'is_active',
    ];

    /**
     * A Department has many Employees
     * MERN: Department.find().populate('employees')
     * Laravel: $department->employees
     */
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}



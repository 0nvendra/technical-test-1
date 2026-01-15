<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    /** @use HasFactory<\Database\Factories\EmployeeFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    protected $fillable = [
        'firstName',
        'lastName',
        'company_id',
        'email',
        'phone',
    ];

    public function Company()
    {
        return $this->belongsTo(Company::class);
    }
}

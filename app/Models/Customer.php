<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    // Specify the fields that can be mass-assigned
    protected $fillable = [
        'first_name',
        'last_name',
        'age',
        'dob',
        'email',
    ];
}

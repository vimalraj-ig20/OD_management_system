<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class staff_data extends Model
{
    use HasFactory;

    protected $table = 'staff_data';

    protected $primaryKey = 'auto_id';

    protected $fillable = [
        'staff_id',
        'firstname',
        'lastname',
        'dob',
        'email',
        'phone_number',
    ];
}

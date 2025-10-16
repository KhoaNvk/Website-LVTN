<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Customer extends Authenticatable
{
    use Notifiable;

    protected $table = 'customer'; // Tên bảng trong database

    protected $primaryKey = 'idCustomer'; // Khóa chính

    protected $fillable = [
        'username',
        'password',
        'Avatar',
        'Status'
    ];

    protected $hidden = [
        'password',
    ];

    public $timestamps = false;
}

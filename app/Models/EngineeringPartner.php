<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class EngineeringPartner extends Authenticatable
{
    use Notifiable;

    protected $table = 'engineering_partners';

    protected $guarded='';

    protected $hidden = [
        'password',
        'remember_token',
    ];
}

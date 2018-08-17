<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset;

class Voucher extends Authenticatable
{

    protected $table = 'voucher';

    protected $primaryKey = 'voucher_id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'special_offer_id', 'recipient_id', 'code', 'used_at'
    ];
}

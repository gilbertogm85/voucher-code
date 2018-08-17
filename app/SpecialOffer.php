<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\PasswordReset;

class SpecialOffer extends Authenticatable
{
    protected $table = 'special_offer';

    protected $primaryKey = 'special_offer_id';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'discount', 'expiry_date'
    ];

    public function vouchers()
    {
        return $this->hasMany('App\Voucher','special_offer_id','special_offer_id');
    }

}

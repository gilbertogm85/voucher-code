<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Recipient;
use App\Voucher;

class ApiController extends Controller
{
    /*
    Get voucher code, email and date (optional) and check if exists
    In case it's a valid voucher and unused, sets it as used using today's date (in case date is not defined)
    In case it's a valid voucher but used, shows voucher information and status "Already been used"
    In case it's not a valid voucher, shows an Invalid status
    Returns all the data in JSON format
    */
    public function confirm_voucher_json($code, $email, $date = NULL) {
        if ($date == NULL) {
            $date = date('Y-m-d');
        }
        $voucher = Voucher::join('recipient', 'recipient.recipient_id', '=', 'voucher.recipient_id')->join('special_offer', 'special_offer.special_offer_id', '=', 'voucher.special_offer_id')->where('code', '=', $code)->where('recipient.email', '=', $email)->where('expiry_date', '>', now())->first();
        if (!is_null($voucher)) {
            $data['discount'] = $voucher->discount;
            $voucher = Voucher::where('code', '=', $code)->first();
            if(!is_null($voucher->used_at)) {
                $data['used_at'] = $voucher->used_at;
                $data['status'] = 'Already been used';
            } else {
                $data['used_at'] = $date;
                $voucher->fill($data);
                $voucher->save();
                $data['status'] = 'Valid';
            }
        } else {
            $data['status'] = 'Invalid';
        }
        return json_encode($data, true);
    }

    /*
    Get all valid vouchers of a specific e-mail address
    Returns all the data in JSON format
    */
    public function voucher_json($email) {
        $voucher = Voucher::join('recipient', 'recipient.recipient_id', '=', 'voucher.recipient_id')->join('special_offer', 'special_offer.special_offer_id', '=', 'voucher.special_offer_id')->where('email', '=', $email)->where('expiry_date', '>', now())->get();
        if ($voucher->first()) {
            foreach ($voucher as $key => $v) {
                $data[$key]['voucher_code'] = $v->code;
                $data[$key]['expiry_date'] = $v->expiry_date;
                $data[$key]['discount'] = $v->discount;
                $data[$key]['used_at'] = $v->used_at;
            }
        } else {
            $data['status'] = 'No vouchers found for the given e-mail address';
        }
        return json_encode($data, true);
    }
}

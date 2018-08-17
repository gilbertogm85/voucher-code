<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Voucher;
use App\SpecialOffer;
use App\Recipient;
use App\Mail\NotifyVoucher;
use DB, Mail;

class VoucherController extends Controller
{
    /*
    Get voucher_id, deletes it and send the user back to a route.
    */
    public function destroy($voucher)
    {
        $special_offer = Voucher::select('special_offer_id')->where('voucher_id', '=', $voucher)->first();
        $voucher = Voucher::where('voucher_id', '=', $voucher)->delete();
        return redirect()->route('special-offer.show', ['special_offer' => $special_offer->special_offer_id])->with('success','Voucher deleted successfully!');

    }

    /*
    Get voucher code and email and validates if exists.
    Render the information to a view.
    */
    public function confirm_voucher($code, $email) {
        $voucher = Voucher::join('recipient', 'recipient.recipient_id', '=', 'voucher.recipient_id')->join('special_offer', 'special_offer.special_offer_id', '=', 'voucher.special_offer_id')->where('code', '=', $code)->where('recipient.email', '=', $email)->first();
        if (!is_null($voucher)) {
            return view('voucher.index', ['voucher' => $voucher]);
        }
        return view('voucher.index');
    }


    /*
    Get voucher code and email and validates if exists.
    Render the information to a view.
    */
    public function send_voucher($code, $email) {
        $voucher = Voucher::join('recipient', 'recipient.recipient_id', '=', 'voucher.recipient_id')->join('special_offer', 'special_offer.special_offer_id', '=', 'voucher.special_offer_id')->where('code', '=', $code)->where('recipient.email', '=', $email)->first();
        $r = Recipient::where('recipient_id', '=', $voucher->recipient_id)->first();
        $special_offer = SpecialOffer::where('special_offer_id', '=', $voucher->special_offer_id)->first();

        Mail::to($r)->queue(new NotifyVoucher($voucher,$special_offer,$r));
        return redirect()->route('special-offer.show', $voucher->special_offer_id)->with('success','Voucher was sent to the recipient successfully!');
    }

    /*
    Get voucher code, email and all the data posted from the form.
    Mark the voucher as used, using today's date
    */
    public function confirm_voucher_post(Request $request, $code, $email) {
        $voucher = Voucher::join('recipient', 'recipient.recipient_id', '=', 'voucher.recipient_id')->join('special_offer', 'special_offer.special_offer_id', '=', 'voucher.special_offer_id')->where('code', '=', $code)->where('recipient.email', '=', $email)->first();
        if (!is_null($voucher)) {
            $voucher = Voucher::where('code', '=', $code)->first();
            if (!is_null($voucher->used_at)) {
                return redirect()->route('special-offer.show', $voucher->special_offer_id)->with('unsuccess','Voucher has already been used.');
            }
            $data['used_at'] = $request->get('used_at');
            $voucher->fill($data);
            $voucher->save();
            return redirect()->route('special-offer.show', $voucher->special_offer_id)->with('success', 'Voucher marked as used successfully!');
        } else {
        	return redirect()->route('special-offer.index');
        }
    }

    /*
    Get all the vouchers from a specific recipient, using the e-mail address and render it to a view
    */
    public function get_vouchers($email) {
        $vouchers = Voucher::join('recipient', 'recipient.recipient_id', '=', 'voucher.recipient_id')->join('special_offer', 'special_offer.special_offer_id', '=', 'voucher.special_offer_id')->where('email', '=', $email)->where('expiry_date', '>', date('Y-m-d'))->get();
        return view('voucher.vouchers', ['vouchers' => $vouchers]);
    }

    /*
    Generate vouchers for users created after a special offer
    */
    public function generate_later_vouchers($special_offer) {
        $lateRecipients = DB::select(DB::raw("SELECT recipient.recipient_id FROM recipient LEFT JOIN (SELECT * FROM special_offer JOIN voucher ON voucher.special_offer_id = special_offer.special_offer_id WHERE special_offer.special_offer_id = ".$special_offer.") special_offer ON special_offer.recipient_id = recipient.recipient_id WHERE special_offer.name IS NULL"));
        if (!empty($lateRecipients)) {
            foreach ($lateRecipients as $lr) {
                $data['special_offer_id'] = $special_offer;
                $data['recipient_id'] = $lr->recipient_id;
                $data['code'] = str_random(10);
                Voucher::create($data);
            }
            return redirect()->route('special-offer.show', $special_offer)->with('success','Vouchers were generated successfully!');
        } else {
            return redirect()->route('special-offer.show', $special_offer)->with('unsuccess','There was not any vouchers to be created!');

        }
        
    }
}

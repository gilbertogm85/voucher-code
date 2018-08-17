<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\SpecialOffer;
use App\Recipient;
use App\Voucher;
use App\Mail\NotifyVoucher;
use Mail;

class SpecialOfferController extends Controller
{
    /*
    Get all special offers
    Render it to a view
    */
    public function index()
    {
    	$special_offers = SpecialOffer::all();
    	return view('special-offer.index', ['special_offers' => $special_offers]);
    }

    /*
    Get a specific special offer to edit
    Render the information to a view
    */
    public function edit($special_offer)
    {
        $special_offer = SpecialOffer::where('special_offer_id', '=', $special_offer)->first();
        return view('special-offer.edit', ['special_offer' => $special_offer]);
    }

    /*
    Get a specific special offer and show all it's vouchers
    Render it to a view
    */
    public function show($special_offer)
    {
        $vouchers = SpecialOffer::join('voucher', 'voucher.special_offer_id', '=', 'special_offer.special_offer_id')->join('recipient', 'recipient.recipient_id', '=', 'voucher.recipient_id')->where('special_offer.special_offer_id', '=', $special_offer)->get();
        $special_offer = SpecialOffer::where('special_offer_id', '=', $special_offer)->first();
        return view('special-offer.vouchers', ['vouchers' => $vouchers, 'special_offer' => $special_offer]);
    }

    /*
    Get all the information posted from the form and validates it
    Save changes or handle errors and send the user back to a route
    */
    public function update(Request $request, $special_offer)
    {
        $input = $request->all();

        $rules = array(
            'name'  => 'required',
            'expiry_date' => 'required|date',
            'discount' => 'required|numeric:5,2'
        );
        
        $messages = array(
            'nome.required' => 'Name is required.',
            'expiry_date.required' => 'Expiry date is required.',
            'expiry_date.date' => 'Expiry date is not valid.',
            'discount.numeric' => 'Must be a numeric value.',
            'discount.required' => 'Discount is required.'
        );   

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->passes()) {
            $update = SpecialOffer::where('special_offer_id', '=', $special_offer)->first();
            $update->fill($input);
            $update->save();
            return redirect()->route('special-offer.index');
        } else {
            $errors = $validator->errors();
            return redirect()->route('special-offer.edit', $special_offer)->withErrors($errors)->withInput($input);
        }
    }

    /*
    Get all the information posted from the form and validates it
    Save special offer or handle errors and send the user back to a route
    */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'name'  => 'required',
            'expiry_date' => 'required|date|after:yesterday',
            'discount' => 'required|numeric:5,2'
        );
        
        $messages = array(
            'nome.required' => 'Name is required.',
            'expiry_date.required' => 'Expiry date is required.',
            'expiry_date.date' => 'Expiry date is not valid.',
            'discount.numeric' => 'Must be a numeric value.',
            'discount.required' => 'Discount is required.'
        );  

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->passes()) {
            $special_offer = SpecialOffer::create($input);
            $recipients = Recipient::all();

            foreach ($recipients as $r) {
                $data['special_offer_id'] = $special_offer->special_offer_id;
                $data['recipient_id'] = $r->recipient_id;
                $data['code'] = str_random(10);
                $voucher = Voucher::create($data);
                Mail::to($r)->queue(new NotifyVoucher($voucher,$special_offer,$r));
            }

            return redirect()->route('special-offer.index')->with('success','New special offer registered and all the recipients notified successfully!');
        } else {
            $errors = $validator->errors();
            return redirect()->route('special-offer.create')->withErrors($errors)->withInput($input);
        }
    }

    /*
    Render form to create a new special offer
    */   
    public function create()
    {
        return view('special-offer.create');
    }

    /*
    Get special_offer_id and check if it's valid.
    If yes, delete it and send the user back to a route.
    */
    public function destroy($special_offer)
    {
        $special_offer = SpecialOffer::where('special_offer_id', '=', $special_offer)->delete();
        return redirect()->route('special-offer.index')->with('success','Special Offer deleted successfully!');
    }


}

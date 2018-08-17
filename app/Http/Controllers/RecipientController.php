<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use App\Recipient;
use Auth, Crypt, DB;

class RecipientController extends Controller
{
    /*
    Get all recipients
    Render it to a view
    */
    public function index()
    {
    	$recipients = Recipient::all();
    	return view('recipient.index', ['recipients' => $recipients]);
    }

    /*
    Get a specific recipient to edit
    Render the information to a view
    */
    public function edit($recipient)
    {
        $recipient = Recipient::where('recipient_id', '=', $recipient)->first();
        return view('recipient.edit', ['recipient' => $recipient]);
    }

    /*
    Get all the information posted from the form and validates it
    Save changes or handle errors and send the user back to a route
    */
    public function update(Request $request, $recipient)
    {
        $input = $request->all();

        $rules = array(
            'name'  => 'required',
            'email' => 'required|email|unique:recipient'
        );
        $rules['email'] = $rules['email'] . ',email,' . $recipient. ',recipient_id';
        $messages = array(
            'nome.required' => 'Name is required.',
            'email.required'    => 'E-mail address is required.',
            'email.email'   => 'Bad format for e-mail field.',
            'email.unique'  => 'E-mail address must be unique.'
        );  

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->passes()) {
            $update = Recipient::where('recipient_id', '=', $recipient)->first();
            $update->fill($input);
            $update->save();
            return redirect()->route('recipient.index')->with('success', 'Recipient updated successfully!');
        } else {
            $errors = $validator->errors();
            return redirect()->route('recipient.edit', $recipient)->withErrors($errors)->withInput($input);
        }
    }

    /*
    Get all the information posted from the form and validates it
    Save recipient or handle errors and send the user back to a route
    */
    public function store(Request $request)
    {
        $input = $request->all();
        $rules = array(
            'name'  => 'required',
            'email' => 'required|email|unique:recipient'
        );
        
        $messages = array(
            'nome.required' => 'Name is required.',
            'email.required'    => 'E-mail address is required.',
            'email.email'   => 'Bad format for e-mail field.',
            'email.unique'  => 'E-mail address must be unique.'
        );  

        $validator = Validator::make($input, $rules, $messages);
        if ($validator->passes()) {
            Recipient::create($input);
            return redirect()->route('recipient.index')->with('success','New recipient registered successfully!');
        } else {
            $errors = $validator->errors();
            return redirect()->route('recipient.create')->withErrors($errors)->withInput($input);
        }
    }

    /*
    Render form to create a new recipient
    */    
    public function create()
    {
        return view('recipient.create');
    }

    /*
    Get recipient_id and check if it used any vouchers.
    If not, delete it. Otherwise handle error and send the user back to a route.
    */
    public function destroy($recipient)
    {
        $voucher = \App\Voucher::where('recipient_id', '=', $recipient)->whereNotNull('used_at')->get();
        if ($voucher->first()) {
            return redirect()->route('recipient.index')->with('error',"Recipient already used a voucher and can't be deleted");
        }
        $recipient = Recipient::where('recipient_id', '=', $recipient)->delete();
        return redirect()->route('recipient.index')->with('success','Recipient deleted successfully!');
    }
}

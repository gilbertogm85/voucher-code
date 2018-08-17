<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Recipient;
use App\SpecialOffer;
use App\Voucher;


class NotifyVoucher extends Mailable
{
    use Queueable, SerializesModels;

    protected $special_offer;

    protected $r;

    protected $voucher;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Voucher $voucher, SpecialOffer $special_offer,Recipient $r)
    {
        $this->special_offer=$special_offer;
        $this->r=$r;
        $this->voucher=$voucher;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.voucher')
            ->subject('New voucher specially for you')
            ->with(['voucher' => $this->voucher, 'special_offer'=>$this->special_offer,'user'=>$this->r]);
    }
}

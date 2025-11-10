<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $bill;
    public $billInfo;

    public function __construct($bill, $billInfo)
    {
        $this->bill = $bill;
        $this->billInfo = $billInfo;
    }

    public function build()
    {
        return $this->subject('Xác nhận đơn hàng #' . $this->bill->idBill)
                    ->view('emails.order_placed')
                    ->with([
                        'bill' => $this->bill,
                        'billInfo' => $this->billInfo
                    ]);
    }
}


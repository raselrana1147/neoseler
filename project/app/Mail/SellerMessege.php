<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SellerMessege extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $email;
    public $subject;
    public $data;
    public function __construct($email,$subject,$data=array())
    {
        $this->email=$email;
        $this->subject=$subject;
        $this->data=$data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('admin.mail.seller')
        ->with('data',$this->data)
        ->subject($this->subject)
        ->to($this->email);
    }
}

<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class MailNotify extends Mailable
{
    use Queueable, SerializesModels;

    public $costs;
    public $name;
    public $total;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $name, $total)
    {
        $this->costs = $data['costs'];
        $this->name = $name;
        $this->total = $total;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('kiet1022@gmail.com')
        ->subject('Tiền phòng tháng '.date('m'))
        ->markdown('pages.mail_notify');
    }
}

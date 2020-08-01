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

    public $total;
    public $ele_cost_name;
    public $ele_cost_value;
    public $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $name)
    {
        $this->total = $data['total'];
        $this->ele_cost_name = $data['ele_cost_name'];
        $this->ele_cost_value = $data['ele_cost_value'];
        $this->name = $name;
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

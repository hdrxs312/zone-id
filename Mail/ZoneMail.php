<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use DB;

class ZoneMail extends Mailable
{
    use Queueable, SerializesModels;
    
    public $obj;
    
    public function __construct($obj)
    {
        $this->obj = $obj;
    }

    
    public function build()
    {
        if($obj->type == 'resetpw') {
            $subject = 'Konfirmasi reset Password';
        }
        if($obj->type == 'invoice') {
            $subject = 'Invoice #'.$obj->id;
            $data = DB::table('_app1_inv')->where('id',$obj->id)->first();
            $app = DB::table('_app1')->where('dom',$data->dom)->first();
            $obj->link = 'http://'.$data->dom.'.zone.id/app1/inv/'.$obj->id.'?email='.$data->email;
        }
        $senderName = 'noreply@zone.id';
        $senderEmail = 'admin@zone.id';

        return $this->from($senderMail)
            ->view('Mail::'.$obj->type)
            ->with([
                'subject' => $subject,
            ]);
    }
}

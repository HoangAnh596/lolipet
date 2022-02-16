<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Mail;

class MailController extends Controller
{
    public function send_mail(){
        // Send mail
        $to_name = "Lolipetfamily";
        $to_email = "ngoctkph11120@fpt.edu.vn";

        $data = array("name"=>"Website bán thú cưng Lolipetfamily","body"=>'Đơn hàng của bạn đã được gửi',"nameClient" => $order->name); // body of mail.blade.php
        Mail::send('mail.send-mail',$data,function($message) use ($to_name,$to_email){
            $message->to($to_email)->subject('Cập nhật trạng thái đơn hàng'); //send this mail with subject
            $message->from($to_email,$to_name);// send from this mail
        });
        // return redirect('/trang-chu');
    }

    // public function send_mail(){
    //     // Send mail
    //     $to_name = "Helo manh hung";
    //     $to_email = "hungtmph10583@gmail.com";// send to this email
    //     $link_reset_pass = url('update-new-pass?email='.$to_email.'&token='.$rand_id);

    //     $data = array("name"=>"Helo manh hung","body"->$link_reset_pass); // body of mail.blade.php
    //     Mail::send('admin.reset_pass',$data,function($message) use ($to_name,$to_email){
    //         $message->to($to_email)->subject('Forget password Admin Bigboss'); //send this mail with subject
    //         $message->from($to_email,$to_name);// send from this mail
    //     });
    // }
}

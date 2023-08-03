<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderMail extends Mailable
{
    use Queueable, SerializesModels;
    private $id;
    private $status;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id,$status)
    {
        $this->id=$id;
        $this->status=$status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $id=$this->id;
        $status=$this->status;
        if($status == "New Order"){
            if(str_contains($id,"SDRO")){
                $id=str_replace("SDRO","",$id);
                return $this->subject('Order Confirmation')->view('emails.orderConfirmation1')->with(["id"=>$id]);
            }else{
                $id=str_replace("SDVO","",$id);
                return $this->subject('Order Confirmation')->view('emails.orderConfirmation2')->with(["id"=>$id]);
            }
        }elseif($status == "Accepted"){
            if(str_contains($id,"SDRO")){
                $id=str_replace("SDRO","",$id);
                return $this->subject('Order Accepted')->view('emails.orderAccepted1')->with(["id"=>$id]);
            }else{
                $id=str_replace("SDVO","",$id);
                return $this->subject('Order Accepted')->view('emails.orderAccepted2')->with(["id"=>$id]);
            }
        }elseif($status == "Cancel"){
            if(str_contains($id,"SDRO")){
                $id=str_replace("SDRO","",$id);
                return $this->subject('Order Canceled')->view('emails.orderCancel1')->with(["id"=>$id]);
            }else{
                $id=str_replace("SDVO","",$id);
                return $this->subject('Order Canceled')->view('emails.orderCancel2')->with(["id"=>$id]);
            }
        }elseif($status == "Dispatched"){            
            if(str_contains($id,"SDRO")){
                $id=str_replace("SDRO","",$id);
                return $this->subject('Order Dispatched')->view('emails.orderDispatch1')->with(["id"=>$id]);
            }else{
                $id=str_replace("SDVO","",$id);
                return $this->subject('Order Dispatched')->view('emails.orderDispatch2')->with(["id"=>$id]);
            }
        }elseif($status == "Completed"){
            if(str_contains($id,"SDRO")){
                $id=str_replace("SDRO","",$id);
                return $this->subject('Order Completed')->view('emails.orderComplete1')->with(["id"=>$id]);
            }else{
                $id=str_replace("SDVO","",$id);
                return $this->subject('Order Completed')->view('emails.orderComplete2')->with(["id"=>$id]);
            }
        }elseif($status == "Return"){
            if(str_contains($id,"SDRO")){
                $id=str_replace("SDRO","",$id);
                return $this->subject('Order Returned')->view('emails.orderReturn1')->with(["id"=>$id]);
            }else{
                $id=str_replace("SDVO","",$id);
                return $this->subject('Order Returned')->view('emails.orderReturn2')->with(["id"=>$id]);
            }
        }
    }
}

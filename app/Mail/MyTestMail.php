<?php
  
namespace App\Mail;
  
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
  
class MyTestMail extends Mailable
{
    use Queueable, SerializesModels;
  
    public $mail;
    public $company;
  
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail, $company)
    {
        $this->mail = $mail;
        $this->company = $company;
    }
  
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('E-mail van potentiële klant: '.$this->company)
                    ->view('emails.myTestMail');
    }
}
<?php


namespace App\Classes;


use Symfony\component\Mailer;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ClsMail
{
    public function SendEmail(MailerInterface $mailer)
    {
        
        $email = (new Email())
            ->from('infos@scoutblacfeet.com')
            ->to('souscription.cedric@gmail.com')
            ->subject('test')
            ->text('send emails');
        
        $mailer->send($email);
    }
}
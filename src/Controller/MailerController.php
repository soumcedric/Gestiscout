<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;



class MailerController extends AbstractController
{
    /**
     * @Route("/mailer", name="mailer")
     */
    public function index(): Response
    {
        return $this->render('mailer/index.html.twig', [
            'controller_name' => 'MailerController',
        ]);
    }

    public function SendEmail( MailerInterface $mailer)
    {
        $email = (new Email())
            ->from('infos@scoutblackfeet.com')
            ->to('souscription.cedric@gmail.com')
            ->subject('Bonjour');

        $mailer->SendEmail($email);

    }

   
}

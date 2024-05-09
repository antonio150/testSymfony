<?php

namespace App\EventSubscriber;

use Symfony\Component\Console\Event\ConsoleCommandEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private $mailer;
    private $form;
    private $to;
   public function __construct(MailerInterface $mailer, string $form,
   string $to)
   {
    $this->mailer = $mailer;
    $this->form = $form;
    $this->to = $to;
   }

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }

    public function onException(ExceptionEvent $event){
        $message=(new Email()) 
        ->from('hello@example.com')
        ->to('you@example.com')
        //->cc('cc@example.com')
        //->bcc('bcc@example.com')
        //->replyTo('fabien@example.com')
        //->priority(Email::PRIORITY_HIGH)
        ->subject('Time for Symfony Mailer!')
        ->text('Sending emails is fun again!')
        ->html('<p>See Twig integration for better HTML integration!</p>');

        $this->mailer->send($message);
    }
}

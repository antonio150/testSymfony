<?php

namespace App\Tests\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use PHPUnit\Framework\TestCase ;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mailer\MailerInterface;

class ExceptionSubscriberTest extends TestCase{

    public function testEventSubscription(){
        $this->assertArrayHasKey(ExceptionEvent::class, ExceptionSubscriber::getSubscribedEvents());

    }

    public function testOnExceptionSendEmail(){
        $mailer = $this->getMockBuilder(MailerInterface::class)
        ->disableOriginalConstructor()
        ->getMock();

        // dd($mailer);
        // $subscriber = new ExceptionSubscriber($mailer, 'from@domain.fr', 'to@domain.fr');
        $kernel = $this->getMockBuilder(KernelInterface::class)->getMock();
        // $event = new ExceptionEvent($kernel, new Request(),1,new \Exception());
        $mailer->expects($this->once())->method('send');
        // $subscriber->onException($event);
    }
}
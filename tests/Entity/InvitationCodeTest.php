<?php

namespace App\Tests\Entity;

use App\Entity\InvitationCode;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class InvitationCodeTest extends KernelTestCase
{
    public function getEntity(): InvitationCode
    {
        return (new InvitationCode())
            ->setCode("12345")
            ->setDescription("Description de test")
            ->setExpireAt(new DateTimeImmutable());
    }

    public function assertHasErrors(InvitationCode $code, int $number = 0)
    {
        self::bootKernel();
        $container = static::getContainer();
        $error = $container->get('validator')->validate($code);
        $this->assertCount($number, $error);
    }
    public function testValidEntity()
    {
        $this->assertHasErrors($this->getEntity(), 0);
    }

    public function testInvalidCodeEntity()
    {
        $this->assertHasErrors($this->getEntity()->setCode('1a34nk,nk5'), 1);
        $this->assertHasErrors($this->getEntity()->setCode(5), 1);
    }

    public function testInvalidBlankCodeEntity()
    {
        $this->assertHasErrors($this->getEntity()->setCode(""), 1);
    }


    public function testInvalidBlankDescriptionEntity()
    {
        $this->assertHasErrors($this->getEntity()->setDescription(""), 1);
    }
}

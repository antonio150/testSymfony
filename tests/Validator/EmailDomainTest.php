<?php

namespace App\Tests\Validator;
use App\Validator\EmailDomain;
use Monolog\Test\TestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\MissingOptionsException as ExceptionMissingOptionsException;

class EmailDomainTest extends TestCase
{
    public function testRequiredParameters()
    {
        $this->expectException(ExceptionMissingOptionsException::class);
        new EmailDomain();
    }

    public function testBadShapedBlockParameter(){
        $this->expectException(ConstraintDefinitionException::class);
        new EmailDomain(['blocked' => 'ezrez']);
    }


    public function testOptionIsSetAsProperty(){
        $arr = ['a', 'b'];
        $domain = new EmailDomain(['blocked' => $arr]);
        $this->assertEquals($arr, $domain->blocked);
    }

}
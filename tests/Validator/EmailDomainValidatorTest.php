<?php

namespace App\Tests\Validator;

use App\Repository\ConfigRepository;
use App\Validator\EmailDomain;
use App\Validator\EmailDomainValidator;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Violation\ConstraintViolationBuilderInterface;

class EmailDomainValidatorTest extends KernelTestCase
{

    public function getValidator($expectedViolation = false, $dbBlockedDomain = [])
    {
        $repository = $this->getMockBuilder(ConfigRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        //  dd($repository->expects($this->any()));
        $repository->expects($this->any())
            ->method("getAsArray")
            ->with('blocked_domains')
            ->willReturn($dbBlockedDomain);

        $validator = new EmailDomainValidator($repository);
        $context= $this->getContext($expectedViolation);
        $validator->initialize($context);
        return $validator;
    }

    public function testCatchBadDomains()
    {

        $constraint = new EmailDomain([
            "blocked" => ['baddomain.fr', 'aze.com'],
        ]);
        $this->getValidator(true)->validate('demo@baddomain.fr', $constraint);
    }


    public function testAcceptGoodDomains()
    {
        $constraint = new EmailDomain([
            'blocked' => ['baddomain.fr', 'aze.com']
        ]);
        $this->getValidator(false)->validate('demo@gooddomain.fr', $constraint);
    }

    public function testBlockedDomainFromDatabase()
    {
        $constraint = new EmailDomain([
            "blocked" => ['baddomain.fr', 'aze.com'],
        ]);
        $this->getValidator(true, ['baddomain.fr'])->validate('demo@baddomain.fr', $constraint);
    }

    /**
     * @return mixed
     */
   /*  public function testParameterSetCorrectly():void{
        $constraint = new EmailDomain([
            "blocked" => [],
        ]);
        self::bootKernel();
        $container = static::getContainer();
        $validator =$container->get(EmailDomainValidator::class);
        $validator->initialize($this->getContext(true));
        $validator->validate('demo@globalblocked.fr', $constraint);
    }
 */

    private function getContext(bool $expectedViolation):ExecutionContextInterface
    {

        $context = $this->getMockBuilder(ExecutionContextInterface::class)->getMock();

        if ($expectedViolation) {
            $violation = $this->getMockBuilder(ConstraintViolationBuilderInterface::class)->getMock();
            $violation->expects($this->any())->method('setParameter')
                ->willReturn($violation);
            $violation->expects($this->any())->method('addViolation');
            $context
                ->expects($this->once())
                ->method('buildViolation')
                ->willReturn($violation);
        } else {
            $context
                ->expects($this->never())
                ->method('buildViolation');
        }

        return $context;
    }
}

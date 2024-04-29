<?php

namespace App\Tests\Repository;

use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Tes;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{


    public function testCount()
    {
        self::bootKernel();

        $container = static::getContainer();
        $users = $container->get(UserRepository::class)->count([]);
        $this->assertEquals(10, $users);
    }
}

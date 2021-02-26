<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\DataFixtures\UserFixtures;
use App\Entity\Item;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    private UserRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->loadFixtures([UserFixtures::class]);
        $this->repository = static::$container->get(UserRepository::class);
    }

    /**
     * @covers \App\Repository\UserRepository::upgradePassword
     */
    public function testUpgradePassword()
    {
        $user = $this->repository->findOneBy(['uuid' => 'admin']);
        $encoder = self::$container->get('security.user_password_encoder.generic');
        $newEncodedPassword = $encoder->encodePassword($user, 'test-password');
        $this->repository->upgradePassword($user, $newEncodedPassword);
        self::assertSame($newEncodedPassword, $user->getPassword());
    }

    /**
     * @covers \App\Repository\UserRepository::upgradePassword
     */
    public function testInvalidEntity()
    {
        $item = new Item();
        $this->expectException(\TypeError::class);
        $this->repository->upgradePassword($item, 'test');
    }
}

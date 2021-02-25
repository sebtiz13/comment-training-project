<?php

declare(strict_types=0);

namespace App\Tests\Entity;

use App\DataFixtures\UserFixtures;
use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;


class UserTest extends KernelTestCase
{

    use FixturesTrait;

    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->loadFixtures([UserFixtures::class]);
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    private function getEntity(): User
    {
        return (new User())
            ->setUuid('user1')
            ->setUsername('username')
            ->setPassword('123')
            ->setRoles(['role']);
    }

    private function assertHasErrors(User $item, int $number = 0): void
    {
        $errors = self::$container->get('validator')->validate($item);
        $messages = [];
        /* @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }
        self::assertCount($number, $errors, implode("\n", $messages));
    }

    public function testValidEntity(): void
    {
        $item = $this->getEntity();

        $this->assertHasErrors($item);
    }

    public function testUuidValidation(): void
    {
        $item = $this->getEntity()
            ->setUuid('');
        $this->assertHasErrors($item, 0);

        $item1 = $this->getEntity()
            ->setUuid('admin');
        $this->assertHasErrors($item1, 0);

        $item2 = $this->getEntity()
            ->setUuid('aze');
        $this->assertHasErrors($item2, 0);
    }

    public function testUsernameValidation(): void
    {
        $item = $this->getEntity()
            ->setUsername('');
        $this->assertHasErrors($item, 0);

        $item1 = $this->getEntity()
            ->setUsername('admin');
        $this->assertHasErrors($item1, 0);

        $item2 = $this->getEntity()
            ->setUsername('aze');
        $this->assertHasErrors($item2, 0);
    }

    public function testPasswordValidation(): void
    {
        $item = $this->getEntity()
            ->setPassword('');
        $this->assertHasErrors($item, 0);

        $item1 = $this->getEntity()
            ->setPassword('456');
        $this->assertHasErrors($item1, 0);
    }

    public function testRolesValidation(): void
    {
        $item = $this->getEntity()
            ->setRoles([]);
        $this->assertHasErrors($item, 0);

        $item1 = $this->getEntity()
            ->setRoles(['']);
        $this->assertHasErrors($item1, 0);
    }

    public function testGetValues(): void
    {
        $user = $this->getEntity();
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        self::assertIsInt($user->getId());
        self::assertSame('user1', $user->getUuid());
        self::assertSame('username', $user->getUsername());
        self::assertSame('123', $user->getPassword());
        self::assertSame(['role', 'ROLE_USER'], $user->getRoles());
    }
}

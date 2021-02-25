<?php

declare(strict_types=0);

namespace App\Tests\Entity;

use App\Entity\Item;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Validator\ConstraintViolation;

class ItemTest extends KernelTestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        $kernel = self::bootKernel();
        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testValidEntity(): void
    {
        $item = $this->getEntity();

        $this->assertHasErrors($item);
    }

    public function getEntity(): Item
    {
        return (new Item())
            ->setTitle('My Item')
            ->setDescription('Super item')
            ->setImage('http://domain.com/image.jpg');
    }

    private function assertHasErrors(Item $item, int $number = 0): void
    {
        $errors = self::$container->get('validator')->validate($item);
        $messages = [];
        /* @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }
        self::assertCount($number, $errors, implode("\n", $messages));
    }

    public function testTitleValidation(): void
    {
        $item = $this->getEntity()
            ->setTitle('');
        $this->assertHasErrors($item, 2);

        $item1 = $this->getEntity()
            ->setTitle(123);
        $this->assertHasErrors($item1, 1);

        $item2 = $this->getEntity()
            ->setTitle('aze');
        $this->assertHasErrors($item2, 1);
    }

    public function testGetValues(): void
    {
        $em = $this->entityManager;
        $item = $this->getEntity();
        $em->persist($item);
        $em->flush();

        self::assertIsInt($item->getId());
        self::assertSame('My Item', $item->getTitle());
        self::assertSame('my-item', $item->getSlug());
        self::assertSame('Super item', $item->getDescription());
        self::assertSame('http://domain.com/image.jpg', $item->getImage());
    }
}

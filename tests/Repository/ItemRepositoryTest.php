<?php

declare(strict_types=1);

namespace App\Tests\Repository;

use App\DataFixtures\ItemFixture;
use App\Entity\Item;
use App\Repository\ItemRepository;
use Doctrine\ORM\Query;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ItemRepositoryTest extends KernelTestCase
{
    use FixturesTrait;

    private ItemRepository $repository;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->loadFixtures([ItemFixture::class]);
        $this->repository = static::$container->get(ItemRepository::class);
    }

    public function testFindAllWithImageQuery(): void
    {
        $query = $this->repository->findAllWithImageQuery();
        self::assertInstanceOf(Query::class, $query);
        self::assertStringContainsString('image IS NOT NULL', $query->getDQL());
    }

    public function testFindAllWithImageReturn(): void
    {
        $images = $this->repository->findAllWithImage();
        self::assertIsArray($images);
    }

    public function testFindAllWithImageLimit(): void
    {
        // Default limit to 10
        $images = $this->repository->findAllWithImage();
        self::assertCount(10, $images);

        // Define limit to -1 to get all results
        $images = $this->repository->findAllWithImage(-1);
        self::assertCount(20, $images);

        $images = $this->repository->findAllWithImage(5);
        self::assertCount(5, $images);
    }

    public function testFindAllWithImageContains(): void
    {
        $images = $this->repository->findAllWithImage(-1);
        self::assertContainsOnly(Item::class, $images);
    }
}

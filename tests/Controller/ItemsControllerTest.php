<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\ItemFixture;
use App\Repository\ItemRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ItemsControllerTest extends WebTestCase
{
    use FixturesTrait;

    private KernelBrowser $client;
    private ItemRepository $repository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->loadFixtures([ItemFixture::class]);
        $this->repository = static::$container->get(ItemRepository::class);
    }

    public function testItemsPage(): void
    {
        $this->client->request('GET', '/items');
        self::assertResponseIsSuccessful();
    }

    public function testTitleItemsPage(): void
    {
        $this->client->request('GET', '/items');
        self::assertSelectorTextContains('h1', 'All items');
    }

    public function testImagesItemsPage(): void
    {
        $crawler = $this->client->request('GET', '/items');
        self::assertCount(12, $crawler->filter('img.card-img-top'));
    }

    public function testPaginationItemsPage(): void
    {
        $this->client->request('GET', '/items');
        self::assertSelectorExists('.pagination');
        self::assertSelectorExists('.page-item');
    }

    public function testShowPage(): void
    {
        $item = $this->repository->findOneBy([]);

        $this->client->request('GET', '/item/'.$item->getSlug());
        self::assertResponseIsSuccessful();
    }

    public function testContentShowPage(): void
    {
        $items = $this->repository->findAll();

        foreach ($items as $item) {
            $crawler = $this->client->request('GET', '/item/'.$item->getSlug());
            self::assertPageTitleSame($item->getTitle());
            self::assertSelectorTextContains('h1', $item->getTitle());
            self::assertStringContainsString((string) $item->getImage(), $crawler->filter('.container>img')->outerHtml());
        }
    }

    public function testFormShowPage(): void
    {
        $item = $this->repository->findOneBy([]);

        $this->client->request('GET', '/item/'.$item->getSlug());

        $this->client->submitForm('Comment', [
            'comment[email]' => 'test@email.com',
            'comment[message]' => 'test comment',
        ]);

        $this->client->followRedirect();

        self::assertSelectorExists('.alert.alert-success');
    }
}

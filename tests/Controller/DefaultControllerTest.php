<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\ItemFixture;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    use FixturesTrait;

    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->loadFixtures([ItemFixture::class]);
    }

    public function testIndexPage(): void
    {
        $this->client->request('GET', '/');
        self::assertResponseIsSuccessful();
    }

    public function testTitleIndexPage(): void
    {
        $this->client->request('GET', '/');
        self::assertSelectorTextContains('h1', 'Last items');
    }

    public function testImagesIndexPage(): void
    {
        $crawler = $this->client->request('GET', '/');
        self::assertCount(8, $crawler->filter('img.card-img-top'));
    }
}

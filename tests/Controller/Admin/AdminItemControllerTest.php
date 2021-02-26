<?php

declare(strict_types=1);

namespace App\Tests\Controller\Admin;

use App\DataFixtures\ItemFixture;
use App\DataFixtures\UserFixtures;
use App\Entity\User;
use App\Repository\ItemRepository;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AdminItemControllerTest extends WebTestCase
{
    use FixturesTrait;

    private KernelBrowser $client;
    private User $user;
    private ItemRepository $repository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->loadFixtures([UserFixtures::class, ItemFixture::class]);
        $this->repository = static::$container->get(ItemRepository::class);

        $userRepository = static::$container->get(UserRepository::class);
        $this->user = $userRepository->findOneBy(['uuid' => 'admin']);
    }

    public function testRedirectLoginPage(): void
    {
        $this->client->request('GET', '/admin');
        self::assertResponseRedirects('/login');
    }

    public function testIndexPage(): void
    {
        $this->client->loginUser($this->user);
        $this->client->request('GET', '/admin');
        self::assertResponseIsSuccessful();
    }

    public function testTitleIndexPage(): void
    {
        $this->client->loginUser($this->user);
        $this->client->request('GET', '/admin');
        self::assertSelectorTextContains('h1', 'Manage items');
    }

    public function testItemsIndexPage(): void
    {
        $this->client->loginUser($this->user);
        $crawler = $this->client->request('GET', '/admin');
        self::assertCount($this->repository->count([]), $crawler->filter('table>tbody>tr')->getIterator());
    }

    public function testCreateItem(): void
    {
        $this->client->loginUser($this->user);
        $this->client->request('GET', '/admin/item/create');
        $this->client->submitForm('Save', [
            'item[title]' => 'test-item',
            'item[image]' => 'test-image.jpg',
            'item[description]' => 'test-description',
        ]);

        $this->client->followRedirect();

        self::assertSelectorExists('.alert.alert-success');
    }

    public function testEditItemPage(): void
    {
        $this->client->loginUser($this->user);
        $testItem = $this->repository->findOneBy([]);
        $this->client->request('GET', '/admin/item/'.$testItem->getId());

        $formSelector = 'form[name="item"]';
        self::assertFormValue($formSelector, 'item[title]', $testItem->getTitle());
        self::assertFormValue($formSelector, 'item[image]', $testItem->getImage());
        self::assertFormValue($formSelector, 'item[description]', $testItem->getDescription());
    }

    public function testEditItem(): void
    {
        $this->client->loginUser($this->user);
        $testItem = $this->repository->findOneBy([]);
        $this->client->request('GET', '/admin/item/'.$testItem->getId());

        $this->client->submitForm('Save', [
            'item[description]' => 'test-edit-description',
        ]);

        $this->client->followRedirect();

        self::assertSelectorExists('.alert.alert-success');
    }

    public function testDeleteItem(): void
    {
        $this->client->loginUser($this->user);
        $testItem = $this->repository->findOneBy([]);
        $csrfToken = $this->client->getContainer()->get('security.csrf.token_manager')->getToken('delete'.$testItem->getId());
        $this->client->request(
            'DELETE',
            '/admin/item/'.$testItem->getId(),
            ['_token' => $csrfToken]
        );

        $this->client->followRedirect();

        self::assertSelectorExists('.alert.alert-success');
        self::assertSelectorTextNotContains('table>tbody>tr>td', $testItem->getTitle());
    }
}

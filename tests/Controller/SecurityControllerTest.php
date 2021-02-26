<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SecurityControllerTest extends WebTestCase
{
    use FixturesTrait;

    private KernelBrowser $client;
    private UserRepository $repository;

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->loadFixtures([UserFixtures::class]);
        $this->repository = static::$container->get(UserRepository::class);
    }

    public function testLoginPage(): void
    {
        $this->client->request('GET', '/login');
        self::assertResponseIsSuccessful();
    }

    public function testLoginForm(): void
    {
        $this->client->request('GET', '/login');
        $this->client->submitForm('Sign in', [
            'uuid' => 'admin',
            'password' => 'admin',
        ]);

        $this->client->followRedirect();

        self::assertSelectorTextContains('.user-links .dropdown > a', 'admin');
    }

    public function testLogOut(): void
    {
        $user = $this->repository->findOneBy(['uuid' => 'admin']);
        $this->client->loginUser($user);
        $this->client->request('GET', '/logout');

        $this->client->followRedirect();

        self::assertSelectorTextContains('.user-links', 'Log in');
    }
}

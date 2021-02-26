<?php

declare(strict_types=1);

namespace App\Tests\Notification;

use App\DataFixtures\ItemFixture;
use App\Entity\Comment;
use App\Entity\Item;
use App\Notification\CommentNotification;
use App\Repository\ItemRepository;
use Liip\TestFixturesBundle\Test\FixturesTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Mailer\MailerInterface;

class CommentNotificationTest extends KernelTestCase
{
    use FixturesTrait;

    private Item $item;

    protected function setUp(): void
    {
        self::bootKernel();
        $this->loadFixtures([ItemFixture::class]);
        $repository = static::$container->get(ItemRepository::class);
        $this->item = $repository->findOneBy([]);
    }

    public function testNotify(): void
    {
        $symfonyMailer = $this->createMock(MailerInterface::class);
        $symfonyMailer->expects(self::once())->method('send');

        $comment = (new Comment())
            ->setItem($this->item)
            ->setEmail('test@email.acme')
            ->setMessage('test comment');

        $notification = new CommentNotification($symfonyMailer);
        $notification->notify($comment);
    }
}

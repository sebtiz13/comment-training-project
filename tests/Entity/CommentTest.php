<?php

declare(strict_types=0);

namespace App\Tests\Entity;

use App\Entity\Comment;
use App\Entity\Item;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommentTest extends KernelTestCase
{

    public function getEntity(): Comment
    {
        return (new Comment())
            ->setEmail('test@email.com')
            ->setMessage('hello world')
            ->setItem(new Item());
    }

    private function assertHasErrors(Comment $comment, int $errors = 0): void
    {
        self::bootKernel();
        $error = self::$container->get('validator')->validate($comment);
        self::assertCount($errors, $error);
    }

    public function testValidEntity(): void
    {
        $comment = $this->getEntity();

        $this->assertHasErrors($comment);
    }

    public function testEmailValidation(): void
    {
        $comment = $this->getEntity()
            ->setEmail('');
        $this->assertHasErrors($comment, 1);

        $comment1 = $this->getEntity()
            ->setEmail(123);
        $this->assertHasErrors($comment1, 1);

        $comment2 = $this->getEntity()
            ->setEmail('aze');
        $this->assertHasErrors($comment2, 1);
    }

    public function testMessageValidation(): void
    {
        $comment = $this->getEntity()
            ->setMessage('');
        // Trigger 2 assertions (NotBlank and Length)
        $this->assertHasErrors($comment, 2);

        $comment1 = $this->getEntity()
            ->setMessage(123);
        $this->assertHasErrors($comment1, 1);

        $comment2 = $this->getEntity()
            ->setMessage('123');
        $this->assertHasErrors($comment2, 1);
    }

    public function testGetValues(): void
    {
        self::assertSame('test@email.com', $this->getEntity()->getEmail());
        self::assertSame('hello world', $this->getEntity()->getMessage());
        self::assertSame(Item::class, $this->getEntity()->getItem()::class);
    }
}

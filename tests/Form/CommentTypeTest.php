<?php

declare(strict_types=1);

namespace App\Tests\Form;

use App\Entity\Comment;
use App\Form\CommentType;
use Symfony\Component\Form\Test\TypeTestCase;

class CommentTypeTest extends TypeTestCase
{
    public function testSubmitValidData(): void
    {
        $formData = [
            'email' => 'test@email.com',
            'message' => 'test message',
        ];
        $expected = (new Comment())
            ->setEmail($formData['email'])
            ->setMessage($formData['message']);

        $comment = new Comment();
        $form = $this->factory->create(CommentType::class, $comment);
        $form->submit($formData);

        self::assertTrue($form->isSynchronized());
        self::assertEquals($expected, $comment);
    }
}

<?php

declare(strict_types=1);

namespace App\Notification;

use App\Entity\Comment;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;

class CommentNotification
{
    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function notify(Comment $comment): void
    {
        $email = (new TemplatedEmail())
            ->from((string) $comment->getEmail())
            ->to('no-reply@acme-corp.com')
            ->htmlTemplate('emails/comment.html.twig')
            ->context(compact('comment'));

        $this->mailer->send($email);
    }
}

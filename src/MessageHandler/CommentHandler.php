<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Comment;
use App\Notification\CommentNotification;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

/**
 * Custom handler for comment just for exercise
 * In real it's more simple to set "SendEmailMessage" in a messenger
 * to send mail asynchronously.
 */
class CommentHandler implements MessageHandlerInterface
{
    public function __construct(
        private CommentNotification $notification
    ) {
    }

    public function __invoke(Comment $comment): void
    {
        /* The exceptions are handled by messenger with retry */
        /* @noinspection PhpUnhandledExceptionInspection */
        $this->notification->notify($comment);
    }
}

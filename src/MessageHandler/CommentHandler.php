<?php

declare(strict_types=1);

namespace App\MessageHandler;

use App\Entity\Comment;
use App\Notification\CommentNotification;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mercure\PublisherInterface;
use Symfony\Component\Mercure\Update;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Custom handler for comment just for exercise
 * In real it's more simple to set "SendEmailMessage" in a messenger
 * to send mail asynchronously.
 */
class CommentHandler implements MessageHandlerInterface
{
    public function __construct(
        private CommentNotification $notification,
        private PublisherInterface $publisher,
    ) {
    }

    public function __invoke(Comment $comment): void
    {
        $publisher = $this->publisher;
        $serializer = new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
        $commentToken = $comment->getToken();
        try {
            $this->notification->notify($comment);
            $update = new Update('http://localhost:3000/comment/'.$commentToken, $serializer->serialize([
                'status' => 'success',
                'message' => 'Your comment has been delivered',
            ], 'json'));
            $publisher($update);
        } catch (TransportExceptionInterface $error) {
            $update = new Update('http://localhost:3000/comment/'.$commentToken, $serializer->serialize([
                'status' => 'error',
                'message' => 'Error during delivery your comment, I retry later',
            ], 'json'));
            $publisher($update);
            /* The exceptions are handled by messenger with retry */
            /* @noinspection PhpUnhandledExceptionInspection */
            throw $error;
        }
    }
}

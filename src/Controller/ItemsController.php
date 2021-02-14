<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Notification\CommentNotification;
use App\Repository\ItemRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{
    public function __construct(
        private ItemRepository $repository,
    ) {
    }

    /**
     * @Route("/items", name="items.index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        $items = $paginator->paginate(
            $this->repository->findAllWithImageQuery(),
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('items/index.html.twig', [
            'current_menu' => 'items',
            'items' => $items,
        ]);
    }

    /**
     * @Route("/item/{slug}", name="item.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(string $slug, Request $request, CommentNotification $notification): Response
    {
        $item = $this->repository->findOneBy(['slug' => $slug]);

        $comment = new Comment();
        $comment->setItem($item);
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $notification->notify($comment);
                $this->addFlash('email.success', 'Your comment has been sent');

                // return $this->redirectToRoute('item.show', ['slug' => $slug]);
            } catch (TransportExceptionInterface) {
                $this->addFlash('email.error', 'Error during send email');
            }
        }

        return $this->render('items/show.html.twig', [
            'current_menu' => 'items',
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }
}

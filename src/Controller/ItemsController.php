<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\ItemRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
    public function show(string $slug, Request $request): Response
    {
        $item = $this->repository->findOneBy(['slug' => $slug]);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $isValid = $form->isValid();
            if ($isValid) {
                $comment->setItem($item);
                $comment->setToken($request->request->get('comment')['_token']);
                $this->dispatchMessage($comment);

                if (!$request->isXmlHttpRequest()) {
                    $this->addFlash('email.success', 'Your comment has been sent');
                }
            }

            // In case of ajax submit return simple response
            if ($request->isXmlHttpRequest()) {
                return new Response($isValid ? 'true' : 'false');
            }
            return $this->redirectToRoute('item.show', ['slug' => $slug]);
        }

        return $this->render('items/show.html.twig', [
            'current_menu' => 'items',
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }
}

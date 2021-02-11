<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\ItemRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(): Response
    {
        $items = $this->repository->findAllWithImage(limit: -1);

        return $this->render('items/index.html.twig', [
            'current_menu' => 'items',
            'items' => $items,
        ]);
    }

    /**
     * @Route("/item/{slug}", name="item.show", requirements={"slug": "[a-z0-9\-]*"})
     */
    public function show(string $slug): Response
    {
        $item = $this->repository->findOneBy(['slug' => $slug]);

        return $this->render('items/show.html.twig', [
            'item' => $item,
            'current_menu' => 'items',
        ]);
    }
}

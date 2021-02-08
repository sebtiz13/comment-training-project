<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ItemsController extends AbstractController
{
    /**
     * @Route("/items", name="items.index")
     */
    public function index(): Response
    {
        return $this->render('items/index.html.twig', [
            'current_menu' => 'items',
        ]);
    }
}

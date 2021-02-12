<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Entity\Item;
use App\Form\ItemType;
use App\Repository\ItemRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminItemController extends AbstractController
{
    public function __construct(
        private ItemRepository $repository,
        private EntityManagerInterface $em,
    ) {
    }

    /**
     * @Route("/admin", name="admin.items.home")
     */
    public function index(): Response
    {
        $items = $this->repository->findAll();

        return $this->render('admin/items/index.html.twig', compact('items'));
    }

    /**
     * @Route("/admin/item/create", name="admin.items.create")
     */
    public function new(Request $request): Response
    {
        $item = new Item();
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $item->getTitle();

            $this->em->persist($item);
            $this->em->flush();

            $this->addFlash('success', "The item \"${title}\" has been created");

            return $this->redirectToRoute('admin.items.home');
        }

        return $this->render('admin/items/manage.html.twig', [
            'new' => true,
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/item/{id}", name="admin.items.edit", methods="GET|POST")
     */
    public function edit(Item $item, Request $request): Response
    {
        $form = $this->createForm(ItemType::class, $item);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $title = $item->getTitle();

            $this->em->flush();

            $this->addFlash('success', "The item \"${title}\" has been edited");

            return $this->redirectToRoute('admin.items.home');
        }

        return $this->render('admin/items/manage.html.twig', [
            'item' => $item,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/item/{id}", name="admin.items.delete", methods="DELETE")
     */
    public function delete(Item $item, Request $request): Response
    {
        if ($this->isCsrfTokenValid('delete'.$item->getId(), $request->get('_token'))) {
            $title = $item->getTitle();

            $this->em->remove($item);
            $this->em->flush();

            $this->addFlash('success', "The item \"${title}\" has been deleted");
        }

        return $this->redirectToRoute('admin.items.home');
    }
}

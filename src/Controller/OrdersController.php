<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Orders;
use App\Entity\ProductsOrders;
use App\Form\OrdersType;
use App\Repository\CartRepository;
use App\Repository\OrdersRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Constraints\Date;

class OrdersController extends AbstractController
{
    #[Route('/neword', name: 'app_orders_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Orders();
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orders/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_orders_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Orders $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrdersType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_orders_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('orders/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/placeorder', name: 'app_orders_place', methods: ['GET'])]
    public function placeOrder(EntityManagerInterface $entityManager, Request $request): Response
    {
        $user = $this->getUser();

        $cartRepository = $entityManager->getRepository(Cart::class);

        $cartItems = $cartRepository->findBy(['user' => $user]);

        if ($cartItems == []) {
            return $this->redirectToRoute('app_home');
        }

        $order = new Orders();

        foreach ($cartItems as $cartItem) {
        
            $product = $cartItem->getProducts();

            $productOrder = new ProductsOrders();

            $productOrder->setQuantity($cartItem->getQuantity());
            $productOrder->setOrder($order);
            $productOrder->setProduct($product);
            $entityManager->remove($cartItem);
            $entityManager->persist($productOrder);
        }

        $order->setOrderNumber(rand(10000, 99999));
        $order->setDate(new DateTime());

        $order->setUser($user);

        $entityManager->persist($order);

        $entityManager->flush();

        $this->addFlash('success', "Votre commande a bien été passée !");
        return $this->redirectToRoute('app_home');
    }
}
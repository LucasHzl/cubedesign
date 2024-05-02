<?php

namespace App\Controller;

use App\Entity\Cart;
use App\Entity\Users;
use App\Entity\Products;
use App\Form\CartType;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Response;


class CartController extends AbstractController
{
    #[Route('/hhhhhh', name: 'app_cart_hhh', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cart = new Cart();
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cart);
            $entityManager->flush();

            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cart/new.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }

    #[Route('/ffffff', name: 'app_cart_show', methods: ['GET'])]
    public function show(Cart $cart): Response
    {
        return $this->render('cart/show.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_cart_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CartType::class, $cart);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('cart/edit.html.twig', [
            'cart' => $cart,
            'form' => $form,
        ]);
    }

    #[Route('/oooooo', name: 'hhbhjbkjbb', methods: ['POST'])]
    public function delete(Request $request, Cart $cart, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $cart->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($cart);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_cart_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/cart', name: 'app_cart', methods: ['GET'])]
    public function index(CartRepository $cartRepository, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        $cartRepository = $entityManager->getRepository(Cart::class);

        $userCart = $cartRepository->findBy(['user' => $user]);

        return $this->render('cart/cart.html.twig', ['userCart' => $userCart]);
    }

    #[Route('/product/{id}/addtocart', name: 'app_cart_add', methods: ['GET'])]
    public function addToCart($id, Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();

        $productsRepository = $entityManager->getRepository(Products::class);

        $product = $productsRepository->findOneBy(['id' => $id]);
        if ($product == null) {
            $this->addFlash('info', "Le produit que vous essayer d'ajouter au panier n'existe pas !");
            $products = $productsRepository->findAll();
            return $this->redirectToRoute('app_home');

        }
        $product->setStock($product->getStock() - 1);

        $cartRepository = $entityManager->getRepository(Cart::class);
        $cart = $cartRepository->findOneBy([
            'user' => $user->getId(),
            'product' => $product
        ]);
        if ($cart == null) {
            $cart = new Cart();
            $cart->setProducts($product);
            $cart->setQuantity(1);
            $cart->setUser($user);
        } else {
            $cart->setQuantity($cart->getQuantity()+1);
        }

        $entityManager->persist($cart);

        $entityManager->flush();

        $userCart = $cartRepository->findall(['user' => $user]);

        return $this->redirectToRoute('app_cart', [], 301);
    }

    #[Route('/deletefromcart/{id}', name: 'app_cart_delete', methods: ['GET'])]
    public function deleteFromCart($id, Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();

        $productsRepository = $entityManager->getRepository(Products::class);

        $product = $productsRepository->findOneBy(['id' => $id]);

        $product->setStock($product->getStock() + 1);

        $cartRepository = $entityManager->getRepository(Cart::class);

        $cart = $cartRepository->findOneBy([
            'user' => $user->getId(),
            'product' => $product
        ]);

        $entityManager->remove($cart);

        $entityManager->flush();

        $userCart = $cartRepository->findall(['user' => $user]);

        return $this->render('cart/cart.html.twig', ['userCart' => $userCart]);
    }
}

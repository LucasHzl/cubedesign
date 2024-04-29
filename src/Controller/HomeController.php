<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request as HttpFoundationRequest;



class HomeController extends AbstractController
{
     #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $productsRepository = $entityManager->getRepository(Products::class);

        $products = $productsRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'products' => $products,
        ]);
    }




    #[Route('/profil', name: 'app_profil')]
    public function profil(EntityManagerInterface $entityManager, HttpFoundationRequest $request): Response
    {
        $user = $this->getUser();

        return $this->render('users/profil.html.twig', [
            'controller_name' => 'HomeController',
            'user' => $user,
        ]);
    }
}

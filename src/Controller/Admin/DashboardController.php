<?php

namespace App\Controller\Admin;

use App\Entity\Categories;
use App\Entity\CustomersIdea;
use App\Entity\Messages;
use App\Entity\Orders;
use App\Entity\Products;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
         return $this->redirect($adminUrlGenerator->setController(UsersCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Cubedesign Dasheboard');
            // ->setlocales([langues])
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil', 'fa fa-home');


        yield MenuItem::section('Administration');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa-solid fa-user', Users::class);
        yield MenuItem::linkToCrud('Commandes', 'fa fa-file text', Orders::class);
        yield MenuItem::linkToCrud('Produits', 'fas fa-tags', Products::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-tags', Categories::class);
        yield MenuItem::linkToCrud('Messages', 'fas fa-tags', Messages::class);
        yield MenuItem::linkToCrud('Idées clients', 'fas fa-tags', CustomersIdea::class);
    }
}

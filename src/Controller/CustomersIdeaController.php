<?php

namespace App\Controller;

use App\Entity\CustomersIdea;
use App\Form\CustomersIdeaType;
use App\Repository\CustomersIdeaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class CustomersIdeaController extends AbstractController
{
    #[Route('/fefzefezfez', name: 'app_customers_idea_index', methods: ['GET'])]
    public function index(CustomersIdeaRepository $customersIdeaRepository): Response
    {
        return $this->render('customers_idea/index.html.twig', [
            'customers_ideas' => $customersIdeaRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_customers_idea_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $customersIdea = new CustomersIdea();
        $form = $this->createForm(CustomersIdeaType::class, $customersIdea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($customersIdea);
            $entityManager->flush();

            return $this->redirectToRoute('app_customers_idea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('customers_idea/new.html.twig', [
            'customers_idea' => $customersIdea,
            'form' => $form,
        ]);
    }

    #[Route('/ejfzejfezs', name: 'app_customers_idea_show', methods: ['GET'])]
    public function show(CustomersIdea $customersIdea): Response
    {
        return $this->render('customers_idea/show.html.twig', [
            'customers_idea' => $customersIdea,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_customers_idea_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CustomersIdea $customersIdea, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CustomersIdeaType::class, $customersIdea);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_customers_idea_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('customers_idea/edit.html.twig', [
            'customers_idea' => $customersIdea,
            'form' => $form,
        ]);
    }

    #[Route('/datfdyazvdh', name: 'app_customers_idea_delete', methods: ['POST'])]
    public function delete(Request $request, CustomersIdea $customersIdea, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$customersIdea->getId(), $request->getPayload()->get('_token'))) {
            $entityManager->remove($customersIdea);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_customers_idea_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/submitanidea', name: 'app_customers_idea_submit')]
    public function createThread(Request $request, EntityManagerInterface $entityManager): Response
    {
        $customersIdea = new CustomersIdea();

        $customersIdeaForm = $this->createForm(CustomersIdeaType::class, $customersIdea);

        $customersIdeaForm->handleRequest($request);


        if ($customersIdeaForm->isSubmitted() && $customersIdeaForm->isValid()) {

            $entityManager->persist($customersIdea);
            $entityManager->flush();
            $this->addFlash('success', "Votre suggestion a bien été envoyée !");
            return $this->redirectToRoute('app_home');
        }

        
        return $this->render('customers_idea/customersIdeaForm.html.twig', [
            'customersIdeaForm' => $customersIdeaForm
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Messages;
use App\Form\MessagesFormType;
use App\Form\MessagesType;
use App\Repository\MessagesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class MessagesController extends AbstractController
{
    #[Route('/newmsg', name: 'app_messages_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Messages();
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($message);
            $entityManager->flush();

            return $this->redirectToRoute('app_messages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('messages/new.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_messages_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Messages $message, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(MessagesType::class, $message);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_messages_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('messages/edit.html.twig', [
            'message' => $message,
            'form' => $form,
        ]);
    }

    #[Route('/contact', name: 'app_contact')]
    public function createThread(Request $request, EntityManagerInterface $entityManager): Response
    {
        $message = new Messages();

        $MessagesForm = $this->createForm(MessagesFormType::class, $message);

        $MessagesForm->handleRequest($request);


        if ($MessagesForm->isSubmitted() && $MessagesForm->isValid()) {

            $entityManager->persist($message);
            $entityManager->flush();
            $this->addFlash('success', "Votre message a bien été envoyée !");
            return $this->redirectToRoute('app_home');
        }

        return $this->render('messages/messagesForm.html.twig', [
            'MessagesForm' => $MessagesForm
        ]);
    }
}

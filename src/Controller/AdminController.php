<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Entity\User;
use App\Form\newNotificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.index")
     */
    public function index()
    {
        return $this->render('admin/home/index.html.twig');
    }

    /**
     * @Route("/admin/new-notification", name="admin.new-notification")
     * @param Request $request
     * @return Response
     */
    public function newNotification(Request $request)
    {
        /* Create & Generate Form */
        $notification = new Notification();
        $form = $this->createForm(newNotificationType::class, $notification);

        /* Submit Form Method */
        $form->handleRequest($request); // Récupération des Paramètres (POST/GET)
        if($form->isSubmitted() && $form->isValid()){

            $notification
                ->setNotifTitle($form->get('Notif_Title')->getData())
                ->setNotifText($form->get('Notif_Text')->getData())
                ->setNotifDate()
            ;

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($notification); // Création Requête avec les données ci-dessus
            $entityManager->flush(); // Envoi de la Requête

            /* Redirection */
            return $this->redirectToRoute('admin.new-notification');

        }

        return $this->render('admin/notification/index.html.twig', [
            'newNotification' => $form->createView()
        ]);
    }
}
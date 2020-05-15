<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Notification;
use App\Form\newNotificationType;
use App\Entity\Food;
use App\Entity\Meal;
use App\Form\newFoodType;
use App\Form\NewMealType;
use App\Service\FileUploader;
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
     * @Route("/admin/new-notification", name="admin.newNotification")
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
            return $this->redirectToRoute('admin.newNotification');

        }

        return $this->render('admin/notification/index.html.twig', [
            'newNotification' => $form->createView()
        ]);
    }

   /**
     * @Route("/admin/new-food", name="admin.newFood")
     * @param Request $request
     * @param FileUploader $fileUploader
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newFood(Request $request, FileUploader $fileUploader)
    {
        $food = new Food();
        $form = $this->createForm(newFoodType::class, $food);
        $form->handleRequest($request);

        /** @var Food $foodData */
        $foodData = $form->getData();

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $food->setTitle($foodData->getTitle());
            $food->setCategory($foodData->getCategory());
            $food->setInformation($form->get('information')->getData());
            $profilePicture = $form->get('picture')->getData();
            if($profilePicture) {
                $pictureFileName = $fileUploader->upload($profilePicture);
                $food->setPicture($pictureFileName);
            }
            $em->persist($food);
            $em->flush();

            return $this->redirectToRoute('admin.newFood');
        }

        return $this->render('admin/newFood.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/new-meal", name="admin.newMeal", options={"expose"=true})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newMeal(Request $request)
    {
        return $this->render('admin/newMeal.html.twig');
    }
}

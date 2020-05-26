<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Notification;
use App\Form\newNotificationType;
use App\Entity\Food;
use App\Entity\Meal;
use App\Form\newFoodType;
use App\Form\NewMealType;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package App\Controller
 * @Route("/admin", name="admin.")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="index")
     */
    public function index()
    {
        return $this->render('admin/home/index.html.twig');
    }

    /**
     * @Route("/new-notification", name="newNotification")
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
     * @Route("/notifications", name="notifications")
     * @return Response
     */
    public function listNotification()
    {
        return $this->render('admin/notification/list.html.twig');
    }

   /**
     * @Route("/new-food", name="newFood")
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
     * @Route("/new-meal", name="newMeal", options={"expose"=true})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newMeal(Request $request)
    {
        return $this->render('admin/newMeal.html.twig');
    }

    /**
     * @Route("/new-booking", name="newBooking")
     * @return Response
     */
    public function newBooking()
    {
        return $this->render('admin/newBooking.html.twig');
    }

    /**
     * @Route("/utilisateurs", name="listeUtilisateur", methods={"GET"})
     * @param UserRepository $userRepository
     * @return Response
     */
    public function listUser(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    /**
     * @Route("/utilisateur/{id}", name="infosUtilisateur", methods={"GET"})
     * @param User $user
     * @return Response
     */
    public function showUser(User $user): Response
    {
        return $this->render('admin/user/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/modifier", name="editerUtilisateur", methods={"GET","POST"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function editUser(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin.listeUtilisateur');
        }

        return $this->render('admin/user/edit.html.twig', [
            'user' => $user,
            'formEditUser' => $form->createView(),
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/supprimer", name="supprimerUtilisateur", methods={"DELETE"})
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function deleteUser(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin.listeUtilisateur');
    }
}
<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\User;
use App\Entity\Platlike;
use App\Form\newFoodType;
use App\Entity\UserSearch;
use App\Entity\Notification;
use App\Form\UserSearchType;
use App\Service\FileUploader;
use App\Form\newNotificationType;
use App\Repository\FoodRepository;
use App\Repository\UserRepository;
use App\Repository\PlatlikeRepository;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
+  * Require ROLE_ADMIN for *every* controller method in this class.
+  *
+  * 
+  */

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin.index")
     */
    public function index(UserRepository $user, PaginatorInterface $paginator, Request $request)
    {
        $users = $paginator->paginate(
            $user->findAll(),
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('admin/home/index.html.twig', [
            'users' => $users
        ]);
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
        if ($form->isSubmitted() && $form->isValid()) {

            $notification
                ->setNotifTitle($form->get('Notif_Title')->getData())
                ->setNotifText($form->get('Notif_Text')->getData())
                ->setNotifDate();

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
     * @param $fileUploader
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function newFood(Request $request, FileUploader $fileUploader)
    {
        $food = new Food();
        $form = $this->createForm(newFoodType::class, $food);
        $form->handleRequest($request);

        /** @var Food $foodData */
        $foodData = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $food->setTitle($foodData->getTitle());
            $food->setCategory($foodData->getCategory());
            $profilePicture = $form->get('picture')->getData();
            if ($profilePicture) {
                $pictureFileName = $fileUploader->upload($profilePicture);
                $food->setPicture($pictureFileName);
            }
            $em->persist($food);
            $em->flush();
        }

        return $this->render('admin/newFood.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/users", name="admin.users")
     * 
     * Cette fonction retourne la liste de tous les utilisateurs de l'application
     * 
     */
    public function usersList(UserRepository $repo, PaginatorInterface $paginator, Request $request)
    {
        $search = new UserSearch();
        $form = $this->createForm(UserSearchType::class, $search);
        $form->handleRequest($request);

        $users = $paginator->paginate(
            $repo->findUser($search),
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('admin/users.html.twig', [

            'users' => $users,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("admin/user/{id}", name="admin.show_user", methods="GET")
     * 
     * Cette fonction nous permet de voir le profil d'un utilisateur
     * 
     * @return Response
     * 
     */
    public function showUser(User $user): Response
    {

        return $this->render('admin/show_user.html.twig', [

            'user' => $user
        ]);
    }

    /**
     * @Route("admin/profil", name="admin.show_profil", methods="GET")
     * 
     * Cette fonction nous permet de voir le profil d'un utilisateur
     * 
     * @return Response
     * 
     */
    public function showProfilAdmin(UserRepository $user): Response
    {
        $user = $this->getUser();

        return $this->render('admin/show_profil.html.twig', [

            'user' => $user
        ]);
    }


    /**
     * Cette fonction permet de modifier le mot de passe de l'utilisateur actuel
     */

    public function change_user_password(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $old_password = $request->get('old_password');

        $new_password = $request->get('new_password');

        $new_password_confirm = $request->get('new_password_confirm');

        $user = $this->getUser();

        $checkPass = $passwordEncoder->isPasswordValid($user, $old_password);

        if ($checkPass === true) {

            $new_pwd_encoded = $passwordEncoder->encodePassword($user, $new_password_confirm);
        } else {
            return new JsonResponse(array('error' => 'Le mot de passe actuel est incorrect'));
        }
    }

    /**
     * @Route("/logout", name="app_logout")
     *
     * @return void
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will e inercepted by the logout key on your firewall.');
    }
}

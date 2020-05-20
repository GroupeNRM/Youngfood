<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\User;
use App\Form\NewChildType;
use App\Form\UpdatePasswordType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard.index", options={"expose"=true})
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController'
        ]);
    }

    /**
     * @Route("/dashboard/newchild", name="dashboard.newchild")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function newChild(Request $request)
    {
        /* Create & Generate Form */
        $child = new Child(); // Nouvelle Objet de l'Entité Child
        $form = $this->createForm(NewChildType::class, $child); // Génération du Form à partir du fichier Form

        /* Submit Form Method */
        $form->handleRequest($request); // Récupération des Paramètres (POST/GET)
        if($form->isSubmitted() && $form->isValid()){

            $child
                ->setNom($form->get('nom')->getData()) // Récupération Data Nom du Form
                ->setPrenom($form->get('prenom')->getData()) // Récupération Data Prénom du Form
                ->setDateNaissance($form->get('dateNaissance')->getData()) // Récupération Data Date de Naissance du Form
                ->setDateInscription()
                ->setNoUser($this->getUser())
            ;

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($child); // Création Requête avec les données ci-dessus
            $entityManager->flush(); // Envoi de la Requête

            /* Redirection */
            return $this->redirectToRoute('dashboard.newchild');

        }

        return $this->render('dashboard/newchild.html.twig', [
            'addChildForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/dashboard/update-password", name="dashboard.updatePassword")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(UpdatePasswordType::class); // Génération du Form à partir du fichier Form

        return $this->render('dashboard/updatepassword.html.twig', [
            'updatePasswordForm' => $form->createView()
        ]);
    }
}
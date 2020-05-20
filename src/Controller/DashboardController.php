<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\User;
use App\Form\NewChildType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package App\Controller
 * @Route("/dashboard", name="dashboard.")
 */
class DashboardController extends AbstractController
{
    /**
     * @Route("/", name="index", options={"expose"=true})
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController'
        ]);
    }

    /**
     * @Route("/newchild", name="newchild")
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
     * @Route("/new-booking", name="parentNewBooking")
     */
    public function newBooking()
    {
        return $this->render("dashboard/parentNewBooking/index.html.twig");
    }
}

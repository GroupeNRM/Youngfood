<?php

namespace App\Controller;

use App\Entity\Child;
use App\Entity\Meal;
use App\Entity\User;
use App\Form\NewChildType;
use Symfony\Component\Form\FormError;
use App\Form\NewChildType;
use App\Form\UpdatePasswordType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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
        return $this->render('dashboard/index.html.twig');
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

    /**
     * @param UserInterface $user
     * @return JsonResponse
     * @Route("/user-connected", name="userConnected")
     * Petite fonction renvoyant l'ID de l'utilisateur connecté, utile pour la partie Front
     */
    public function getConnectedUserId(UserInterface $user): JsonResponse
    {
        $userId = $user->getId();
        $response = new JsonResponse();
        $response->setData(['id' => $userId]);
        return $response;
    }

     * @Route("/dashboard/update-password", name="dashboard.updatePassword")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return RedirectResponse|Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $form = $this->createForm(UpdatePasswordType::class, $user); // Génération du Form à partir du fichier Form
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $oldPwd = $form->get('old_password')->getData(); // Récupération Données Ancien Mdp
            $newPwd = $form->get('new_password')->getData(); // Récupération Données Nouveau Mot de Passe
            $checkPass = $passwordEncoder->isPasswordValid($user, $oldPwd);

            /* Vérifier si Ancien Mdp est Bon */
            if($checkPass){
                $newEncodedPwd = $passwordEncoder->encodePassword($user, $newPwd);
                $user->setPassword($newEncodedPwd);

                $em->persist($user);
                $em->flush();
                $this->addFlash('notice', 'Votre mot de passe à bien été changé !');

                return $this->redirectToRoute('dashboard.index');
            }else{
                $form->addError(new FormError('Ancien mot de passe incorrect'));
            }
        }

        return $this->render('dashboard/updatepassword.html.twig', [
            'updatePasswordForm' => $form->createView()
        ]);
    }
}

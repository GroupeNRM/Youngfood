<?php

namespace App\Controller;

use App\Entity\Food;
use App\Form\newFoodType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\FileUploader;

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

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $food->setTitle($foodData->getTitle());
            $food->setCategory($foodData->getCategory());
            $profilePicture = $form->get('picture')->getData();
            if($profilePicture) {
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
}

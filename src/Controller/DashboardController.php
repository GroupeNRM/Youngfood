<?php

namespace App\Controller;

use App\Entity\Child;
use App\Form\NewChildType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app_dashboard")
     */
    public function index()
    {
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController'
        ]);
    }

    /**
     * @Route("/dashboard/newchild", name="dashboard.newchild")
     */
    public function newChild()
    {
        $child = new Child();
        $form = $this->createForm(NewChildType::class, $child);

        return $this->render('dashboard/newchild.html.twig', [
            'controller_name' => 'DashboardController',
            'addChildForm' => $form->createView()
        ]);
        //throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}

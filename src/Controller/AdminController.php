<?php

namespace App\Controller;

use App\Entity\Notification;
use App\Form\newNotificationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
     * @Route("/admin/dashboard/new-notification", name="admin.new-notification")
     */
    public function newNotification()
    {
        $notification = new Notification();
        $form = $this->createForm(newNotificationType::class, $notification);

        return $this->render('admin/notification/index.html.twig', [
            'newNotification' => $form->createView()
        ]);
    }
}

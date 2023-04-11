<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProfileController extends AbstractController
{
    #[Route('/admin/profile', name: 'app_admin_profile')]
    public function index(): Response
    {
        return $this->render('admin_profile/index.html.twig', [
            'controller_name' => 'AdminProfileController',
        ]);
    }
}

<?php

namespace App\Controller\Admin\Home;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/admin/home', name: 'admin_home_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/admin/home/index.html.twig');
    }
}

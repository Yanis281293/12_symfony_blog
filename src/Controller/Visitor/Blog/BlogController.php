<?php

namespace App\Controller\Visitor\Blog;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'visitor_blog_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('pages/visitor/blog/index.html.twig');
    }
}

<?php

namespace App\Controller\Admin\Post;

use App\Entity\Post;
use App\Form\PostFormType;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    #[Route('/admin/post/list', name: 'admin_post_index', methods: ['GET'])]
    public function index(PostRepository $postRepository): Response
    {
        $posts = $postRepository->findAll();
        return $this->render('pages/admin/post/index.html.twig', [
            'posts'=> $posts
        ]);
    }

    #[Route('/admin/post/create', name: 'admin_post_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $post = new Post();

        $form = $this->createForm(PostFormType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Récupérons les données de l'utilisateur actuellement connecté dont le rôle est admin
            $admin = $this->getUser();

            $post->setUser($admin);
            $post->setIsPublished(false);

            $em->persist($post);
            $em->flush();

            $this->addFlash('success', 'L\'article a été ajoutée.');

            return $this->redirectToRoute('admin_post_index');
        }

        return $this->render('pages/admin/post/create.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

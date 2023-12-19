<?php

namespace App\Controller\Admin\Category;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CategoryController extends AbstractController
{
    #[Route('/admin/category/list', name: 'admin_category_index', methods: ['GET'])]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render('pages/admin/category/index.html.twig', [
            "categories" => $categories
        ]);
    }

    #[Route('/admin/category/create', name: 'admin_category_create', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $category = new Category();

        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash('success', 'La catégorie a été ajoutée.');

            return $this->redirectToRoute('admin_category_index');
        }

        return $this->render('pages/admin/category/create.html.twig', [
            "form" => $form->createView(),
        ]);
    }

    #[Route('/admin/category/{id<\d+>}/edit', name: 'admin_category_edit', methods: ['GET', 'PUT'])]
    public function edit(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(CategoryFormType::class, $category, [
            "method" => "PUT",
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($category);
            $em->flush();

            $this->addFlash("success", "Cette catégorie a été modifiée.");

            return $this->redirectToRoute("admin_category_index");
        }


        return $this->render('pages/admin/category/edit.html.twig', [
            "form" => $form->createView(),
            "category" => $category
        ]);
    }

    #[Route('/admin/category/{id<\d+>}/delete', name: 'admin_category_delete', methods:['DELETE'])]
    public function delete(Category $category, Request $request, EntityManagerInterface $em): Response
    {
        if ( $this->isCsrfTokenValid('delete_category_'.$category->getId(), $request->request->get('csrf_token')) ) 
        {
            $em->remove($category);
            $em->flush();

            $this->addFlash('success', "La catégorie a été supprimée.");
        }

        return $this->redirectToRoute('admin_category_index');
    }
}

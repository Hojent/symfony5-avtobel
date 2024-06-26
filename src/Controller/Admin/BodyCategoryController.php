<?php

namespace App\Controller\Admin;

use App\Entity\BodyCategory;
use App\Form\BodyCategoryType;
use App\Repository\BodyCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/body-category")
 */
class BodyCategoryController extends AbstractController
{
    /**
     * @Route("/", name="admin_body_category_index", methods={"GET"})
     */
    public function index(BodyCategoryRepository $categoryRepository): Response
    {
        return $this->render('admin/body-category/index.html.twig', [
            'categories' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_body_category_new", methods={"GET","POST"})
     */
    public function new(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {
        $entityManager = $doctrine->getManager();
        // just set up a fresh $task object (remove the example data)
        $category = new BodyCategory();

        $form = $this->createForm(BodyCategoryType::class, $category);

        $form->handleRequest($request);
        $errors = $form->getErrors();

        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            // but, the original `$task` variable has also been updated
            $category = $form->getData();
            $category->setCreatedTime(new \DateTime());
            $metatitle = $form->get('metatitle')->getData();
            $slug = $form->get('slug')->getData();
            if(empty($slug)) {
                $slug = $slugger->slug($form->get('title')->getData());
                $category->setSlug($slug);
            } else {
                $category->setSlug($slug);
            }

            if(empty($metatitle)) {
                $category->setMetatitle($form->get('title')->getData());
            } else {
                $category->setMetatitle($metatitle);
            }
            $image = $form->get('image')->getData();
            if ($image) {
                $category->setImage($image);
            }
            $entityManager->persist($category);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();

            return $this->redirectToRoute('admin_body_category_index');
        }

        return $this->renderForm('admin/body-category/new.html.twig', [
            'form' => $form,
            'errors' => $errors
        ]);
    }

    /**
     * @Route("/{id}", name="admin_body_category_show", methods={"GET"})
     */
    public function show(BodyCategory $category): Response
    {
        return $this->render('admin/body-category/show.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_body_category_edit", methods={"GET","POST"})
     */
    public function edit(ManagerRegistry $doctrine, Request $request, BodyCategory $category): Response
    {
       if (!$category) {
            throw $this->createNotFoundException(
                'No category found.'
            );
        }
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(BodyCategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
              $category = $form->getData();

            $entityManager->persist($category);
            $entityManager->flush();

            return $this->redirectToRoute('admin_body_category_index');
        }

        return $this->renderForm('admin/body-category/edit.html.twig', [
            'category' => $category,
            'form' => $form,
        ]);
    }

     /**
     * @Route("/{id}", name="admin_body_category_delete", methods={"POST"})
     */
    public function delete(Request $request, BodyCategory $category): Response
    {

        if ($this->isCsrfTokenValid('delete-body-category', $request->request->get('token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($category);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_body_category_index', [], Response::HTTP_SEE_OTHER);
    }

}

<?php

namespace App\Controller\Admin;

use App\Entity\Body;
use App\Form\BodyType;
use App\Repository\BodyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @Route("/admin/body")
 */
class BodyController extends AbstractController
{
    /**
     * @Route("/", name="admin_body_index", methods={"GET"})
     */
    public function index(BodyRepository $bodyRepository): Response
    {
        return $this->render('admin/body/index.html.twig', [
            'bodies' => $bodyRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_body_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $body = new Body();
        $form = $this->createForm(BodyType::class, $body);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($body);
            $entityManager->flush();

            return $this->redirectToRoute('admin_body_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/body/new.html.twig', [
            'body' => $body,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_body_show", methods={"GET"})
     */
    public function show(Body $body): Response
    {
        return $this->render('admin/body/show.html.twig', [
            'body' => $body,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_body_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Body $body, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(BodyType::class, $body);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_body_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/body/edit.html.twig', [
            'body' => $body,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_body_delete", methods={"POST"})
     */
    public function delete(Request $request, Body $body, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$body->getId(), $request->request->get('_token'))) {
            $entityManager->remove($body);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_body_index', [], Response::HTTP_SEE_OTHER);
    }
}

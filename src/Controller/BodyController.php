<?php

namespace App\Controller;

use App\Entity\Body;
use App\Entity\BodyCategory;
use App\Repository\BodyCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BodyController extends AbstractController
{
    /**
     * @Route("/body", name="app_body")
     */
    public function index(BodyCategoryRepository $repository): Response
    {
        $vendors = $repository->findAll();
        return $this->render('front/body/index.html.twig', [
            'vendors' => $vendors,
        ]);
    }

    /**
     * @Route("/body/{slug}", name="app_body_show", methods={"GET"})
     */
    public function bodyShow(Body $body): Response
    {
        return $this->render('front/body/body_show.html.twig', [
            'body' => $body,
        ]);
    }
}

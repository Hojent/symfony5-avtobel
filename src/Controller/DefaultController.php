<?php

namespace App\Controller;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(PostRepository $post): Response
    {
        $favs = $post->findBy(['featured' => true],['ordering' => 'ASC'], '3');
        return $this->render('front/index.html.twig', [
            'favs' => $favs,
        ]);
    }

    /**
     * @Route("/post/{alias}", name="post_show", methods={"GET"})
     */
    public function postShow(Post $post): Response
    {
        return $this->render('front/post_show.html.twig', [
            'post' => $post,
        ]);
    }
}

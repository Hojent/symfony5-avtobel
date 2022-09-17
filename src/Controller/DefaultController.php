<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="home", options={"sitemap" = true})
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

    /**
     * @Route("/posts/{category}", name="post_list", methods={"GET"})
     */
    public function postList(PostRepository $post, Category $category): Response
    {
        $posts = $post->findByCategory($category);
        return $this->render('front/post_list.html.twig', [
            'posts' => $posts,
            'category' => $category
        ]);
    }

    /**
     * @Route("/categories/{category}", name="categories_list", methods={"GET"})
     */
    public function categoriesList(CategoryRepository $repository, Category $category): Response
    {
        $children = $repository->findChildrenByParent($category);
        return $this->render('front/categories_list.html.twig', [
            'category' => $category,
            'children' => $children
        ]);
    }
}

<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\PostRepository;
use App\Repository\BodyCategoryRepository;
use App\Repository\BodyRepository;

class SitemapController extends AbstractController
{

    private $posts;
    private $categories;
    private $bodies;
    private $bodyCategories;

    public function __construct(PostRepository $posts, CategoryRepository $categories,
                                BodyCategoryRepository $bodyCategories)
    {
        $this->posts = $posts;
        $this->categories = $categories;
        $this->bodyCategories = $bodyCategories;
    }

    /**
     * @Route("/sitemap", name="sitemap", defaults={"_format"="xml"})
     */
    public function index(ManagerRegistry $doctrine, Request $request) : Response
    {
        $em = $doctrine->getManager();
        $categories = $this->categories->findActive();
        $listPosts = $this->posts->findActive();
        $bodyCategories = $this->bodyCategories->findActive();

        $response = new Response(
            $this->render('sitemap/sitemap.html.twig', [
                'posts' => $listPosts,
                'categories' => $categories,
                'bodies' => $bodyCategories
                //'hostname' => $hostname
            ]),
            200
        );
        return $response;
    }

    /**
     * @Route("/sitemap.xml", name="sitemapXml", defaults={"_format"="xml"})
     */
    public function indexXml(ManagerRegistry $doctrine,  Request $request): Response
    {
        $em = $doctrine->getManager();
        $urls = [];
        $hostname = $request->getSchemeAndHttpHost();

        // add static urls
        $urls[] = ['loc' => $this->generateUrl('home')];
        $urls[] = ['loc' => $this->generateUrl('app_body')];

        // add static urls with optional tags
        /*$urls[] = ['loc' => $this->generateUrl('fos_user_security_login'), 'changefreq' => 'monthly', 'priority' => '1.0');
        $urls[] = array('loc' => $this->generateUrl('cookie_policy'), 'lastmod' => '2018-01-01');*/

        // add dynamic urls, like blog posts from your DB

        foreach ($this->categories->findActive() as $category) {
            if (!$category->getParent()) {
                $urls[] = [
                    'loc' => $this->generateUrl('categories_list',
                        ['category' => $category->getId()])
                ];
                foreach ($this->categories->findChildrenByParent($category->getId())
                         as $item) {
                    $urls[] = [
                        'loc' => $this->generateUrl('categories_list',
                            ['category' => $item->getId()])
                    ];
                }
            }
        }

        foreach ($this->posts->findAll() as $post) {
            $urls[] = [
                'loc' => $this->generateUrl('post_show',
                    ['alias' => $post->getAlias()])
            ];
        }

        // add image urls
/*        $products = $em->getRepository('AppBundle:products')->findAll();
        foreach ($products as $item) {
            $images = array(
                'loc' => $item->getImagePath(), // URL to image
                'title' => $item->getTitle()    // Optional, text describing the image
            );

            $urls[] = array(
                'loc' => $this->generateUrl('single_product', array('slug' => $item->getProductSlug())),
                'image' => $images              // set the images for this product url
            );
        }*/


        // return response in XML format
        $response = new Response(
            $this->renderView('sitemap/index.html.twig', ['urls' => $urls,
                'hostname' => $hostname]),
            200
        );
        $response->headers->set('Content-Type', 'text/xml');

        return $response;

    }
}

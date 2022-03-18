<?php

namespace App\Controller\Admin;

use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Post;
use App\Form\PostType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin/posts")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="admin_post_index", methods={"GET"})
     */
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('admin/posts/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_post_new", methods={"GET","POST"})
     */
    public function new(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger): Response
    {
        $post = new Post();
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('images')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeImage = $slugger->slug($originalFilename);
                $newFilename = $safeImage . '-' . uniqid() . '.' . $image->guessExtension();
                // Move the file to the directory
                try {
                    $image->move(
                        $this->getParameter('app.images_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo 'file upload error';
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setImages($newFilename);
            }
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/posts/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_post_show", methods={"GET"})
     */
    public function show(Post $post): Response
    {
        return $this->render('admin/posts/show.html.twig', [
            'post' => $post,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_post_edit", methods={"GET","POST"})
     */
    public function edit(ManagerRegistry $doctrine, Request $request, Post $post, SluggerInterface $slugger): Response
    {
        $entityManager = $doctrine->getManager();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('images')->getData();
            if ($image) {
                $originalFilename = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeImage = $slugger->slug($originalFilename);
                $newFilename = $safeImage . '-' . uniqid() . '.' . $image->guessExtension();
                // Move the file to the directory
                try {
                    $image->move(
                        $this->getParameter('app.images_dir'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    echo 'file upload error';
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setImages($newFilename);
            }
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/posts/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_post_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}/ck_upload_img", name="ck_upload_img", methods={"POST"})
     */
    public function ckUploadImg(Request $request, SluggerInterface $slugger)
    {
        $ckImage = $request->files->get('upload');
        $originalFilename = pathinfo($ckImage->getClientOriginalName(), PATHINFO_FILENAME);
        // this is needed to safely include the file name as part of the URL
        $safeImage = $slugger->slug($originalFilename);
        $newFilename = $safeImage . '-' . uniqid() . '.' . $ckImage->guessExtension();
        // Move the file to the directory
        try {
            $ckImage->move(
                $this->getParameter('app.images_dir'),
                $newFilename);
                $CKEditorFuncNum = $request->get('CKEditorFuncNum');
            $url = 'public/assets/images/stories/illustration/'.$newFilename;
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum,'$url','$msg')</script>";
            echo $response;
        } catch (FileException $e) {
            return 'file upload error';
        }
    }

}

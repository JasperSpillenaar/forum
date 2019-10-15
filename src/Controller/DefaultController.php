<?php

namespace App\Controller;

use App\Entity\Post;
use App\Entity\Reaction;
use App\Entity\User;
use App\Form\CommentType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Post::class)->findBy(['approved' => true]);

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'allpost' => $entity,
            ]);
    }

    /**
     * @Route("/makepost/", name="yourpost")
     */
    public function declinedPost()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Post::class)->findBy(['approved' => false]);

        return $this->render('makepost/index.html.twig', [
            'allpost' => $entity,
        ]);
    }

    /**
     * @Route("/approvedpage/", name="approved")
     */
    public function approved()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Post::class)->findBy(['approved' => null]);

        return $this->render('default/approvedpage.html.twig', [
            'allpost' => $entity,
        ]);
    }

    /**
     * @Route("/accept/{id}", name="accept")
     */
    public function postaccept($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $post->setApproved(true);
        $em->persist($post);
        $em->flush();

        return $this->redirect('/');
    }

    /**
     * @Route("/decline/{id}", name="decline")
     */
    public function postdecline($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $this->getDoctrine()->getRepository(Post::class)->find($id);
        $em->remove($post);
        $em->flush();

        return $this->redirect('/');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function messagedelete($id)
    {
        $em = $this->getDoctrine()->getManager();
        $reaction = $this->getDoctrine()->getRepository(reaction::class)->find($id);
        $em->remove($reaction);
        $em->flush();

        return $this->redirect('/');
    }

    /**
     * @Route("/form/{id}", name="showpost")
     */
    public function showpost($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Post::class)->find($id);

        $comment = new Reaction();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($entity);
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush();
            return $this->redirect('/form/' . $id);
        }

        $comments = $this->getDoctrine()->getRepository(Reaction::class)->findBy(['Post' => $id]);

        return $this->render('default/showpost.html.twig', [
            'allpost' => $entity,
            'comment' => $comments,
            'form' => $form->createView()
        ]);
    }
}

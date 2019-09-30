<?php

namespace App\Controller;

use App\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Post::class)->findAll();

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'allpost' => $entity
            ]);
    }

    /**
     * @Route("/form/{id}", name="showpost")
     */
    public function showpost($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository(Post::class)->find($id);

        return $this->render('default/showpost.html.twig', [
            'allpost' => $entity
        ]);
    }
}

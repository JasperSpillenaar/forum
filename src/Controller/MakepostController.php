<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MakepostController extends AbstractController
{
    /**
     * @Route("/makepost", name="makepost")
     */
    public function index()
    {
        return $this->render('makepost/index.html.twig', [
            'controller_name' => 'MakepostController',
        ]);
    }
}

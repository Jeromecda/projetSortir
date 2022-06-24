<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestController extends AbstractController
{
    /**
     * isGranted("ROLE_ADMIN")
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('app_sortie_index');
    }
}

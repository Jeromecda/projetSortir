<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestFoundationController extends AbstractController
{
    /**
     * @Route("/test/foundation", name="app_test_foundation")
     */
    public function index(): Response
    {
        return $this->render('test_foundation/index.html.twig', [
            'controller_name' => 'TestFoundationController',
        ]);
    }
}

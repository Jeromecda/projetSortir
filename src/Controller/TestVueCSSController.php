<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TestVueCSSController extends AbstractController
{
    /**
     * @Route("/test/vue/c/s/s", name="app_test_vue_c_s_s")
     */
    public function index(): Response
    {
        return $this->render('test_vue_css/index.html.twig', [
            'controller_name' => 'TestVueCSSController',
        ]);
    }
}

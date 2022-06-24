<?php

namespace App\Controller;

use App\Entity\Site;
use App\Form\SiteType;
use App\Repository\SiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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

     /**
     * @Route("/test/foundation/form", name="app_test_foundation_form",methods={"GET", "POST"})
     */
    public function form(Request $request, SiteRepository $siteRepository): Response
    {
        $site = new Site();
        $siteForm = $this->createForm(SiteType::class, $site);
        $siteForm->handleRequest($request);
        if ($siteForm->isSubmitted() && $siteForm->isValid()) {
            $siteRepository->add($site, true);

            return $this->redirectToRoute('app_test_foundation', [], Response::HTTP_SEE_OTHER);
        }
       
        return $this->renderForm('test_foundation/index.html.twig', [
            "siteForm" => $site,
            'form' => $siteForm,
        ]);
    }
}

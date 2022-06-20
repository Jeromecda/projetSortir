<?php

namespace App\Controller;

use App\Repository\LieuRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\SerializerInterface;

class ApiController extends AbstractController
{
    /**
     * @Route("/api/{id}", name="app_api", methods={"GET"})
     */
    public function index(LieuRepository $lieuRepository, NormalizerInterface $normalizer, SerializerInterface $serializer, $id): Response
    {
        // $lieux = $lieuRepository->findAll();
        $lieux = $lieuRepository->findByVilleNoVille($id);
        // $lieuxNormalised = $normalizer->normalize($lieux, null, ['groups' => 'api']);
        // $json = json_encode($lieuxNormalised);
       
        // Alternativement on peut utiliser le serializer
        // $json = $serializer->serialize($lieux, 'json', ['groups' => 'api']);
        // $response = new Response($json, 200, ["Content-Type" => "application/json"]);
        // $response = new JsonResponse($json, 200, [], true);

        $response = $this->json($lieux, 200, [], ['groups' => 'api']);
        // $response->headers->set('Access-Control-Allow-Origin', '*');        
        return $response;
    }
}

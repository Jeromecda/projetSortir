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
        // Requete SQL des lieux dont la ville à l'id récupérée par le js.
        $lieux = $lieuRepository->findByVilleNoVille($id);

        //Normalisation : Transformation des objets lieux en tableaux
        //Restriction des paramètres pris en compte au groupe api pour éviter les références circulaires 
        // $lieuxNormalised = $normalizer->normalize($lieux, null, ['groups' => 'api']);
        //Encodage en json du tableau
        // $json = json_encode($lieuxNormalised);
       
        // Alternativement on peut utiliser le serializer
        // $json = $serializer->serialize($lieux, 'json', ['groups' => 'api']);

        // On construit la réponse précisant le json et la nature de la réponse
        // $response = new Response($json, 200, ["Content-Type" => "application/json"]);
        // $response = new JsonResponse($json, 200, [], true);

        //La serialisation complète peut être effectuée avec la fonction json en une seule ligne
        $response = $this->json($lieux, 200, [], ['groups' => 'api']);
        return $response;
    }
    // /**
    //  * @Route("/api/{id}", name="app_api", methods={"GET"})
    //  */
    // public function index(LieuRepository $lieuRepository, NormalizerInterface $normalizer, SerializerInterface $serializer, $id): Response
    // {
    //     // $lieux = $lieuRepository->findAll();
    //     $lieux = $lieuRepository->findByVilleNoVille($id);
    //     // $lieuxNormalised = $normalizer->normalize($lieux, null, ['groups' => 'api']);
    //     // $json = json_encode($lieuxNormalised);
       
    //     // Alternativement on peut utiliser le serializer
    //     // $json = $serializer->serialize($lieux, 'json', ['groups' => 'api']);
    //     // $response = new Response($json, 200, ["Content-Type" => "application/json"]);
    //     // $response = new JsonResponse($json, 200, [], true);

    //     $response = $this->json($lieux, 200, [], ['groups' => 'api']);
    //     // $response->headers->set('Access-Control-Allow-Origin', '*');        
    //     return $response;
    // }
    /**
     * @Route("/api/detail/{id}", name="app_api_detail", methods={"GET"})
     */
    public function detail(LieuRepository $lieuRepository, NormalizerInterface $normalizer, SerializerInterface $serializer, $id): Response
    {
        $lieu = $lieuRepository->findById($id);
        $response = $this->json($lieu, 200, [], ['groups' => 'api']);
        return $response;
    }
}

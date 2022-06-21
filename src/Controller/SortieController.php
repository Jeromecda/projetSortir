<?php

namespace App\Controller;

use App\Entity\Etat;
use App\Entity\Participant;
use App\Entity\Site;
use App\Entity\Sortie;
use App\Form\SortieType;
use App\Repository\EtatRepository;
use App\Repository\ParticipantRepository;
use App\Repository\SiteRepository;
use App\Repository\SortieRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

use function PHPUnit\Framework\isEmpty;
use function PHPUnit\Framework\isNull;

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{
    /**
     * @Route("/", name="app_sortie_index", methods={"GET", "POST"})
     */
    // public function index(SortieRepository $sortieRepository, Security): Response
    // {
    //     return $this->render('sortie/index.html.twig', [
    //         'sorties' => $sortieRepository->findAll(),
    //     ]);

    // }
    //     public function index(SortieRepository $sortieRepository, Security $security, ParticipantRepository $participantRepository, SiteRepository $siteRepository): Response
    //     {
    //         if (isset($_REQUEST['checkbox_orga'])) {
    //         $id = $security->getUser()->getParticipant()->getId();
    //         //var_dump($id);
    //         return $this->render('sortie/index.html.twig', [
    //             'sorties' => $sortieRepository->findByOrganisateur($id),
    //         ]);
    //     }
    //     if (isset($_REQUEST['checkbox_passees'])) {

    //         $sorties = $sortieRepository->findAll();

    //         $sorties_passees = array();
    //         foreach ($sorties as $sortie) {
    //             if (new DateTime(date('Y-m-d h:i:s')) > $sortie->getDatedebut()) {
    //                 array_push($sorties_passees, $sortie);
    //             }
    //         }
    //             //dd($sorties_passees);
    //         return $this->render('sortie/index.html.twig', [
    //             'sorties' => $sorties_passees,
    //         ]);
    //     }
    //     //sorites ou je suis inscris
    //     if (isset($_REQUEST['checkbox_inscris'])) {
    //         $id = $security->getUser()->getParticipant()->getId();
    //         $sorties = $sortieRepository->findAll();
    //         $sorties_inscription = array();
    //         foreach ($sorties as $sortie) {
    //             $participants = $participantRepository->findBySortie($sortie->getId());
    //            foreach($participants as $participant){
    //             if ($participant['id'] == $id) {
    //                    array_push($sorties_inscription, $sortie);
    //                }
    //            }
    //         }

    //         return $this->render('sortie/index.html.twig', [
    //             'sorties' => $sorties_inscription,
    //         ]);
    //     }
    //     //non inscris
    //     if (isset($_REQUEST['checkbox_non_inscris'])) {
    //         $id = $security->getUser()->getParticipant()->getId();
    //         $sorties = $sortieRepository->findAll();
    //         $sorties_inscription = array();
    //         foreach ($sorties as $sortie) {
    //             //flag pour ignorer les sorties quand inscrit
    //             $flag = false;
    //             $participants = $participantRepository->findBySortie($sortie->getId());
    //            foreach($participants as $participant){
    //                 if ($participant['id'] == $id) {
    //                     $flag = true;
    //                     break;
    //                 } 
    //             }
    //             if ($flag == true){
    //                 continue;
    //             }
    //             array_push($sorties_inscription, $sortie);
    //         }

    //         return $this->render('sortie/index.html.twig', [
    //             'sorties' => $sorties_inscription,
    //         ]);
    //     }
    //     //date('Y-m-d h:i:s')
    //     if(isset($_REQUEST['date_dateDebut'])){
    //         // $dateMin = strtotime($_GET['date_dateDebut']);
    //         // $date_formatted = date('Y-m-d h:i:s',$dateMin);
    //         $date_formatted = new DateTime($_GET['date_dateDebut']);
    //         $date_formatted_fin = new DateTime($_GET['date_dateFin']);
    //         //dd($dateMin);
    //         $sorties = $sortieRepository->findAll();
    //         $sorties_dateBetween = array();
    //             foreach($sorties as $sortie){
    //                 if($sortie->getDatedebut() > $date_formatted && $sortie->getDatedebut() < $date_formatted_fin){
    //                     array_push($sorties_dateBetween, $sortie);
    //                 }
    //             }
    //          return $this->render('sortie/index.html.twig', [
    //             'sorties' => $sorties_dateBetween,
    //         ]);   
    //     }
    //      //return liste complète des sorties
    //      return $this->render('sortie/index.html.twig', [
    //         'sorties' => $sortieRepository->findAll(),


    //     ]);
    // }

    public function index(SortieRepository $sortieRepository, Security $security, ParticipantRepository $participantRepository, SiteRepository $siteRepository): Response
    {
        if (isset($_REQUEST['checkbox_orga'])) {
            $check_orga = true;
            $id = $security->getUser()->getParticipant()->getId();
            //var_dump($id);
            return $this->render('sortie/index.html.twig', [
                'sorties' => $sortieRepository->findByOrganisateur($id), 'check_orga' => $check_orga,
            ]);
        }
        if (isset($_REQUEST['checkbox_passees'])) {
            $check_passees = true;
            $sorties = $sortieRepository->findAll();

            $sorties_passees = array();
            foreach ($sorties as $sortie) {
                if (new DateTime(date('Y-m-d h:i:s')) > $sortie->getDatedebut()) {
                    array_push($sorties_passees, $sortie);
                }
            }
            //dd($sorties_passees);
            return $this->render('sortie/index.html.twig', [
                'sorties' => $sorties_passees, 'check_passees' => $check_passees
            ]);
        }
        //sorites ou je suis inscris
        if (isset($_REQUEST['checkbox_inscris'])) {
            $check_inscris = true;
            $id = $security->getUser()->getParticipant()->getId();
            $sorties = $sortieRepository->findAll();
            $sorties_inscription = array();
            foreach ($sorties as $sortie) {
                $participants = $participantRepository->findBySortie($sortie->getId());
                foreach ($participants as $participant) {
                    if ($participant['id'] == $id) {
                        array_push($sorties_inscription, $sortie);
                    }
                }
            }

            return $this->render('sortie/index.html.twig', [
                'sorties' => $sorties_inscription, 'check_inscris' => $check_inscris,
            ]);
        }
        //non inscris
        if (isset($_REQUEST['checkbox_non_inscris'])) {
            $check_non_inscris = true;
            $id = $security->getUser()->getParticipant()->getId();
            $sorties = $sortieRepository->findAll();
            $sorties_inscription = array();
            foreach ($sorties as $sortie) {
                //flag pour ignorer les sorties quand inscrit
                $flag = false;
                $participants = $participantRepository->findBySortie($sortie->getId());
                foreach ($participants as $participant) {
                    if ($participant['id'] == $id) {
                        $flag = true;
                        break;
                    }
                }
                if ($flag == true) {
                    continue;
                }
                array_push($sorties_inscription, $sortie);
            }

            return $this->render('sortie/index.html.twig', [
                'sorties' => $sorties_inscription, 'check_non_inscris' => $check_non_inscris
            ]);
        }
        //date('Y-m-d h:i:s')
        if (isset($_GET['date_dateDebut'])) {
            // $dateMin = strtotime($_GET['date_dateDebut']);
            // $date_formatted = date('Y-m-d h:i:s',$dateMin);
            $date_formatted = new DateTime($_GET['date_dateDebut']);
            $date_formatted_fin = new DateTime($_GET['date_dateFin']);
            //dd($dateMin);
            $sorties = $sortieRepository->findAll();
            $sorties_dateBetween = array();
            foreach ($sorties as $sortie) {
                if ($sortie->getDatedebut() > $date_formatted && $sortie->getDatedebut() < $date_formatted_fin) {
                    array_push($sorties_dateBetween, $sortie);
                }
            }
            return $this->render('sortie/index.html.twig', [
                'sorties' => $sorties_dateBetween,
            ]);
        }

        //sorties suivant un site
        if (isset($_POST['select_site'])) {
            $site = $siteRepository->findOneById($_POST['select_site']);
      
            return  $this->render('sortie/index.html.twig', [
                'sites' => $siteRepository->findAll(),
                'sorties' => $sortieRepository->findBySiteOrganisateur($site),
            ]);
        } else {
            // dd('ne rentre pas');
        }

        return $this->render('sortie/index.html.twig', [
            'sorties' => $sortieRepository->findAll(),
            'sites' => $siteRepository->findAll(),
        ]);
    }


    /**  
     * @isGranted("ROLE_USER")
     * @Route("/new", name="app_sortie_new", methods={"GET", "POST"})
     */
    public function new(Request $request, SortieRepository $sortieRepository, Security $security, EtatRepository $etatRepository, EntityManagerInterface $em): Response
    {
        $user = $security->getUser();
        $etat = $etatRepository->find(1);
        $sortie = new Sortie($user, $etat);
        $form = $this->createForm(SortieType::class, $sortie);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $sortieRepository->add($sortie, true);

            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('sortie/new.html.twig', [
            'sortie' => $sortie,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_sortie_show", methods={"GET"})
     */
    public function show(Sortie $sortie, ParticipantRepository $participantRepository): Response
    {
        //Récupère des éléments par la fonction findBySortie custom DQL
        $participants = $participantRepository->findBySortie($sortie->getId());
        //TODO gérer affichage des participants
        //var_dump($participants);
        return $this->render('sortie/show.html.twig', [
            'sortie' => $sortie, 'participants' => $participants
        ]);
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/{id}/edit", name="app_sortie_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Sortie $sortie, SortieRepository $sortieRepository, Security $security, EntityManagerInterface $em): Response
    {
        // Si l'utilisateur est ADMIN ou organisateur de l'evenement il peut editer l evenement
        if ($this->isGranted('ROLE_ADMIN') || ($security->getUser()->getId() == $sortie->getOrganisateur()->getId())) {
            $form = $this->createForm(SortieType::class, $sortie);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $sortieRepository->add($sortie, true);

                return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
            }

            return $this->renderForm('sortie/edit.html.twig', [
                'sortie' => $sortie,
                'form' => $form,
            ]);
            // Si la date du jour est inférieure a la date de cloture un utilisateur peut s'inscrire

        } else {
            // dd($security->getUser());
            dd($sortie->getOrganisateur());
            // Afficher un message de confirmation d'inscription
            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/{id}/signout", name="app_sortie_signout", methods={"GET", "POST"})
     */
    public function signout(Request $request, Sortie $sortie, SortieRepository $sortieRepository, Security $security, EntityManagerInterface $em): Response
    {
        $user = $security->getUser()->getParticipant();
        // dd($user);
        $sortie->removeParticipant($user);
        $sortieRepository->add($sortie, true);

        // dd('participant enlevé ?');

        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @isGranted("ROLE_USER")
     * @Route("/{id}/signup", name="app_sortie_signup", methods={"GET", "POST"})
     */
    public function signup(Request $request, Sortie $sortie, SortieRepository $sortieRepository, Security $security, EntityManagerInterface $em): Response
    {
        $user = $security->getUser()->getParticipant();
        if (new DateTime(date('Y-m-d h:i:s')) < $sortie->getDatecloture()) {
            // dd($user);
            $sortie->addParticipant($user);
            $sortieRepository->add($sortie, true);
            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
        }
    }


    /**
     * isGranted("ROLE_USER")
     * @Route("/{id}", name="app_sortie_delete", methods={"POST"})
     */
    public function delete(Request $request, Sortie $sortie, SortieRepository $sortieRepository, Security $security): Response
    {
        if ($this->isGranted('ROLE_ADMIN') || ($security->getUser()->getId() == $sortie->getOrganisateur()->getId())) {
            if ($this->isCsrfTokenValid('delete' . $sortie->getId(), $request->request->get('_token'))) {
                $sortieRepository->remove($sortie, true);
            }
        }
        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }
}

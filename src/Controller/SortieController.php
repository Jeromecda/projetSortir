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

/**
 * @Route("/sortie")
 */
class SortieController extends AbstractController
{

     /**
      * @isGranted("ROLE_USER")
     * @Route("/", name="app_sortie_index", methods={"GET", "POST"})
     */
    public function index(SortieRepository $sortieRepository, Security $security, ParticipantRepository $participantRepository, SiteRepository $siteRepository): Response
    {
        $resultat_filtre = 0;
        $resultat_final = $sortieRepository->findAll();
        $check_orga = false;
        $check_inscris = false;
        $check_non_inscris = false;
        $check_passees = false;

        if (isset($_REQUEST['checkbox_orga'])) {
            // dd('STOP Selection ORGANISATEUR');
            $check_orga = true;
            $id = $security->getUser()->getParticipant()->getId();
            $resultat_filtre = $sortieRepository->findByOrganisateur($id);
            $resultat_final = $this->getResultat($resultat_final, $resultat_filtre);
        }
       
        //sorites ou je suis inscris
        if (isset($_REQUEST['checkbox_inscris'])) {
            // dd('STOP Selection inscrit');
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
            $resultat_filtre = $sorties_inscription;
            $resultat_final = $this->getResultat($resultat_final, $resultat_filtre);
        }

        //non inscris
        if (isset($_REQUEST['checkbox_non_inscris'])) {
            // dd('STOP Selection non-inscrit');
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
            $resultat_filtre = $sorties_inscription;
            $resultat_final = $this->getResultat($resultat_final, $resultat_filtre);
        }

        if (isset($_REQUEST['checkbox_passees'])) {
            // dd('STOP Selection passés');
            $check_passees = true;
            $sorties = $sortieRepository->findAll();

            $sorties_passees = array();
            foreach ($sorties as $sortie) {
                if (new DateTime(date('Y-m-d h:i:s')) > $sortie->getDatedebut()) {
                    array_push($sorties_passees, $sortie);
                }
            }
            $resultat_filtre = $sorties_passees;
            $resultat_final = $this->getResultat($resultat_final, $resultat_filtre);
        }

        //date('Y-m-d h:i:s')
        if (isset($_POST['date_dateDebut']) && !empty($_POST['date_dateDebut'])) {
            // dd('STOP Selection Date');
            $date_formatted = new DateTime($_POST['date_dateDebut']);
            $date_formatted_fin = new DateTime($_POST['date_dateFin']);
            $sorties = $sortieRepository->findAll();
            $sorties_dateBetween = array();
            var_dump($date_formatted);
            var_dump($date_formatted_fin);
            // var_dump($sortie->getDatedebut());

            foreach ($sorties as $sortie) {
                if ($sortie->getDatedebut() > $date_formatted && $sortie->getDatedebut() < $date_formatted_fin) {
                    array_push($sorties_dateBetween, $sortie);
                }
            }

            $resultat_filtre = $sorties_dateBetween;
            $resultat_final = $this->getResultat($resultat_final, $resultat_filtre);
        }

        //sorties suivant un site
        if (isset($_POST['select_site']) && $_POST['select_site'] != 0) {
            // dd('STOP Selection SITE');
            $site = $siteRepository->findOneById($_POST['select_site']);

            $resultat_filtre = $sortieRepository->findBySiteOrganisateur($site);
            $resultat_final = $this->getResultat($resultat_final, $resultat_filtre);
        }

        //champ de recherche
        if (isset($_POST["nom_sortie"]) && !empty($_POST["nom_sortie"])) {
            $nom_saisi = $_POST['nom_sortie'];
            $resultat_filtre = $sortieRepository->isLike($nom_saisi);
            $resultat_final = $this->getResultat($resultat_final, $resultat_filtre);
        }

        // var_dump($resultat_final);
        return $this->render('sortie/index.html.twig', [
            'sorties' => $resultat_final,
            'sites' => $siteRepository->findAll(),
            'check_orga' => $check_orga,
            'check_inscris' => $check_inscris,
            'check_non_inscris' => $check_non_inscris,
            'check_passees' => $check_passees,

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
            $this->addFlash('notice','La création de la sortie est réussie');

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
                $this->addFlash('notice','La modificationde la sortie est réussie');

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
                $this->addFlash('notice','La suppression de la sortie est réussie');
            }
        }
        return $this->redirectToRoute('app_sortie_index', [], Response::HTTP_SEE_OTHER);
    }

    public function research(SortieRepository $sortieRepository, SiteRepository $siteRepository)
    {
        $nom_saisi = $_POST['nom_sortie'];

        // dd($nom_saisi);
        // $sorties_filtrees = $sortieRepository->isLike($nom_saisi);

        return  $this->render('sortie/index.html.twig', [
            'sites' => $siteRepository->findAll(),
            'sorties' => $sortieRepository->isLike($nom_saisi),
        ]);
    }

    public function getResultat($liste_resultat_final, $liste_resultat_filtre)
    {
        $liste_resultat_temp = array();
        foreach ($liste_resultat_final as $resultat_final) {
            foreach ($liste_resultat_filtre as $resultat_filtre) {
                if ($resultat_final == $resultat_filtre) {
                    array_push($liste_resultat_temp, $resultat_filtre);
                }
            }
        }
        return $liste_resultat_temp;
    }
}

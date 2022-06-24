<?php

namespace App\Controller;

use App\Entity\Participant;
use App\Form\ParticipantType;
use App\Repository\ParticipantRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

/**
 * @isGranted("ROLE_USER")
 * @Route("/participant")
 */
class ParticipantController extends AbstractController
{
    /**
     * @Route("/{id}/registration", name="app_participant_registration", methods={"GET", "POST"})
     */

    // Formulaire d'inscription à une sortie pour un utilisateur
    public function registration(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participantRepository->add($participant, true);

            return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participant/sortieRegistration.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);

        //$user = $this->getDoctrine()->getRepository(Utilisateur::class)->find($id);
        // $utilisateur = $this->addParticipant(Participant $participant);
        // var_dump($utilisateur);
    }

    /**
     * @isGranted("ROLE_ADMIN")
     * @Route("/", name="app_participant_index", methods={"GET"})
     */
    public function index(ParticipantRepository $participantRepository, Security $security): Response
    {
        if (!$this->isGranted("ROLE_USER")) {
            return $this->redirectToRoute('app_login');
        }

        if ($this->isGranted("ROLE_ADMIN")){
            return $this->render('participant/index.html.twig', [
                'participants' => $participantRepository->findAll(),
            ]);
        }
        // if($this->isGranted("ROLE_ORGA"))
        // return $this->render('participant/index.html.twig', [
        //     'participants' => $participantRepository->findBySortie
        // ]);
        // dd($security->getUser()->getParticipant()->getId());
        $participants[] = $security->getUser()->getParticipant();
        return $this->render('participant/index.html.twig', [
            'participants' => $participants,
        ]);
    }

    /**
     * @Route("/new", name="app_participant_new", methods={"GET", "POST"})
     */
    public function new(Request $request, ParticipantRepository $participantRepository): Response
    {
        $participant = new Participant();
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participantRepository->add($participant, true);
            $this->addFlash('notice','La création du participant est réussie');

            return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participant/new.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_participant_show", methods={"GET"})
     */
    public function show(Participant $participant): Response
    {
        return $this->render('participant/show.html.twig', [
            'participant' => $participant,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_participant_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
        $form = $this->createForm(ParticipantType::class, $participant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $participantRepository->add($participant, true);
            $this->addFlash('notice','La modification est réussie');

            return $this->redirectToRoute('app_participant_edit', ['id' => $this->getUser()->getId(),], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('participant/edit.html.twig', [
            'participant' => $participant,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_participant_delete", methods={"POST"})
     */
    public function delete(Request $request, Participant $participant, ParticipantRepository $participantRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $participant->getId(), $request->request->get('_token'))) {
            $participantRepository->remove($participant, true);
            $this->addFlash('notice','La suppression du participant est réussie');
        }

        return $this->redirectToRoute('app_participant_index', [], Response::HTTP_SEE_OTHER);
    }
}

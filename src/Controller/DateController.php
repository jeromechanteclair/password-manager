<?php

namespace App\Controller;
use App\Entity\Date;
use App\Form\DateEntityType;
use App\Repository\CrewRepository;
use App\Repository\DateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\JsonResponse;
class DateController extends AbstractController
{
    /**
     * @Route("/crew/{id}/date", name="date")
     */
    public function index()
    {
        return $this->render('date/index.html.twig', [
            'controller_name' => 'DateController',
        ]);
    }

    /**
     * @Route("/crew/{id}/date/new", name="date_new")
     */
    public function newDate($id,Request $request,CrewRepository $crewRepository,DateRepository $dateRepository): Response
    {
        $date = new Date();
        $nextid = $dateRepository->findnextInserted();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(DateEntityType::class, $date);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($date);
            $date->setCrew($crewRepository->find($id));
            $em->flush();
            $response = array(
            'status' => 'success',
            'message' => 'Date created',

        );

            return new JsonResponse($response);

        }

        return $this->render('date/new.html.twig', [
            'crewid' => $id,
            'form' => $form->createView(),
            'dateid'=>$nextid
        ]);
    }
}

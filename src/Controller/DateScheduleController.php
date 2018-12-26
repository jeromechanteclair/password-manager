<?php

namespace App\Controller;
use App\Entity\DateSchedule;
use App\Form\DateScheduleEntityType;
use App\Repository\DateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
 use Symfony\Component\HttpFoundation\JsonResponse;

class DateScheduleController extends AbstractController
{
    /**
     * @Route("/date/schedule", name="date_schedule")
     */
    public function index()
    {
        return $this->render('date_schedule/index.html.twig', [
            'controller_name' => 'DateScheduleController',
        ]);
    }


        /**
         * @Route("/crew/{crewid}/date/{dateid}/addschedule", name="date_schedule_new")
         */
        public function newDateSchedule($dateid,Request $request,DateRepository $dateRepository): Response
        {
            $dateSchedule = new DateSchedule();
            $user = $this->container->get('security.token_storage')->getToken()->getUser();
            $form = $this->createForm(DateScheduleEntityType::class, $dateSchedule);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($dateSchedule);
                $dateSchedule->setDate($dateRepository->find($dateid));
                $em->flush();
                $response = array(
                'status' => 'success',
                'message' => 'DateSchedule created',

            );

                return new JsonResponse($response);

            }

            return $this->render('date_schedule/new.html.twig', [

                'form' => $form->createView(),
            ]);
        }
}

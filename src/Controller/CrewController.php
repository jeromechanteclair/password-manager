<?php

namespace App\Controller;
use App\Entity\Crew;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\CrewType;
use App\Repository\CrewRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
class CrewController extends Controller
{
    /**
     * @Route("/crew/list", name="crew_list", methods="GET")
     */
    public function index()
    {
        return $this->render('crew/index.html.twig', [
            'controller_name' => 'CrewController',
        ]);
    }

    /**
     * @Route("/crew/new", name="crew_new", methods="GET|POST")
     */
    public function new(CrewRepository $crewRepository,Request $request): Response
    {
        $currentId = $crewRepository->findLastInserted()->getId()+1;
      
        $crew = new Crew();

        $form = $this->createForm(CrewType::class, $crew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($crew);
            $em->flush();

            return $this->redirectToRoute('crew_edit',array('id'=>$crew->getId()));
        }

        return $this->render('crew/new.html.twig', [
            'currentId'=>$currentId,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/crew/{id}/edit", name="crew_edit", methods="GET|POST")
     */
    public function edit(Request $request, Crew $crew): Response
    {
        $form = $this->createForm(CrewType::class, $crew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('crew_edit', ['id' => $crew->getId()]);
        }

        return $this->render('crew/edit.html.twig', [
            'crew' => $crew,
            'form' => $form->createView(),
        ]);
    }

}

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
 use Symfony\Component\HttpFoundation\JsonResponse;
class CrewController extends Controller
{


    /**
     * @Route("/crew/new", name="crew_new", methods="GET|POST")
     */
    public function newCrew(CrewRepository $crewRepository,Request $request): Response
    {

        if($crewRepository->findLastInserted() === null){
            $currentId = 1;
        }
        else{
            $currentId = $crewRepository->findLastInserted()->getId()+1;
        }
        $crew = new Crew();
        $user = $this->container->get('security.token_storage')->getToken()->getUser();
        $form = $this->createForm(CrewType::class, $crew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($crew);
            $crew->setOwner( $user );
            $em->flush();
            $response = array(
            'status' => 'success',
            'message' => 'crew created',
            'crewId'=> $crew->getId(),
            "currentId"=>$currentId,

        );

            return new JsonResponse($response);

        }

        return $this->render('crew/new.html.twig', [
            'currentId'=>$currentId,
            'form' => $form->createView(),
            'owner'=> $this->get('security.token_storage')->getToken()->getUser()
        ]);
    }

    /**
     * @Route("/crew/{id}/edit", name="crew_edit", methods="GET|POST")
     */
    public function edit(Request $request, Crew $crew): Response
    {
        $form = $this->createForm(CrewType::class, $crew);
        //$form->remove('users');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $response = array(
            'status' => 'success',
            'message' => 'crew edited',
            'crewId'=> $crew->getId(),
            "currentId"=>$crew->getId(),

        );

            return new JsonResponse($response);

            //return $this->redirectToRoute('crew_edit', ['id' => $crew->getId(),'currentId' => $crew->getId()]);
        }

        return $this->render('crew/edit.html.twig', [
            'crew' => $crew,
            'users'=>$crew->getUsers(),
            'form' => $form->createView(),
            'currentId' => $crew->getId(),
            'owner'=> $this->get('security.token_storage')->getToken()->getUser()
        ]);
    }
    /**
     * @Route("crew/{id}", name="crew_display", methods="GET")
     */
      public function showcrew(Crew $crew): Response
      {
          return $this->render('crew/index.html.twig', ['crew' => $crew]);
      }

}

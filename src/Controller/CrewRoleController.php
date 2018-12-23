<?php

namespace App\Controller;
use App\Entity\Crew;
use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\CrewRole;
use App\Form\CrewRoleType;
use App\Repository\CrewRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use JMS\Serializer\SerializationContext;

class CrewRoleController extends AbstractController
{
    /**
     * @Route("/crew/role", name="crew_role")
     */
    public function index()
    {
        return $this->render('crew_role/index.html.twig', [
            'controller_name' => 'CrewRoleController',
        ]);
    }

    /**
     * @Route("/crew/{crewid}/{userid}/{name}/role/add", name="crewrole_add", methods="GET|POST")
     */
    public function new($name, $userid,$crewid,CrewRepository $crewRepository,UserRepository $userRepository,Request $request): Response
    {

        $crewRole = new CrewRole();
        $user = $userRepository->find($userid);
        $crew = $crewRepository->find($crewid);
      //  $form = $this->createForm(CrewRoleType::class, $crewRole);
        //$form->handleRequest($request);
        $status = "error";
        $message = "";


            $em = $this->getDoctrine()->getManager();
              $em->persist($crewRole);
              $crewRole->setName($name);
              $crewRole->setCrew($crew);
              $crewRole->setUser($user);

            try {
                $em->flush();
                $status = "success";
                $message = "new crewrole saved";
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }

            $response = array(
            'status' => $status,
            'message' => $message
        );

            return new JsonResponse($response);



    }
}

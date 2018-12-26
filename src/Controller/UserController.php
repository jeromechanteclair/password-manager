<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
 use Symfony\Component\HttpFoundation\JsonResponse;
 use JMS\Serializer\SerializationContext;


/**
 * @Route("/user")
 */
class UserController extends Controller
{
    /**
     * @Route("/", name="user_index", methods="GET")
     */
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', ['users' => $userRepository->findAll()]);
    }

    /**
     * @Route("/search", name="user_search", methods="GET")
     */
    public function searchUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findAll();
        $currentLoggedUser = $this->get('security.token_storage')->getToken()->getUser();

        function unsetValue(array $array, $value, $strict = TRUE)
        {
            if(($key = array_search($value, $array, $strict)) !== FALSE) {
                unset($array[$key]);
            }
            return $array;
        }

        // unset currentLoggedUser from List
        $users =  unsetValue($users,$currentLoggedUser);
        //get list of Users, return Json
        $data = $this->get('jms_serializer')->serialize($users, 'json', SerializationContext::create()->setGroups(array('list')));
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');

        return $response;

    }

    /**
     * @Route("/new", name="user_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $status = "error";
        $message = "";
        $userId ="";
        $username ="";
        $useremail="";

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $user->setEnabled(1);
            $user->setPlainPassword('temp');
            $user->addRole('ROLE_ADMIN');
            try {
                $em->flush();
                $status = "success";
                $message = "new user saved";
                $userId = $user->getId();
                $username =$user->getUsername();
                $useremail=$user->getEmail();
            } catch (\Exception $e) {
                $message = $e->getMessage();
            }

            $response = array(
            'status' => $status,
            'message' => $message,
            'userId'=> $userId,
            "username"=>$username,
            'useremail'=>$useremail
        );

            return new JsonResponse($response);
        }

        return $this->render('user/new.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_show", methods="GET")
     */
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/{id}/edit", name="user_edit", methods="GET|POST")
     */
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', ['id' => $user->getId()]);
        }

        return $this->render('user/edit.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="user_delete", methods="DELETE")
     */
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }
}

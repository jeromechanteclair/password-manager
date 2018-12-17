<?php

namespace App\Controller;
use App\Entity\Crew;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\CrewType;
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
    public function new(Request $request): Response
    {

        $crew = new Crew();
        $form = $this->createForm(CrewType::class, $crew);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($crew);
            $em->flush();

            return $this->redirectToRoute('crew_list');
        }

        return $this->render('crew/new.html.twig', [

            'form' => $form->createView(),
        ]);
    }
    /**
   * This method registers an user in the database manually.
   * @Route("/createuser/{$email}/{$username}", name="createuser")
   **/
  public function register(Request $request, $email,$username,$password="null"){
     $userManager = $this->get('fos_user.user_manager');

     // Or you can use the doctrine entity manager if you want instead the fosuser manager
     // to find
     //$em = $this->getDoctrine()->getManager();
     //$usersRepository = $em->getRepository("mybundleuserBundle:User");
     // or use directly the namespace and the name of the class
     // $usersRepository = $em->getRepository("mybundle\userBundle\Entity\User");
     //$email_exist = $usersRepository->findOneBy(array('email' => $email));

     $email_exist = $userManager->findUserByEmail($email);

     // Check if the user exists to prevent Integrity constraint violation error in the insertion
     if($email_exist){
         return false;
     }

     $user = $userManager->createUser();
     $user->setUsername($username);
     $user->setEmail($email);
     $user->setEmailCanonical($email);
     //$user->setLocked(0); // don't lock the user
     $user->setEnabled(1); // enable the user or enable it later with a confirmation token in the email
     // this method will encrypt the password with the default settings :)
     $user->setPlainPassword($password);
     $userManager->updateUser($user);

     return $this->render('crew/new.html.twig', [

         'form' => $form->createView(),
     ]);
  }
}

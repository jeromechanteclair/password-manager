<?php

namespace App\PW\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
class AdminController extends Controller
{
    public function indexAction()
    {
        $userManager = $this->get('fos_user.user_manager');

        // Use findUserby, findUserByUsername() findUserByEmail() findUserByUsernameOrEmail, findUserByConfirmationToken($token) or findUsers()
        $user = $userManager->findUserBy(['id' => 1]);

        // Add the role that you want !
        $user->addRole("ROLE_ADMIN");
        // Update user roles
        $userManager->updateUser($user);
    }
  /**
    * @Route("/", name="hello")
    * @IsGranted("ROLE_ADMIN")
    * @Security("has_role('ROLE_ADMIN')")
  */
    public function Hello(UserInterface $user=null)
    {
      if($user!== null)
      {
        return $this->render('user/hello.html.twig', [
            'user' => $user,
          //  'form' => $form->createView(),
        ]);
      }


    }

}

<?php

namespace App\PW\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}

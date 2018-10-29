<?php


namespace App\PW\PasswordBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
class PasswordController extends AbstractController
{
  /**
    * @Route("/createpassword", name="create_password")
    */
    public function createPassword()
 {

     return $this->render('password/create.html.twig', array(

     ));
 }



}

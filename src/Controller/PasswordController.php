<?php

namespace App\Controller;

use App\Entity\Password;
use App\Form\PasswordTypeType;
use App\Repository\PasswordRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/password")
 */
class PasswordController extends AbstractController
{
    /**
     * @Route("/", name="password_index", methods="GET")
     */
    public function index(PasswordRepository $passwordRepository): Response
    {  $user = $this->get('security.token_storage')->getToken()->getUser()->getId();
        return $this->render('password/index.html.twig', ['passwords' => $passwordRepository->findByUser($user)]);
    }

    /**
     * @Route("/new", name="password_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {    $user = $this->get('security.token_storage')->getToken()->getUser();
        $password = new Password();
        $form = $this->createForm(PasswordTypeType::class, $password);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $password->setUser($user);
            $em->persist($password);
            $em->flush();

            return $this->redirectToRoute('password_index');
        }

        return $this->render('password/new.html.twig', [
            'password' => $password,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="password_show", methods="GET")
     */
    public function show(Password $password): Response
    {
        return $this->render('password/show.html.twig', ['password' => $password]);
    }

    /**
     * @Route("/{id}/edit", name="password_edit", methods="GET|POST")
     */
    public function edit(Request $request, Password $password): Response
    {
        $form = $this->createForm(PasswordTypeType::class, $password);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('password_edit', ['id' => $password->getId()]);
        }

        return $this->render('password/edit.html.twig', [
            'password' => $password,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="password_delete", methods="DELETE")
     */
    public function delete(Request $request, Password $password): Response
    {
        if ($this->isCsrfTokenValid('delete'.$password->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($password);
            $em->flush();
        }

        return $this->redirectToRoute('password_index');
    }
}

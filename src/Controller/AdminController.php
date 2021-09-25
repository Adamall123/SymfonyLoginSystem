<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;

/**
     * @Route("/admin")
     */

class AdminController extends AbstractController
{
    /**
     * @Route("/", name="admin_main_page")
     */
    public function index(): Response
    {
        return $this->render('admin/my_profile.html.twig');
    }

     /**
     * @Route("/delete-account", name="delete_account")
     */
    public function deleteAccount(): Response
    {
       
        $entityManager = $this->getDoctrine()->getManager();
        
        $user = $entityManager->getRepository(User::class)->find($this->getUser()->getId());
        
        $entityManager->remove($user);
        $entityManager->flush();

        session_destroy();

        return $this->redirectToRoute('front');
    }

      /**
     * @Route("/su/users", name="users")
     */
    public function users(): Response
    {
        return $this->render('admin/users.html.twig');
    }

}

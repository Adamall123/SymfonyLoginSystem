<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
     * @Route("/admin")
     */

class AdminController extends AbstractController  
{
    /**
     * @Route("/", name="admin_main_page")
     */
    public function index(Request $request, UserPasswordEncoderInterface $password_encoder): Response
    {
       
        $user = $this->getUser();
       
        $form = $this->createForm(UserType::class, $user);
       
        $form->handleRequest($request);
        $is_invalid = null; 
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $user->setName($request->request->get('user')['name']);
            $user->setEmail($request->request->get('user')['email']);
            $password = $password_encoder->encodePassword($user,
            $request->request->get('user')['password']['first']);
            $user->setPassword($password);
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash(
                'success',
                'Twoje zmiany zostały zapisane'
            );
            return $this->redirectToRoute('admin_main_page');
        }
        elseif($request->isMethod('post'))
        {
            $this->addFlash(
                'danger',
                'Twoje zmiany nie zostały zapisane - wypełnij wszystkie pola'
                
            );
            $is_invalid = 'is-invalid form-control';
        }
        
        return $this->render('admin/my_profile.html.twig', [
            'form' => $form->createView(),
            'is_invalid' => $is_invalid
        ]);
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
        $repository = $this->getDoctrine()->getRepository(User::class);
        $users = $repository->findBy([], ['name'=>'ASC']);
        return $this->render('admin/users.html.twig',[
            'users'=>$users
        ]);
    }

      /**
     * @Route("/su/delete-user/{user}", name="delete_user")
     */
    public function deleteUser(User $user): Response
    {
       $manager = $this->getDoctrine()->getManager();

       $manager->remove($user);

       $manager->flush();

       return $this->redirectToRoute('users');
    }
}

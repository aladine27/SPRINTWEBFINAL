<?php

namespace App\Controller;

use App\Form\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{
    #[Route('/UserProfile', name: 'app_Profile')]
    public function index(): Response
    {
        return $this->render('user/Profile.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }



    #[Route('/UserUpdateProfile', name:'Update_user',methods:["GET","POST"])]
   
    public function editProfile(Request $request): Response
    {
        $user = $this->getUser();
    
        $form = $this->createForm(UserFormType::class, $user);
    
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
    
            return $this->redirectToRoute('app_Profile');
        }
    
        return $this->render('User/index.html.twig', [
            'f' => $form->createView(),
        ]);
    }
    #[Route('/removeprofile', name: 'remove_profile')]
    public function deleteUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, EntityManagerInterface $entityManager)
{
    $user = $this->getUser();
    $entityManager->remove($user);
    $entityManager->flush();
    $this->get('security.token_storage')->setToken(null);
    $request->getSession()->invalidate();
    $this->addFlash('success', 'Votre compte utilisateur a bien été supprimé !');
    return $this->redirectToRoute('app_register', ['message' => 'Votre compte utilisateur a bien été supprimé !']);
    

}
}

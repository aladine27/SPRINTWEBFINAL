<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setRoles(['ROLE_USER']);
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

/************************************************************* Admin ******************************************************************* */
#[Route('/DisplayUsers', name: 'display_Users')]
public function index(): Response
{

    $Users = $this->getDoctrine()->getManager()->getRepository(User::class)->findAll();
    return $this->render('Admin/DisplayUsers.html.twig', [
        'u'=>$Users
    ]);
}



    #[Route('/removeUser/{id}', name:'supp_user')]
    public function suppressionUser(User  $user): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('display_Users');


    }
   
    #[Route('/admin/user/search', name:'user_search')]
    public function searchUser(Request $request, UserRepository $userRepository, SerializerInterface $serializer): Response
    {
        if ($request->isXmlHttpRequest()) {
            $query = $request->get('query');
            $users = $userRepository->searchByUsernameOrEmail($query); // Assuming you have a search method in UserRepository
    
            $data = $serializer->serialize($users, 'json', [
                'circular_reference_handler' => function ($object) {
                    return $object->getId();
                }
            ]);
    
            return new JsonResponse($data, 200, [], true);
        }
    
        return $this->render('Admin/DisplayUsers.html.twig');
    }
    
}
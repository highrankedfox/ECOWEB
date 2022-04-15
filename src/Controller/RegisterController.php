<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Persistence\ManagerRegistry;


class RegisterController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/inscription', name: 'app_register')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setIsEnabled(true);

            $password = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
            return $this->redirectToRoute('app_thankyou');
        }

        return $this->render('register/index.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/merci', name: 'app_thankyou')]
    public function thankyou(): Response
    {
        return $this->render('register/thankyou.html.twig');
    }

    #[Route('/termes-conditions', name: 'app_terms')]
    public function terms(): Response
    {
        return $this->render('register/terms.html.twig');
    }
}

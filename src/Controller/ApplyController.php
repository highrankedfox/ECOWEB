<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ApplicationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class ApplyController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/candidater', name: 'app_apply')]
    public function index(Request $request, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();

        $form = $this->createForm(ApplicationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            $user->setIsEnabled(false);
            $user->setRoles(array('ROLE_TEACHER'));

            $password = $hasher->hashPassword($user, $user->getPassword());
            $user->setPassword($password);

            $em = $this->doctrine->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('apply/index.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

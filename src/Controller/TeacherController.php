<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Form\FormationType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
    #[Route('/espaceformateur', name: 'app_teacher')]
    public function index(): Response
    {
        return $this->render('teacher/index.html.twig');
    }

    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/espaceformateur/ajouter-une-formation', name: 'app_teacher_add')]
    public function add(Request $request): Response
    {
        $formation = new Formation();
        $formation->setUser($this->getUser());

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $formation->setUser($this->getUser());

            $em = $this->doctrine->getManager();
            $em->persist($formation);
            $em->flush();
            return $this->redirectToRoute('app_teacher');
        }
        return $this->render('teacher/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/espaceformateur/editer-une-formation/{id}', name: 'app_teacher_edit')]
    public function edit(Request $request, $id): Response
    {
        $formation = $this->doctrine->getRepository(Formation::class)->findOneById($id);

        if (!$formation || $formation->getUser() != $this->getUser()) {
            return $this->redirectToRoute('app_teacher');
        }

        $form = $this->createForm(FormationType::class, $formation);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_teacher');
        }
        return $this->render('teacher/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Lesson;
use App\Entity\Section;
use App\Form\FormationType;
use App\Form\LessonType;
use App\Form\SectionType;
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

    #[Route('/espaceformateur/consulter/{id}', name: 'app_teacher_display')]
    public function display($id): Response
    {
        $formation = $this->doctrine->getRepository(Formation::class)->findOneById($id);
        $section  = $this->doctrine->getRepository(Section::class)->findAll();
        $lesson = $this->doctrine->getRepository(Lesson::class)->findAll();
        return $this->render('teacher/display.html.twig', [
            'formation' => $formation,
            'sections' => $section,
            'lessons' => $lesson,
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

    #[Route('/espaceformateur/{id}/nouvelle-section', name: 'app_teacher_section')]
    public function section(Request $request, $id): Response
    {
        $section = new Section();

        $form = $this->createForm(SectionType::class, $section);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $section->setFormation($this->doctrine->getRepository(Formation::class)->findOneById($id));
            $em = $this->doctrine->getManager();
            $em->persist($section);
            $em->flush();
            return $this->redirectToRoute('app_teacher');
        }
        return $this->render('teacher/section.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/espaceformateur/editer-une-section/{id}', name: 'app_teacher_section_edit')]
    public function editSection(Request $request, $id): Response
    {
        $section = $this->doctrine->getRepository(Section::class)->findOneById($id);

        $form = $this->createForm(SectionType::class, $section);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_teacher');
        }
        return $this->render('teacher/section.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/espaceformateur/{id}/nouvelle-lecon', name: 'app_teacher_lesson')]
    public function lesson(Request $request, $id): Response
    {
        $lesson = new Lesson();

        $form = $this->createForm(LessonType::class, $lesson);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $lesson->setSection($this->doctrine->getRepository(Section::class)->findOneById($id));

            $em = $this->doctrine->getManager();
            $em->persist($lesson);
            $em->flush();
            return $this->redirectToRoute('app_teacher');
        }
        return $this->render('teacher/lesson.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('/espaceformateur/editer-une-lecon/{id}', name: 'app_teacher_lesson_edit')]
    public function editLesson(Request $request, $id): Response
    {
        $lesson = $this->doctrine->getRepository(Lesson::class)->findOneById($id);

        $form = $this->createForm(LessonType::class, $lesson);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $em = $this->doctrine->getManager();
            $em->flush();
            return $this->redirectToRoute('app_teacher');
        }
        return $this->render('teacher/section.html.twig', [
            'form' => $form->createView()
        ]);
    }
}

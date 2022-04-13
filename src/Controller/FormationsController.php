<?php

namespace App\Controller;

use App\Entity\Formation;
use App\Entity\Lesson;
use App\Entity\Section;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormationsController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/formations', name: 'app_formations')]
    public function index(): Response
    {
        $formations = $this->doctrine->getRepository(Formation::class)->findAll();
        return $this->render('formations/index.html.twig', [
            'formations' => $formations,
    ]);
    }

    #[Route('/formations/consulter-{formation}-{section}-{id}', name: 'app_formations_lesson')]
    public function seeLesson($formation, $id): Response
    {
        $formation = $this->doctrine->getRepository(Formation::class)->findOneById($formation);
        $section  = $this->doctrine->getRepository(Section::class)->findAll();
        $lesson = $this->doctrine->getRepository(Lesson::class)->findOneById($id);
        dd($formation);
        return $this->render('formations/lesson.html.twig', [
            'lesson' => $lesson,
            'formation' => $formation,
            'sections' => $section
        ]);
    }

    #[Route('/formations/consulter-{id}', name: 'app_formations_see')]
    public function see($id): Response
    {
        $formation = $this->doctrine->getRepository(Formation::class)->findOneById($id);
        $section  = $this->doctrine->getRepository(Section::class)->findAll();
        $lesson = $this->doctrine->getRepository(Lesson::class)->findAll();
        return $this->render('formations/formation.html.twig', [
            'formation' => $formation,
            'sections' => $section,
            'lesson' => $lesson
        ]);
    }
}

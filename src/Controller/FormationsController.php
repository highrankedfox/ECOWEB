<?php

namespace App\Controller;

use App\Entity\Formation;
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
            'formations' => $formations
    ]);
    }
}

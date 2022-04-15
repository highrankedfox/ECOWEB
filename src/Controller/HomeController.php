<?php

namespace App\Controller;

use App\Entity\Formation;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    public function __construct(private ManagerRegistry $doctrine) {}

    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $formations = $this->doctrine->getRepository(Formation::class)->findBy(array(),array('id'=>'DESC'),3);
        return $this->render('home/index.html.twig', [
            'formations' => $formations,
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/livre')]
class LivreController extends AbstractController
{
    #[Route('/', name: 'app_livre_index', methods: ['GET'])]
    public function index(LivreRepository $livreRepository): Response
    {
        if($this->getUser())
        {
            return $this->render('livre/index.html.twig', [
                'livres' => $livreRepository->findAll(),
            ]);
        }
        else
        {
            return $this->redirectToRoute("app_login");
        }
    }

    #[Route('/{id}', name: 'app_livre_show', methods: ['GET'])]
    public function show(Livre $livre): Response
    {
        if($this->getUser())
        {
            return $this->render('livre/show.html.twig', [
                'livre' => $livre,
            ]);
        }
        else
        {
            return $this->redirectToRoute("app_login");
        }
    }
}

<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Form\LivreType;
use App\Form\LivreFiltreType;
use Symfony\UX\Turbo\TurboBundle;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/livre')]
class LivreController extends AbstractController
{
    #[Route('/', name: 'app_livre_index', methods: ['GET', 'POST'])]
    public function index(Request $request, LivreRepository $livreRepository): Response
    {
        if($this->getUser())
        {
            $auteur = null;
            $filtreForm = $this->createForm(LivreFiltreType::class);
            $filtreForm->handleRequest($request);
            if($filtreForm->isSubmitted() && $filtreForm->isValid())
            {
                $titre = $filtreForm->get('titre')->getData();
                $auteur = $filtreForm->get('auteur')->getData();
                $editeur = $filtreForm->get('editeur')->getData();
                if (TurboBundle::STREAM_FORMAT === $request->getPreferredFormat())
                {
                    // If the request comes from Turbo, set the content type as text/vnd.turbo-stream.html and only send the HTML to update
                    $request->setRequestFormat(TurboBundle::STREAM_FORMAT);
                    return $this->render('partials/turboStreams/_livres.html.twig', ['livres' => $livreRepository->filtre($titre, $auteur, $editeur)]);
                }
                return $this->render('livre/index.html.twig', [
                    'livres' => $livreRepository->filtre($titre, $auteur, $editeur),
                    'form' => $filtreForm
                ]);
            }
            return $this->render('livre/index.html.twig', [
                'livres' => $livreRepository->findAll(),
                'form' => $filtreForm
            ]);
        }
        else
        {
            $this->addFlash('error', 'Vous devez être connecté.');
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

    #[Route('/details/{id}', name: 'app_livre_details', methods: ['GET'])]
    public function details(Livre $livre): Response
    {
        return $this->render('partials/_livreModal.html.twig', [
            'livre' => $livre,
        ]);
    }
}

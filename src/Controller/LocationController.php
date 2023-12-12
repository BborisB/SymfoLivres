<?php

namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Location;
use App\Entity\Utilisateur;
use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/location")]
class LocationController extends AbstractController
{
    #[Route("/add/{id}", "app_location_add", methods: ["get"])]
    public function add(Livre $livre, EntityManagerInterface $entityManagerInterface): Response
    {
        $livreQte = $livre->getQuantite();
        if ($livreQte > 0)
        {
            $currentUser = $this->getUser();
            if ($currentUser && $currentUser instanceof Utilisateur)
            {
                $location = new Location($livre, $currentUser);
                $entityManagerInterface->persist($location);
                $entityManagerInterface->flush();
            }
            else
            {
                return $this->redirectToRoute("app_login");
            }
            return $this->redirectToRoute("app_location_index");
        }
        else
        {
            return new Response("");
        }
    }

    #[Route("/remove/{id}", "app_location_remove", methods: ["get"])]
    public function remove(Location $location, EntityManagerInterface $entityManagerInterface): Response
    {
        $currentUser = $this->getUser();
        if ($currentUser && $currentUser instanceof Utilisateur)
        {
            $entityManagerInterface->remove($location);
        }
        else
        {
            return $this->redirectToRoute("app_login");
        }
        return $this->redirectToRoute("app_location_index");
    }

    #[Route("/", "app_location_index", methods: ["get"])]
    public function show(LocationRepository $locationRepository): Response
    {
        return $this->render("location/show.html.twig", [
            'locations' => $locationRepository->findAll()
        ]);
    }
}

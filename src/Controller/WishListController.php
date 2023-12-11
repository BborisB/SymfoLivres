<?php
namespace App\Controller;

use App\Entity\Livre;
use App\Entity\Utilisateur;
use App\Repository\LivreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/wishlist")]
class WishListController extends AbstractController
{
    #[Route("/add/{id}", "app_wishlist_add", methods:["get"])]
    public function add(Livre $livre, EntityManagerInterface $entityManagerInterface) : Response
    {
        if($livre->getQuantite()>0)
        {
            $currentUser = $this->getUser();
            if($currentUser)
            {
                assert($currentUser instanceof Utilisateur);
                $livre->addUtilisateur($currentUser);
    
                $entityManagerInterface->flush();
            }
            return $this->redirectToRoute("app_livre_show", ['id'=>$livre->getId()]);
        }
        else
        {
            return new Response("");
        }
    }

    #[Route("/remove/{id}", "app_wishlist_remove", methods:["get"])]
    public function remove(Livre $livre, EntityManagerInterface $entityManagerInterface) : Response
    {
        $currentUser = $this->getUser();
            if($currentUser)
            {
                assert($currentUser instanceof Utilisateur);
                $livre->removeUtilisateur($currentUser);
    
                $entityManagerInterface->flush();
            }
            return $this->redirectToRoute("app_livre_show", ['id'=>$livre->getId()]);
    }

    #[Route("/", "app_wishlist_index", methods:["get"])]
    public function show(LivreRepository $livreRepository) : Response
    {
        return $this->render("wishlist/show.html.twig", [
            'livres'=>$livreRepository->findAll()
        ]);
    }
}
?>
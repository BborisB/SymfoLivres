<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class homeController extends AbstractController
{
    #[Route("/", "home.index", methods:["get"])]
    public function index() : Response
    {
        return $this->render("home.html.twig");
    }
}
?>
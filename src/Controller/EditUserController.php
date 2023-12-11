<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\EditUserType;
use App\Service\FileUploader;
use App\Service\ImageResizeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EditUserController extends AbstractController
{
    #[Route('/edit/user', name: 'app_edit_user')]
    public function index(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, ImageResizeService $imageResizeService): Response
    {
        $currentUser = $this->getUser();
        if($currentUser)
        {
            assert($currentUser instanceof Utilisateur);
            $form = $this->createForm(EditUserType::class, $currentUser);
            $form->handleRequest($request);
            if($form->isSubmitted()&&$form->isValid())
            {
                $pfp = $form->get('pfp')->getData();
                if($pfp)
                {
                    $fileUploader->remove($currentUser->getImageName());
                    $currentUser->setImageName($fileUploader->upload($pfp, $imageResizeService));
                }
                $entityManager->persist($currentUser);
                $entityManager->flush();
                return $this->redirectToRoute("home.index");
            }
            else
            {
                return $this->render('edit_user/index.html.twig', [
                    'form' => $form->createView(),
                ]);
            }
        }
        else
        {
            return $this->redirectToRoute("app_login");
        }
        return $this->render('edit_user/index.html.twig', [
            'controller_name' => 'EditUserController',
        ]);
    }
}

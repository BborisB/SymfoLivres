<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Form\EditPasswordType;
use App\Form\EditUserType;
use App\Service\FileUploader;
use App\Service\ImageResizeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditUserController extends AbstractController
{
    #[Route('/edit/user', name: 'app_edit_user')]
    public function editUser(Request $request, EntityManagerInterface $entityManager, FileUploader $fileUploader, ImageResizeService $imageResizeService): Response
    {
        $currentUser = $this->getUser();
        if($currentUser && $currentUser instanceof Utilisateur)
        {
            $form = $this->createForm(EditUserType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                $pfp = $form->get('pfp')->getData();
                if($pfp)
                {
                    $fileUploader->remove($currentUser->getImageName());
                    $currentUser->setImageName($fileUploader->upload($pfp, $imageResizeService));
                    $entityManager->flush();
                }
                $this->addFlash('success', 'Les modifications ont été enregistrées.');
            }
            return $this->render('edit_user/editInfo.html.twig', [
                'form' => $form
            ]);
        }
        else
        {
            return $this->redirectToRoute("app_login");
        }
    }

    #[Route('/edit/password', name: 'app_edit_password')]
    public function editPassword(Request $request, UserPasswordHasherInterface $hasher, EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser();
        if($currentUser && $currentUser instanceof Utilisateur)
        {
            $form = $this->createForm(EditPasswordType::class);
            $form->handleRequest($request);
            if($form->isSubmitted() && $form->isValid())
            {
                if($hasher->isPasswordValid($currentUser, $form->get('plainPassword')->getData() ?? ""))
                {
                    $currentUser->setPassword($hasher->hashPassword($currentUser, $form->get('newPassword')->getData()));
                    $entityManager->flush();
                    $this->addFlash("success", "Le mot de passe a été enregistré.");
                }
                else
                {
                    $this->addFlash("error", "Le mot de passe est incorrect.");
                }
            }
            return $this->render('edit_user/editPassword.html.twig', [
                'form' => $form,
            ]);
        }
        else
        {
            return $this->redirectToRoute("app_login");
        }
    }
}

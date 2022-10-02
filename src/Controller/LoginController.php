<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class LoginController extends AbstractController
{

    public function index(AuthenticationUtils $authenticationUtils): Response
    {
        // obtenir l'erreur de connexion s'il y en a une
         $error = $authenticationUtils->getLastAuthenticationError();
        // dernier nom d'utilisateur taper par l'utilisateur
         $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('login/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}

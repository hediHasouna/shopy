<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;

class LoginRedirectController extends AbstractController
{
    public function index(): RedirectResponse
    {
        //redirection selon le role
        if ($this->isGranted('ROLE_LOGISTIQUE'))
        {
            return $this->redirectToRoute('app_ordertocsv');
        }
    }
}

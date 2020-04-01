<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class EditarController extends AbstractController
{
    /**
     * @Route("/editar", name="editar")
     */
    public function index()
    {
        return $this->render('editar/index.html.twig', [
            'controller_name' => 'EditarController',
        ]);
    }
}

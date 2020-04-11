<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{

    /**
     * Página principal
     * @Route("/", name="homepage")
     */
    public function index()
    {
        return $this->render('home/home.html.twig', [
            'page_title' => 'Home',
            'page_name' => 'Benvinguts a Job or Work !!',
        ]);
    }

    /**
     * @Route("/avis-legal", name="legal")
     */
    public function homeLegal()
    {
        return $this->render('home/legal.html.twig', [
            'page_title' => 'Avis Legal',
            'page_name' => 'Avis Legal',
        ]);
    }

    /**
     * @Route("/privacitat-i-cookies", name="privacitat")
     */
    public function homePrivacitat()
    {
        return $this->render('home/privacitat.html.twig', [
            'page_title' => 'Privacitat',
            'page_name' => 'Ens preocupa la teva privacitat',
        ]);
    }

    /**
     * @Route("/condicions-us", name="condicions")
     */
    public function homeCondicons()
    {
        return $this->render('home/condicions.html.twig', [
            'page_title' => 'Condicions d\'us',
            'page_name' => 'Termes i Condicions d\'us',
        ]);
    }
}

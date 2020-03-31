<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home/{slug}", name="home", defaults={"slug":"home"})
     */
    public function index(string $slug)
    {

        switch ($slug) {
            case "avis-legal";
                return $this->render('home/legal.html.twig', [
                    'page_title' => 'Avis Legal',
                    'page_name' => 'Avis Legal',
                ]);
                break;
            case "privacitat-i-cookies";
                return $this->render('home/privacitat.html.twig', [
                    'page_title' => 'Privacitat',
                    'page_name' => 'Ens preocupa la teva privacitat',
                ]);
                break;
            case "condicions-us";
                return $this->render('home/condicions.html.twig', [
                    'page_title' => 'Condicions d\'us',
                    'page_name' => 'Termes i Condicions d\'us',
                ]);
                break;
        }
        return $this->render('home/home.html.twig', [
            'page_title' => 'Home',
            'page_name' => 'Benvinguts a Job or Work !!',
        ]);
    }
}

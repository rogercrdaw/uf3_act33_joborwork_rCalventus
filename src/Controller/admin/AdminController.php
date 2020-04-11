<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;


use App\Entity\User;

use App\Entity\Oferta;
use App\Entity\Empresa;
use App\Entity\Candidat;

class AdminController extends AbstractController
{
    /**
     * Llistar tots els usuaris registrats
     * @Route("/admin/usuaris", name="admin-usuaris")
     */
    public function llistarUsuaris()
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $repository = $this->getDoctrine()->getRepository(User::class);
            $usuaris = $repository->findAll();

            return $this->render('admin/llistaUsuaris.html.twig', [
                'page_title' => 'Admin',
                'page_name' => 'Llista d\'usuaris registrats',
                'llista_usuaris' => $usuaris,
            ]);
        }
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No teniu permisos per accedir a aquesta pàgina',
        ]);
    }

    /**
     * Llistar candidats registrats
     * @Route("/admin/candidats", name="admin-candidats")
     */
    public function llistarCandidats()
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $repository = $this->getDoctrine()->getRepository(User::class);
            $usuaris = $repository->findAll();
            $candidats = [];

            for ($i = 0; $i < count($usuaris); $i++) {
                if (in_array("ROLE_USER", $usuaris[$i]->getRoles())) {
                    array_push($candidats, $usuaris[$i]);
                }
            }

            return $this->render('admin/llistaUsuaris.html.twig', [
                'page_title' => 'Admin',
                'page_name' => 'Llista de candidats registrats',
                'llista_usuaris' => $candidats,
            ]);
        }
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No teniu permisos per accedir a aquesta pàgina',
        ]);
    }

    /**
     * Llistar empreses registrades
     * @Route("/admin/empreses", name="admin-empreses")
     */
    public function llistarEmpreses()
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $repository = $this->getDoctrine()->getRepository(User::class);
            $usuaris = $repository->findAll();
            $empreses = [];

            for ($i = 0; $i < count($usuaris); $i++) {
                if (in_array("ROLE_EMPRESA", $usuaris[$i]->getRoles())) {
                    array_push($empreses, $usuaris[$i]);
                }
            }

            return $this->render('admin/llistaUsuaris.html.twig', [
                'page_title' => 'Admin',
                'page_name' => 'Llista de candidats registrats',
                'llista_usuaris' => $empreses,
            ]);
        }
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No teniu permisos per accedir a aquesta pàgina',
        ]);
    }

    /**
     * Veure perfil complert d'un usuari
     * @Route("/admin/usuari/{id}", name="admin-perfil")
     */
    public function veurePerfilUsuari(int $id)
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {


            //Obtenir dades del usuari
            $repository = $this->getDoctrine()->getRepository(User::class);
            $usuari = $repository->findBy(['id' => $id]);

            //Si es un CANDIDAT
            if (in_array("ROLE_USER", $usuari[0]->getRoles())) {

                //Obtenir dades del Candidat
                $repository = $this->getDoctrine()->getRepository(Candidat::class);
                $candidat = $repository->findBy(['usuari' => $usuari[0]]);

                return $this->render('user/userDetalle.html.twig', [
                    'page_title' => 'Admin',
                    'page_name' => 'Perfil d\'usuari CANDIDAT',
                    'candidat_detall' => $candidat[0],
                ]);

                //Si es una EMPRESA
            } else if (in_array("ROLE_EMPRESA", $usuari[0]->getRoles())) {

                //Obtenir dades de l'Empresa
                $repository = $this->getDoctrine()->getRepository(Empresa::class);
                $empresa = $repository->findBy(['usuario' => $usuari[0]]);

                return $this->render('empresas/empresaDetalle.html.twig', [
                    'page_title' => 'Admin',
                    'page_name' => 'Perfil d\'usuari EMPRESA',
                    'empresa_detall' => $empresa[0],
                ]);
            }

            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'No teniu permisos per accedir a aquesta pàgina',
            ]);
        }
    }

    /**
     * Llistar totes les ofertes
     * @Route("/admin/ofertes", name="admin-ofertes")
     */
    public function llistarOfertes()
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $repository = $this->getDoctrine()->getRepository(Oferta::class);
            $ofertes = $repository->findAll();

            return $this->render('admin/llistaOfertes.html.twig', [
                'page_title' => 'Admin',
                'page_name' => 'Llista d\'ofertes',
                'llista_ofertes' => $ofertes,
            ]);
        }
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No teniu permisos per accedir a aquesta pàgina',
        ]);
    }

    /**
     * Llistar totes les ofertes
     * @Route("/admin/ofertes-pendent", name="admin-ofertes-pendents")
     */
    public function llistarOfertesPendents()
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $repository = $this->getDoctrine()->getRepository(Oferta::class);
            $ofertes = $repository->findBy(['estat' => "pendent"]);

            return $this->render('admin/llistaOfertes.html.twig', [
                'page_title' => 'Admin',
                'page_name' => 'Llista d\'ofertes',
                'llista_ofertes' => $ofertes,
            ]);
        }
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No teniu permisos per accedir a aquesta pàgina',
        ]);
    }

    /**
     * Llistar totes les ofertes
     * @Route("/admin/publicar{id}", name="admin-publicar-oferta")
     */
    public function publicarOferta(int $id)
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $repository = $this->getDoctrine()->getRepository(Oferta::class);

            //Buscar oferta i canviar-li l'estat
            $oferta = $repository->findBy(['id' => $id]);
            $oferta[0]->setEstat("publica");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferta[0]);
            $entityManager->flush();

            //Recuperar llistat d'ofertes i renderitzar
            $ofertes = $repository->findAll();
            return $this->render('admin/llistaOfertes.html.twig', [
                'page_title' => 'Admin',
                'page_name' => 'Llista d\'ofertes',
                'llista_ofertes' => $ofertes,
            ]);
        }
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No teniu permisos per accedir a aquesta pàgina',
        ]);
    }

    /**
     * Llistar totes les ofertes
     * @Route("/admin/ocultar/{id}", name="admin-ocultar-oferta")
     */
    public function ocultarOferta(int $id)
    {
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $repository = $this->getDoctrine()->getRepository(Oferta::class);

            //Buscar oferta i canviar-li l'estat
            $oferta = $repository->findBy(['id' => $id]);
            $oferta[0]->setEstat("pendent");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferta[0]);
            $entityManager->flush();

            //Recuperar llistat d'ofertes i renderitzar
            $ofertes = $repository->findAll();
            return $this->render('admin/llistaOfertes.html.twig', [
                'page_title' => 'Admin',
                'page_name' => 'Llista d\'ofertes',
                'llista_ofertes' => $ofertes,
            ]);
        }
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No teniu permisos per accedir a aquesta pàgina',
        ]);
    }
}

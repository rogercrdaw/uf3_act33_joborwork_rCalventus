<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Form\EditarEmpresaType;
use App\Entity\Empresa;
use App\Entity\Oferta;


class EmpresasController extends AbstractController
{
    /**
     * LListar totes les empreses actuals
     * @Route("/empresas/llista", name="llista-empresas")
     */
    public function llistarTotesEmpreses()
    {
        //Si NO hi ha un usuari logejat
        if (!$this->getUser()) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'L\'accés a aquesta pàgina es exclusiu per a usuaris registrats',
            ]);
        }
        //Si hi ha usuari loguejat, obtenir repository d'empresas
        $repository = $this->getDoctrine()->getRepository(Empresa::class);
        $empreses = $repository->findAll();

        //Buscar quantes ofertes te cada empresa
        $empresa_num_ofertes = [];
        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        for ($i=0;$i<count($empreses);$i++) {
            $numOfertes = $repository->findBy(['empresa' => $empreses[$i]]);
            array_push($empresa_num_ofertes, (count($numOfertes) +1)); 
        }


        return $this->render('empresas/empresasLista.html.twig', [
            'page_title' => 'Empreses',
            'page_name' => 'Llista d\'empreses col·laboradores',
            'empreses_llista' => $empreses,
            'empreses_num_ofertes' => $empresa_num_ofertes
        ]);
    }

    /**
     * Informació espécifica d'una empresa
     * @Route("/empresa/{id}", name="info-empresa")
     */
    public function detallEmpresa(int $id)
    {
        //Si no hi ha un usuari loguejat
        if (!$this->getUser()) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'L\'accés a aquesta pàgina es exclusiu per a usuaris registrats',
            ]);
        }
        //Si hi ha usuari logejat, obtenir dades de l'empresas
        $repository = $this->getDoctrine()->getRepository(Empresa::class);
        $empresa = $repository->findBy(['usuario' => $id]);

        return $this->render('empresas/empresaDetalle.html.twig', [
            'page_title' => 'Empresa',
            'page_name' => 'Perfil d\'empresa',
            'empresa_detall' => $empresa[0],
        ]);
    }

    /**
     * Editar perfil d'una empresa
     * @Route("/empresa/{id}/editar-perfil", name="editar-perfil-empresa")
     */
    public function editarEmpresa(int $id, Request $request)
    {
        //Si no hi ha un usuari logejat
        if (!$this->getUser()) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'L\'accés a aquesta pàgina es exclusiu per a usuaris registrats',
            ]);
        }
        //Si hi ha usuari logejat, obtenir dades de l'empresas
        // $repository = $this->getDoctrine()->getRepository(Empresa::class);
        // $empresa = $repository->findBy(['usuario' => $this->getUser()]);


        //Si hi ha usuari logejat, obtenir dades de l'empresas
        $repository = $this->getDoctrine()->getRepository(Empresa::class);
        //Si es ADMIN, obtenir info de l'empresa
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $empresa = $repository->findBy(['id' => $id]);
        } else { //Del contrari, nomes obtenir info del candidat amb ID del usuari actual
            $empresa = $repository->findBy(['usuario' => $this->getUser()]);
        }

        //Si l'usuari actual es el mateix que l'empresa que es vol editar
        if ($empresa[0]->getUsuario()->getId() == $this->getUser()->getId()) {

            $form = $this->createForm(EditarEmpresaType::class, $empresa[0]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $empresa[0]->setNom($form->get('nom')->getData());
                $empresa[0]->setTipus($form->get('tipus')->getData());
                // $empresa[0]->setLogo($form->get('logo')->getData());
                $empresa[0]->setCorreu($form->get('correu')->getData());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($empresa[0]);
                $entityManager->flush();

                return $this->render('empresas/empresaDetalle.html.twig', [
                    'page_title' => 'Empresa',
                    'page_name' => 'Perfil d\'empresa',
                    'empresa_detall' => $empresa[0],
                ]);
            }

            return $this->render('empresas/empresaEditar.html.twig', [
                'page_title' => 'Editar Perfil',
                'page_name' => 'Editar perfil d\'empresa',
                'editarEmpresaForm' => $form->createView(),
            ]);
        }
    }
}

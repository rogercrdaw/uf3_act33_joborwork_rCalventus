<?php

namespace App\Controller;

use App\Entity\Oferta;
use App\Entity\Empresa;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OfertaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;




class OfertasController extends AbstractController
{
    /**
     * LListar totes les ofertes actuals
     * @Route("/ofertas", name="ofertas")
     */
    public function llistarTotesOfertes()
    {

        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        $ofertas = $repository->findAll();

        return $this->render('ofertas/ofertasLista.html.twig', [
            'page_title' => 'Ofertas',
            'page_name' => 'Llista d\'ofertes actuals',
            'ofertes_llista' => $ofertas,
        ]);
    }

    /**
     * Llistar les ofertes d'una empresa en concret
     * @Route("/ofertas/empresa/{id}", name="ofertas_empresa")
     */
    public function llistarOfertesEmpresa(int $id)
    {

        $repo_empresas = $this->getDoctrine()->getRepository(Empresa::class);
        $empresa = $repo_empresas->findBy(['id' => $id]);
        $empresa_nom = $empresa[0]->getNom();

        $repo_ofertas = $this->getDoctrine()->getRepository(Oferta::class);
        $ofertas = $repo_ofertas->findBy(['empresa' => $id]);



        return $this->render('ofertas/ofertasLista.html.twig', [
            'page_title' => 'Ofertas',
            'page_name' => 'Ofertes de '. $empresa_nom,
            'ofertes_llista' => $ofertas,
        ]);
    }

    /**
     * Informació espécifica d'una unica oferta
     * @Route("/ofertas/{id}", name="oferta_detall")
     */
    public function detallOferta(int $id)
    {

        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repository->findBy(['id' => $id]);

        return $this->render('ofertas/ofertaDetalle.html.twig', [
            'page_title' => 'Oferta',
            'page_name' => $oferta[0]->getTitol(),
            'oferta_detall' => $oferta[0],
        ]);
    }

        /**
     * Informació espécifica d'una unica oferta
     * @Route("/ofertas/{id}/editar", name="oferta_editar")
     */
    public function editarOferta(int $id, Request $request)
    {

        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repository->findBy(['id' => $id]);

        $form = $this->createForm(OfertaType::class, $oferta[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $oferta[0]->setTitol($form->get('titol')->getData());
            $oferta[0]->setResum($form->get('resum')->getData());
            $oferta[0]->setDescripcio($form->get('descripcio')->getData());
            $oferta[0]->setRequisits($form->get('requisits')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferta[0]);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $this->render('ofertas/ofertaDetalle.html.twig', [
                'page_title' => 'Oferta',
                'page_name' => $oferta[0]->getTitol(),
                'oferta_detall' => $oferta[0],
            ]);
        }

        return $this->render('ofertas/ofertaEditar.html.twig', [
            'page_title' => 'Editar Oferta',
            'page_name' => 'Editar l\'oferta ' . $oferta[0]->getTitol(),
            'editarOfertaForm' => $form->createView(),
        ]);
    }
}

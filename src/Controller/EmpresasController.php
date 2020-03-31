<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Empresa;


class EmpresasController extends AbstractController
{
    /**
     * LListar totes les empreses actuals
     * @Route("/empresas", name="empresas")
     */
    public function llistarTotesEmpreses()
    {
        $repository = $this->getDoctrine()->getRepository(Empresa::class);
        $empresas = $repository->findAll();

        return $this->render('empresas/empresasLista.html.twig', [
            'page_title' => 'Empreses',
            'page_name' => 'Llista d\'empreses col·laboradores',

            'empreses_llista' => $empresas
        ]);
    }

    /**
     * Informació espécifica d'una empresa
     * @Route("/empresas/{id}", name="empresa_detall")
     */
    public function detallEmpresa(int $id)
    {

        $repository = $this->getDoctrine()->getRepository(Empresa::class);
        $empresa = $repository->findBy(['id' => $id]);

        return $this->render('empresas/empresaDetalle.html.twig', [
            'page_title' => 'Empresa',
            'page_name' => $empresa[0]->getNom(),
            'empresa_detall' => $empresa[0],
        ]);
    }
}

<?php

namespace App\Controller;

use App\Entity\Oferta;
use App\Entity\Empresa;
use App\Entity\Candidat;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\OfertaType;
use DateTime;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;




class OfertasController extends AbstractController
{
    /**
     * LListar totes les ofertes actuals
     * @Route("/ofertas", name="llista-ofertas")
     */
    public function llistarTotesOfertes()
    {
        $repository = $this->getDoctrine()->getRepository(Oferta::class);

        //Si l'usuari actual es ADMIN
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $ofertas = $repository->findAll();
        } else {
            $ofertas = $repository->findBy(['estat' => "publica"]);
        }
        return $this->render('ofertas/ofertasLista.html.twig', [
            'page_title' => 'Ofertas',
            'page_name' => 'Llista d\'ofertes actuals',
            'ofertes_llista' => $ofertas,
        ]);
    }

    /**
     * Llistar les ofertes d'una empresa en concret
     * @Route("/ofertas/empresa/{id}", name="ofertas-empresa")
     */
    public function llistarOfertesEmpresa(int $id)
    {
        $repo_empresas = $this->getDoctrine()->getRepository(Empresa::class);
        $empresa = $repo_empresas->findBy(['id' => $id]);
        $repo_ofertas = $this->getDoctrine()->getRepository(Oferta::class);

        //Si l'usuari actual es la mateixa empresa o ADMIN
        if (($this->getUser() == $empresa[0]) || in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $ofertas = $repo_ofertas->findBy(['empresa' => $id]);
        } else { //Del contrari, llistar, nomes les ofertes publiques
            $ofertas = $repo_ofertas->findBy(['empresa' => $id, 'estat' => "publica"]);
        }
        return $this->render('ofertas/ofertasLista.html.twig', [
            'page_title' => 'Ofertas',
            'page_name' => 'Ofertes de ' . $empresa[0]->getNom(),
            'ofertes_llista' => $ofertas,
        ]);
    }

    /**
     * Llistar les ofertes PROPIES d'una empresa
     * @Route("/ofertas/propias/{id}", name="ofertas-propias")
     */
    public function llistarOfertesPropies(int $id)
    {
        $id = $this->getUser()->getId();
        $repo_empresas = $this->getDoctrine()->getRepository(Empresa::class);
        $empresa = $repo_empresas->findBy(['usuario' => $id]);

        $repo_ofertas = $this->getDoctrine()->getRepository(Oferta::class);
        $ofertas = $repo_ofertas->findBy(['empresa' => $empresa[0]->getId()]);

        return $this->render('ofertas/ofertasLista.html.twig', [
            'page_title' => 'Ofertas',
            'page_name' => 'Ofertes de ' . $empresa[0]->getNom(),
            'ofertes_llista' => $ofertas,
        ]);
    }

    /**
     * Informació espécifica d'una oferta
     * @Route("/oferta/{id}", name="detall-oferta")
     */
    public function detallOferta(int $id)
    {
        //Obtenir la informació de la oferta
        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repository->findBy(['id' => $id]);

        //Si no hi ha un usuari logejat
        if (!$this->getUser()) {

            $oferta[0]->setDescripcio(null);
            $oferta[0]->setRequisits([null]);

            return $this->render('ofertas/ofertaDetalle.html.twig', [
                'page_title' => 'Oferta',
                'page_name' => 'Informacó detallada de l\'oferta',
                'oferta_detall' => $oferta[0],
                'inscripcio' => false,
                'error_text' => 'Nomes el usuaris registrats poden veure la informació complerta de les ofertes',
            ]);
        }

        $candidat_inscrit = false;

        //Si l'usuari actual es un candiat
        if (in_array("ROLE_USER", $this->getUser()->getRoles())) {

            //Obtenir el Candidat del usuari actual
            $repo_candidat = $this->getDoctrine()->getRepository(Candidat::class);
            $candidat = $repo_candidat->findBy(['usuari' => $this->getUser()]);

            //Comprobar si l'usuari ja està inscrit a la oferta
            $candidats_id = iterator_to_array($oferta[0]->getCandidats());
            if (in_array($candidat[0], $candidats_id)) {
                $candidat_inscrit = true;
            }
        }

        return $this->render('ofertas/ofertaDetalle.html.twig', [
            'page_title' => 'Oferta',
            'page_name' => 'Informacó detallada de l\'oferta',
            'oferta_detall' => $oferta[0],
            'inscripcio' => $candidat_inscrit,
        ]);
    }


    /**
     * Inscripcio d'un candidat a una oferta
     * @Route("/oferta/{id}/inscripcio", name="inscripcio-oferta")
     */
    public function altaCandidatOferta(int $id)
    {
        //Obtenir el Candidat del usuari actual
        $repo_candidat = $this->getDoctrine()->getRepository(Candidat::class);
        $candidat = $repo_candidat->findBy(['usuari' => $this->getUser()]);
        //Obtenir la oferta
        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repository->findBy(['id' => $id]);

        //Si l'usuari actual es el mateix que el candidat a afegir o un ADMIN
        if (($candidat[0]->getUsuari() == $this->getUser()) || (in_array("ROLE_ADMIN", $this->getUser()->getRoles()))) {
            //Afegir Candidat a la collecció i persistir dades
            $oferta[0]->addCandidat($candidat[0]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferta[0]);
            $entityManager->flush();
        }

        return $this->render('ofertas/ofertaDetalle.html.twig', [
            'page_title' => 'Oferta',
            'page_name' => 'Informacó detallada de l\'oferta',
            'oferta_detall' => $oferta[0],
            'inscripcio' => true,
        ]);
    }

    /**
     * Donar de baixa un candidat a una oferta
     * @Route("/oferta/{id}/baixa", name="baixa-oferta")
     */
    public function baixaCandidatOferta(int $id)
    {
        //Obtenir el Candidat del usuari actual
        $repo_candidat = $this->getDoctrine()->getRepository(Candidat::class);
        $candidat = $repo_candidat->findBy(['usuari' => $this->getUser()]);
        //Obtenir la oferta
        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repository->findBy(['id' => $id]);

        //Si l'usuari actual es el mateix que el candidat a eliminar o un ADMIN
        if (($candidat[0]->getUsuari() == $this->getUser()) || (in_array("ROLE_ADMIN", $this->getUser()->getRoles()))) {
            //Eliminar Candidat a la collecció i persistir dades
            $oferta[0]->removeCandidat($candidat[0]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferta[0]);
            $entityManager->flush();
        }

        return $this->render('ofertas/ofertaDetalle.html.twig', [
            'page_title' => 'Oferta',
            'page_name' => 'Informacó detallada de l\'oferta',
            'oferta_detall' => $oferta[0],
            'inscripcio' => false,
        ]);
    }

    /**
     * Donar de baixa un candidat d'una oferta
     * @Route("/oferta/{id}/baixa-candidat/{candidat_id}", name="baixa-candidat")
     */
    public function eliminarCandidatOferta(int $id, int $candidat_id)
    {
        //Obtenir la oferta
        $repository = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repository->findBy(['id' => $id]);

        //Obtenir el Candidat a eliminar
        $repo_candidat = $this->getDoctrine()->getRepository(Candidat::class);
        $candidat = $repo_candidat->findBy(['id' => $candidat_id]);

        //Si l'usuari actual es l'empresa propietaria de l'oferta o un ADMIN
        if (($oferta[0]->getEmpresa()->getUsuario() == $this->getUser()) || (in_array("ROLE_ADMIN", $this->getUser()->getRoles()))) {
            //Eliminar Candidat a la collecció i persistir dades
            $oferta[0]->removeCandidat($candidat[0]);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferta[0]);
            $entityManager->flush();
        }

        return $this->render('ofertas/ofertaDetalle.html.twig', [
            'page_title' => 'Oferta',
            'page_name' => 'Informacó detallada de l\'oferta',
            'oferta_detall' => $oferta[0],
            'inscripcio' => false,
        ]);
    }

    /**
     * INSERT d'un nova oferta
     * @Route("/ofertas/afegir", name="afegir-oferta")
     */
    public function afegirOferta(Request $request)
    {
        $error_text = "";
        //Si no hi ha un usuari logejat
        if (!$this->getUser()) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'L\'accés a aquesta pàgina es exclusiu per a usuaris registrats',
            ]);
        }

        $oferta = new Oferta();

        //Forçar el NULL de requisits
        $requisits = $oferta->getRequisits();
        for ($i = 0; $i < 4; $i++) {
            if (empty($requisits[$i])) {
                $requisits[$i] = "";
            }
        }
        $oferta->setRequisits($requisits);

        if ($oferta->getDataPublicacio() == null) {
            $data = new DateTime;
            $oferta->setDataPublicacio($data);
        }

        //Obtenir l'empresa actual
        $repository = $this->getDoctrine()->getRepository(Empresa::class);
        $empresa = $repository->findBy(['usuario' => $this->getUser()->getId()]);

        //Forçar que l'oferta sigui propietaria de l'empresa actual
        $oferta->setEmpresa($empresa[0]);

        //Crear el formulari
        $form = $this->createForm(OfertaType::class, $oferta);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $oferta->setRequisits($form->get('requisits')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferta);
            $entityManager->flush();

            return $this->redirectToRoute('ofertas-propias', [
                'id' => $empresa[0]->getId()
            ]);
        }

        return $this->render('ofertas/ofertaEditar.html.twig', [
            'page_title' => 'Afegir Oferta',
            'page_name' => 'Afegir oferta',
            'editarOfertaForm' => $form->createView(),
        ]);
    }

    /**
     * UPDATE d'una oferta existent
     * @Route("/oferta/{id}/editar", name="editar-oferta")
     */
    public function editarOferta($id, Request $request)
    {
        $error_text = "";
        //Si no hi ha un usuari logejat
        if (!$this->getUser()) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'L\'accés a aquesta pàgina es exclusiu per a usuaris registrats',
            ]);
        }

        //Obtenir info de l'OFERTA
        $repo_oferta = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repo_oferta->findBy(['id' => $id]);

        //Si l'oferta no conté requisits, forçar el NULL de requisits
        $requisits = $oferta[0]->getRequisits();
        for ($i = 0; $i < 4; $i++) {
            if (empty($requisits[$i])) {
                $requisits[$i] = "";
            }
        }
        $oferta[0]->setRequisits($requisits);

        //Obtenir info de l'empresa propietaria de l'oferta
        $repo_empresa = $this->getDoctrine()->getRepository(Empresa::class);
        $empresa = $repo_empresa->findBy(['id' => $oferta[0]->getEmpresa()]);

        $roles = $this->getUser()->getRoles();

        //Si l'usuari actual no es el propietari de l'oferta ni ADMIN
        if (($empresa[0]->getUsuario() != $this->getUser()) && (!in_array("ROLE_ADMIN", $roles))) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'No ets el propietari de l\'oferta',
            ]);
        }

        //Del contrari procedim a crear el forumulari
        $form = $this->createForm(OfertaType::class, $oferta[0]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // Al manual diu que s'ha de possar això, pero no es necessari
            // $oferta[0]->setTitol($form->get('titol')->getData());
            // $oferta[0]->setResum($form->get('resum')->getData());
            // $oferta[0]->setDescripcio($form->get('descripcio')->getData());
            // $oferta[0]->setRequisits($form->get('requisits')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($oferta[0]);
            $entityManager->flush();

            return $this->render('ofertas/ofertaDetalle.html.twig', [
                'page_title' => 'Oferta',
                'page_name' => 'Informacó detallada de l\'oferta',
                'oferta_detall' => $oferta[0],
            ]);
        }

        return $this->render('ofertas/ofertaEditar.html.twig', [
            'page_title' => 'Editar Oferta',
            'page_name' => 'Editar l\'oferta ' . $oferta[0]->getTitol(),
            'editarOfertaForm' => $form->createView(),
        ]);
    }

    /**
     * DELETE d'una oferta existent
     * @Route("/oferta/{id}/eliminar", name="eliminar-oferta")
     */
    public function eliminarOferta($id, Request $request)
    {
        $error_text = "";
        //Si no hi ha un usuari logejat
        if (!$this->getUser()) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'L\'accés a aquesta pàgina es exclusiu per a usuaris registrats',
            ]);
        }

        // Obtenir info de l'OFERTA
        $repo_oferta = $this->getDoctrine()->getRepository(Oferta::class);
        $oferta = $repo_oferta->findBy(['id' => $id]);

        if (($oferta[0]->getEmpresa()->getUsuario() == $this->getUser()) || in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($oferta[0]);
            $entityManager->flush();

            return $this->redirectToRoute('ofertas-empresa', [
                'id' => $oferta[0]->getEmpresa()->getId()
            ]);
        }

        //Si l'usuari actual no es el propietari de l'oferta
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No ets el propietari de l\'oferta',
        ]);
    }
}

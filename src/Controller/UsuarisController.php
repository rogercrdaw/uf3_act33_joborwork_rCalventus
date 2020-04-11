<?php

namespace App\Controller;

//Basic
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
//Registration
use App\Entity\User;
use App\Form\AltaCandidatType;
use App\Form\AltaEmpresaType;
use App\Security\LoginFormAuthenticator;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
//Forms
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//Security
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Entity\Empresa;
use App\Entity\Candidat;
use App\Form\EditarCandidatType;

class UsuarisController extends AbstractController
{

    /**
     * @Route("/nou-candidat", name="nou-candidat")
     */
    public function registreCandidat(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $candidat = new Candidat();
        $form = $this->createForm(AltaCandidatType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // $rols[0] = $form->get('roles')->getData();
            $user->setRoles(["ROLE_USER"]);
            $candidat->setUsuari($user);
            $candidat->setNom($form->get('nom')->getData());

            $candidat->setCognoms($form->get('cognoms')->getData());
            $candidat->setTelefon($form->get('telefon')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($candidat);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('user/nouCandidat.html.twig', [
            'page_title' => 'Subscripció',
            'page_name' => 'Formulari d\'alta nou usuari',
            'nouCandidatForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/nova-empresa", name="nova-empresa")
     */
    public function registeEmpresa(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator): Response
    {
        $user = new User();
        $empresa = new Empresa();
        $form = $this->createForm(AltaEmpresaType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // $rols[0] = $form->get('roles')->getData();
            $user->setRoles(["ROLE_EMPRESA"]);
            $empresa->setUsuario($user);
            $empresa->setNom($form->get('nom')->getData());
            $empresa->setTipus($form->get('tipus')->getData());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->persist($empresa);
            $entityManager->flush();

            // do anything else you need here, like send an email

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('user/novaEmpresa.html.twig', [
            'page_title' => 'Subscripció',
            'page_name' => 'Formulari d\'alta nova Empresa',
            'novaEmpresaForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('home');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('user/login.html.twig', [
            'page_title' => 'Log In',
            'page_name' => null,
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }


    /**
     * Perfil d'usuari d'un candidat
     * @Route("/usuari/{id}", name="detall-candidat")
     */
    public function detallCandidat(int $id)
    {

        $error_text = "";

        //Si no hi ha un usuari loguejat
        if (!$this->getUser()) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'L\'accés a aquesta pàgina es exclusiu per a usuaris registrats',
            ]);
        }
        
        //Si hi ha usuari logejat, obtenir dades del Candidat
        $repository = $this->getDoctrine()->getRepository(Candidat::class);
        $candidat = $repository->findBy(['usuari' => $id]);

        if (empty($candidat[0])) {
            return $this->render('user/nouser.html.twig', [
                'page_title' => 'Acces denegat',
                'page_name' => null,
                'error_text' => 'No trobem aquest Candidat',
            ]);
        }
        //Obtenir els rols de l'usuari actual
        $roles = $this->getUser()->getRoles();

        if (($candidat[0]->getUsuari() == $this->getUser()) || (in_array("ROLE_ADMIN", $roles)) || (in_array("ROLE_EMPRESA", $roles))) {

            return $this->render('user/userDetalle.html.twig', [
                // 'id' => $candidat[0]->getId(),
                'page_title' => 'Usuari',
                'page_name' => 'Perfil d\'usuari',
                'candidat_detall' => $candidat[0],
            ]);
        }

        //Per defecte, mostrar missatge de denegació d'accés
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'L\'accés a aquesta pàgina es exclusiu per a empreses o propi usuari',
        ]);
    }

    /**
     * Editar el perfil d'un candidat
     * @Route("/usuari/{id}/editar-perfil", name="editar-perfil-candidat")
     */
    public function editarCandidat(int $id, Request $request)
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

        $repository = $this->getDoctrine()->getRepository(Candidat::class);
        //Si es ADMIN, obtenir info del CANDIDAT
        if (in_array("ROLE_ADMIN", $this->getUser()->getRoles())) {
            $candidat = $repository->findBy(['id' => $id]);
        } else { //Del contrari, nomes obtenir info del candidat amb ID del usuari actual
            $candidat = $repository->findBy(['usuari' => $this->getUser()]);
        }
        //Si l'usuari encara no ha editat el seu perfil, forçar el NULL d'ESTUDIS
        $estudis = $candidat[0]->getEstudis();
        for ($i = 0; $i < 4; $i++) {

            if (empty($estudis[$i])) {
                $estudis[$i] = "";
            }
        }
        $candidat[0]->setEstudis($estudis);
        //Si l'usuari encara no ha editat el seu perfil, forçar el NULL de SOFTSKILLS
        $softskills = $candidat[0]->getSoftskills();
        for ($i = 0; $i < 6; $i++) {

            if (empty($softskills[$i])) {
                $softskills[$i] = "";
            }
        }
        $candidat[0]->setSoftskills($softskills);
        //Si l'usuari encara no ha editat el seu perfil, forçar el NULL de HARDSKILLS
        $hardskills = $candidat[0]->getHardskills();
        for ($i = 0; $i < 12; $i++) {

            if (empty($hardskills[$i])) {
                $hardskills[$i] = "";
            }
        }
        $candidat[0]->setHardskills($hardskills);

        //Si l'usuari actual es el mateix que el candidat que es vol editar o un ADMIN
        if (($candidat[0]->getUsuari()->getId() == $this->getUser()->getId()) || (in_array("ROLE_ADMIN", $this->getUser()->getRoles()))) {

            $form = $this->createForm(EditarCandidatType::class, $candidat[0]);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $candidat[0]->setNom($form->get('nom')->getData());
                $candidat[0]->setCognoms($form->get('cognoms')->getData());
                $candidat[0]->setTelefon($form->get('telefon')->getData());
                $candidat[0]->setEstudis($form->get('estudis')->getData());
                $candidat[0]->setPresentacio($form->get('presentacio')->getData());
                $candidat[0]->setSoftskills($form->get('softskills')->getData());
                $candidat[0]->setHardskills($form->get('hardskills')->getData());

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($candidat[0]);
                $entityManager->flush();

                return $this->render('user/userDetalle.html.twig', [
                    // 'id' => $candidat[0]->getId(),
                    'page_title' => 'Usuari',
                    'page_name' => 'Perfil d\'usuari',
                    'candidat_detall' => $candidat[0],
                ]);
            }

            return $this->render('user/userUpdate.html.twig', [
                'page_title' => 'Usuari',
                'page_name' => 'Editar perfil de ' . $candidat[0]->getNom() . " " . $candidat[0]->getCognoms(),
                'editarCandidatForm' => $form->createView(),
            ]);
        }
        return $this->render('user/nouser.html.twig', [
            'page_title' => 'Acces denegat',
            'page_name' => null,
            'error_text' => 'No teniu permis per accedir a aquest pàgina',
        ]);
    }
}

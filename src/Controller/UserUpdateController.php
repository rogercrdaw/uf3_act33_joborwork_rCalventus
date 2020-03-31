<?php

namespace App\Controller;

use App\Entity\Candidat;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class UserUpdateController extends AbstractController
{
    /**
     * @Route("/user/update", name="user_update")
     */
    public function index()
    {

        $roles = $this->getUser()->getRoles();
        $id = $this->getUser()->getId();
        // $userName = $this->getUser()->getEmail();

        if (in_array("ROLE_USER", $roles)) {
            $repository = $this->getDoctrine()->getRepository(Candidat::class);
            //Si en el array està el role ADMIN -> Mostrar todos
            $candidat = $repository->findBy(['usuari' => $id]);

            return $this->render('user/userUpdate.html.twig', [
                'page_title' => 'Editar perfil',
                'user_role' => 'usuari',
                'user_profile' => $candidat[0],
            ]);
        }

    }
}

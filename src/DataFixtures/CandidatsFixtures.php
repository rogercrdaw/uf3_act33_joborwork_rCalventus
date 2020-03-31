<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Candidat;


class CandidatsFixtures extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        // Array amb les dades dels candidats
        $candidats = [
            ["pere@inspedralbes.cat", ["ROLE_USER"], "pere", "Pere", "Ruiz", 666000123],
            ["john.doe@inspedralbes.cat", ["ROLE_USER"], "john", "John", "Doe", 666000234],
            ["eso@gmail.cat", ["ROLE_USER"], "eso", "Marc", "Gimenez", 666000176],
            ["laura@inspedralbes.cat", ["ROLE_USER"], "laura", "Laura", "Perez", 666000123],
            ["ricard@inspedralbes.cat", ["ROLE_USER"], "ricard", "Ricard", "Casas", 666000123],
            ["jmanuel@inspedralbes.cat", ["ROLE_USER"], "jmanuel", "Juan Manuel", "Fernandez Gutierrez", 666000123],
            ["sergi@inspedralbes.cat", ["ROLE_USER"], "sergi", "Sergi", "Torull", 666000123],
            ["carla@inspedralbes.cat", ["ROLE_USER"], "carla", "Carla", "Lu Yan", 666000123],
            ["sara@gmail.cat", ["ROLE_USER"], "sara", "Sara", "Ibañez Torres", 666000123],
            ["alicia@maravillas.cat", ["ROLE_USER"], "alicia", "Alicia", "Doe", 666000123],
        ];

        //Per cada candidat de l'array, afegir a la base de dades
        for ($i = 0; $i < count($candidats); $i++) {

            //Crear l'usuari
            $usuari = new User();
            $usuari->setEmail($candidats[$i][0])->setRoles($candidats[$i][1])
                ->setPassword($this->passwordEncoder->encodePassword(
                    $usuari,
                    $candidats[$i][2]
                ));
            $manager->persist($usuari);

            //Crear el Candidat amb l'ID de l'usuari creat
            $candidat = new Candidat();
            $candidat->setNom($candidats[$i][3])->setCognoms($candidats[$i][4])
                ->setTelefon($candidats[$i][5])->setUsuari($usuari);
            $manager->persist($candidat);

            //FLUSH !!
            $manager->flush();
        }
    }
}

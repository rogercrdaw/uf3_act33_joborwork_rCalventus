<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Empresa;
use App\Repository\EmpresaRepository;


class OfertesFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        /*
        // Array amb les dades dels candidats
        $ofertas = [
            ["Dissenyador pàgines web",
            "Expetenda tincidunt in sed, ex partem placerat sea, porro commodo ex eam. His putant aeterno interesset at. Usu ea mundi tincidunt, omnium virtute aliquando ius ex. Ea aperiri sententiae duo. Usu nullam dolorum quaestio ei, sit vidit facilisis ea. Per ne impedit iracundia neglegentur. Consetetur neglegentur eum ut, vis animal legimus inimicus id.", 1],
            ["Auxiliar administrativo",
            "His audiam deserunt in, eum ubique voluptatibus te. In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae. Vel ferri facilis ut, qui paulo ridens praesent ad. Possim alterum qui cu. Accusamus consulatu ius te, cu decore soleat appareat usu.", 1],
            ["Dissenyador gràfico",
            "Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. Blandit gloriatur eam et. Brute noluisse per et, verear disputando neglegentur at quo. Sea quem legere ei, unum soluta ne duo. Ludus complectitur quo te, ut vide autem homero pro.", 1],
            ["Junior JAVA",
            "Vis id minim dicant sensibus. Pri aliquip conclusionemque ad, ad malis evertitur torquatos his. Has ei solum harum reprimique, id illum saperet tractatos his. Ei omnis soleat antiopam quo. Ad augue inani postulant mel, mel ea qualisque forensibus.", 1],
            ["Programador Android",
            "Lorem salutandi eu mea, eam in soleat iriure assentior. Tamquam lobortis id qui. Ea sanctus democritum mei, per eu alterum electram adversarium. Ea vix probo dicta iuvaret, posse epicurei suavitate eam an, nam et vidit menandri. Ut his accusata petentium.", 1],
            ["Dissenyador web front-end",
            "Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. Blandit gloriatur eam et. Brute noluisse per et, verear disputando neglegentur at quo. Sea quem legere ei, unum soluta ne duo. Ludus complectitur quo te, ut vide autem homero pro.", 1],
            ["Administrador de Redes",
            "Vis id minim dicant sensibus. Pri aliquip conclusionemque ad, ad malis evertitur torquatos his. Has ei solum harum reprimique, id illum saperet tractatos his. Ei omnis soleat antiopam quo. Ad augue inani postulant mel, mel ea qualisque forensibus.", 1],
        ];

        $repository = getRepository(Empresa::class);
        //Si en el array està el role ADMIN -> Mostrar todos
        $candidat = $repository->findBy(['usuari' => $id]);
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

        */
    }
}

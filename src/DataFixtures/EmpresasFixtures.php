<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Empresa;
use App\Entity\Oferta;


class EmpresasFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        // Array amb les dades de les empreses
        $empresas = [
            ["carles@enterprise.cat", ["ROLE_EMPRESA"], "carles", "Enterprise Technologies", "Informàtica"],
            ["diana@techsolutions.com", ["ROLE_EMPRESA"], "diana", "Tech Solutions", "Informàtica"],
            ["jordi@developers.tech", ["ROLE_EMPRESA"], "jordi", "Developers4all", "Informàtica"],
            ["marta@creativestudio.com", ["ROLE_EMPRESA"], "marta", "Creative Studio", "Disseny y Arts Gràfiques"],
            ["raul@posicionate.com", ["ROLE_EMPRESA"], "raul", "Posicionate Marketing Online", "Marketing"]
        ];

        // Array amb les dades de les ofertes (Per les fixtures, nomes hi ha una oferta per a cada empresa)
        $ofertas = [
            [
                "Dissenyador pàgines web",
                "Expetenda tincidunt in sed, ex partem placerat sea, porro commodo ex eam. His putant aeterno interesset at. Usu ea mundi tincidunt, omnium virtute aliquando ius ex. Ea aperiri sententiae duo. Usu nullam dolorum quaestio ei, sit vidit facilisis ea. Per ne impedit iracundia neglegentur. Consetetur neglegentur eum ut, vis animal legimus inimicus id."
            ],
            [
                "Auxiliar administrativo",
                "His audiam deserunt in, eum ubique voluptatibus te. In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae. Vel ferri facilis ut, qui paulo ridens praesent ad. Possim alterum qui cu. Accusamus consulatu ius te, cu decore soleat appareat usu."
            ],
            [
                "Dissenyador gràfico",
                "Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. Blandit gloriatur eam et. Brute noluisse per et, verear disputando neglegentur at quo. Sea quem legere ei, unum soluta ne duo. Ludus complectitur quo te, ut vide autem homero pro."
            ],
            [
                "Junior JAVA",
                "Vis id minim dicant sensibus. Pri aliquip conclusionemque ad, ad malis evertitur torquatos his. Has ei solum harum reprimique, id illum saperet tractatos his. Ei omnis soleat antiopam quo. Ad augue inani postulant mel, mel ea qualisque forensibus."
            ],
            [
                "Programador Android",
                "Lorem salutandi eu mea, eam in soleat iriure assentior. Tamquam lobortis id qui. Ea sanctus democritum mei, per eu alterum electram adversarium. Ea vix probo dicta iuvaret, posse epicurei suavitate eam an, nam et vidit menandri. Ut his accusata petentium."
            ],
            [
                "Dissenyador web front-end",
                "Vis id minim dicant sensibus. Pri aliquip conclusionemque ad, ad malis evertitur torquatos his. Has ei solum harum reprimique, id illum saperet tractatos his. Ei omnis soleat antiopam quo. Ad augue inani postulant mel, mel ea qualisque forensibus."
            ],
            [
                "Symfony Developer",
                "Lorem salutandi eu mea, eam in soleat iriure assentior. Tamquam lobortis id qui. Ea sanctus democritum mei, per eu alterum electram adversarium. Ea vix probo dicta iuvaret, posse epicurei suavitate eam an, nam et vidit menandri. Ut his accusata petentium."
            ],
        ];

        //Per cada empresa de l'array, afegir a la base de dades
        for ($i = 0; $i < count($empresas); $i++) {

            //Crear l'usuari
            $usuari = new User();
            $usuari->setEmail($empresas[$i][0])->setRoles($empresas[$i][1])
                ->setPassword($this->passwordEncoder->encodePassword(
                    $usuari,
                    $empresas[$i][2]
                ));
            $manager->persist($usuari);


            //Crear la Empresa amb l'ID de l'usuari creat
            $empresa = new Empresa();
            $empresa->setNom($empresas[$i][3])->setTipus($empresas[$i][4])
                ->setUsuario($usuari);
            $manager->persist($empresa);


            //Crear una oferta per a cada empresa
            $oferta = new Oferta();
            $oferta->setTitol($ofertas[$i][0])->setResum($ofertas[$i][1])
                ->setEmpresa($empresa);
            $manager->persist($oferta);

            //Afegir 2 ofertes extres a una empresa per a que tingui mes d'una oferta
            if ($i == 1) {
                $oferta = new Oferta();
                $oferta->setTitol($ofertas[5][0])->setResum($ofertas[5][1])
                    ->setEmpresa($empresa);
                $manager->persist($oferta);

                $oferta = new Oferta();
                $oferta->setTitol($ofertas[6][0])->setResum($ofertas[6][1])
                    ->setEmpresa($empresa);
                $manager->persist($oferta);
            }

            //FLUSH !!
            $manager->flush();
        }
    }
}

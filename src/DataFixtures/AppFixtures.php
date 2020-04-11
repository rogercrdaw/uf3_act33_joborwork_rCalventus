<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
use App\Entity\Candidat;
use App\Entity\Empresa;
use App\Entity\Oferta;
use DateTime;

class AppFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {

        //Crear un usuari amb ROLE_ADMIN
        $admin = new User();
        $admin->setEmail("admin@iam.cat")->setRoles(["ROLE_ADMIN"])
            ->setPassword($this->passwordEncoder->encodePassword($admin, "teresa1234"));
        $manager->persist($admin);

        // Array amb les dades dels candidats
        // [0] user->EMAIL - [1] user->ROLE - [2] user->PASS - [3] candidat->NOM - [4] candidat->COGNOM - [5] candidat->TELEFON
        // [6] candidat->presentacio - [7] candidat->arrayESTUDIS - [8] candidat->arraySOFTSKILLS - [9] candidat->arrayHARDSKILLS
        $candidats = [
            [
                "pere@inspedralbes.cat", ["ROLE_USER"], "pere", "Pere", "Ruiz", 666000123,
                "In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae.",
                ["CFGS Desenvolupament d'Aplicacions amb tecnologia Web"],
                [],
                ["HTML", "CSS", "JAVASCRIPT", "PHP"],
            ],
            [
                "john.doe@inspedralbes.cat", ["ROLE_USER"], "john", "John", "Doe", 676088234,
                "Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae.",
                ["CFGS Desenvolupament d'Aplicacions Web", "CFGS Desenvolupament d'Aplicacions Multiplataforma", "CFGS Admin Sistemes Informatics en Xarxa"],
                ["Treball en equip"],
                ["HTML", "CSS", "PHP", "LINUX", "ANDROID", "JAVA"],
            ],
            [
                "eso@gmail.cat", ["ROLE_USER"], "eso", "Marc", "Gimenez", 936000176,
                "Lorem salutandi eu mea, eam in soleat iriure assentior. Tamquam lobortis id qui. Ea sanctus democritum mei, per eu alterum electram adversarium. Ea vix probo dicta iuvaret, posse epicurei suavitate eam an, nam et vidit menandri. Ut his accusata petentium. Vis id minim dicant sensibus.",
                ["CFGS Desenvolupament d'Aplicacions amb tecnologia Web"],
                null,
                ["PHP", "SYMFONY", "LARAVEL", "JAVA"],
            ],
            [
                "laura@inspedralbes.cat", ["ROLE_USER"], "laura", "Laura", "Perez", 655007823,
                "Expetenda tincidunt in sed, ex partem placerat sea, porro commodo ex eam. His putant aeterno interesset at. Usu ea mundi tincidunt, omnium virtute aliquando ius ex. Ea aperiri sententiae duo. Usu nullam dolorum quaestio ei, sit vidit facilisis ea. Per ne impedit iracundia neglegentur.",
                ["Auxiliar Infermeria"],
                ["Empatia", "Organización y orden"],
                [],
            ],
            [
                "ricard@inspedralbes.cat", ["ROLE_USER"], "ricard", "Ricard", "Casas", 667700144,
                "In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae.",
                ["CFGS ASIX"],
                ["Trabajo en equipo", "Trabajo bajo presión"],
                ["Apache", "Tomcat", "Windows Server", "Linux"],
            ],
            [
                "jmanuel@inspedralbes.cat", ["ROLE_USER"], "jmanuel", "Juan Manuel", "Fernandez Gutierrez", 666000123,
                "Expetenda tincidunt in sed, ex partem placerat sea, porro commodo ex eam. His putant aeterno interesset at. Usu ea mundi tincidunt, omnium virtute aliquando ius ex. Ea aperiri sententiae duo. Usu nullam dolorum quaestio ei, sit vidit facilisis ea. Per ne impedit iracundia neglegentur.",
                ["Baxillerato Cientifico Tecnico"],
                ["M'aburro", "M'aburro", "M'aburro mucho"],
                [],
            ],
            [
                "sergi@inspedralbes.cat", ["ROLE_USER"], "sergi", "Sergi", "Torull", 665480913,
                "Lorem salutandi eu mea, eam in soleat iriure assentior. Tamquam lobortis id qui. Ea sanctus democritum mei, per eu alterum electram adversarium. Ea vix probo dicta iuvaret, posse epicurei suavitate eam an, nam et vidit menandri. Ut his accusata petentium. Vis id minim dicant sensibus.",
                ["CFGS Desenvolupament d'Aplicacions Multiplataforma"],
                ["Treball en equip"],
                ["HTML", "CSS", "PHP", "LINUX", "ANDROID", "JAVA"],
            ],
            [
                "carla@inspedralbes.cat", ["ROLE_USER"], "carla", "Carla", "Lu Yan", 616770325,
                "Ea aperiri sententiae duo. Usu nullam dolorum quaestio ei, sit vidit facilisis ea. Per ne impedit iracundia neglegentur.In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae.",
                ["Grau d'Administració i Direcció d'Empreses"],
                ["Treball en equip", "Relacions publiques", "Gestio i organització"],
                ["SAP", "Estadistiques", "Contaplus", "DAFO"],
            ],
            [
                "sara@gmail.cat", ["ROLE_USER"], "sara", "Sara", "Ibañez Torres", 936054191,
                "In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae.",
                ["Grau d'Informatica"],
                [],
                ["C, C+ i C#", "Linux", "Java", "Android"],
            ],
            [
                "alicia@maravillas.cat", ["ROLE_USER"], "alicia", "Alicia", "Doe", 671005138,
                "In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae.",
                ["CFGS Desenvolupament d'Aplicacions amb tecnologia Web"],
                ["Responsable", "Puntualitat"],
                ["HTML", "CSS", "JAVASCRIPT", "PHP", "WORDPRESS", "PRESTASHOP"],
            ],
        ];

        // Array amb les dades de les empreses
        // [0] user->EMAIL - [1] user->ROLE - [2] user->PASS - [3] empresa->NOM - [4] empresa->TIPUS - [5] empresa->PRESENTACIO
        $empresas = [
            ["carles@iam.cat", ["ROLE_EMPRESA"], "carles", "Enterprise Technologies", "Informàtica", "Som una empresa... his audiam deserunt in, eum ubique voluptatibus te. In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae."],
            ["diana@techsolutions.com", ["ROLE_EMPRESA"], "diana", "Tech Solutions", "Informàtica", "A Tech Solutions ens agrada... his audiam deserunt in, eum ubique voluptatibus te. In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae."],
            ["jordi@developers.tech", ["ROLE_EMPRESA"], "jordi", "Developers4all", "Informàtica", "Empresa lider en el sector informatic.... his audiam deserunt in, eum ubique voluptatibus te. In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae."],
            ["marta@creativestudio.com", ["ROLE_EMPRESA"], "marta", "Creative Studio", "Disseny y Arts Gràfiques", "Ens apasiona el disseny... his audiam deserunt in, eum ubique voluptatibus te. In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae."],
            ["raul@posicionate.com", ["ROLE_EMPRESA"], "raul", "Posicionate Marketing Online", "Marketing", "Especialistas en marketing online y posicionamiento SEO... his audiam deserunt in, eum ubique voluptatibus te. In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae."]
        ];

        // Array amb les dades de les ofertes (Per les fixtures, nomes hi ha una oferta per a cada empresa)
        // [0] oferta->TITOL - [1] oferta->RESUM - [2] oferta->DESCRIPCIO - [3] oferta->arrayREQUISITS - [4] oferta->ESTAT
        $ofertas = [
            [
                "Dissenyador pàgines web",
                "Expetenda tincidunt in sed, ex partem placerat sea, porro commodo ex eam. His putant aeterno interesset at. Usu ea mundi tincidunt, omnium virtute aliquando ius ex. Ea aperiri sententiae duo. Usu nullam dolorum quaestio ei, sit vidit facilisis ea. Per ne impedit iracundia neglegentur. Consetetur neglegentur eum ut, vis animal legimus inimicus id.",
                "Somos un pequeño estudio dedicado al desarrollo de software situado en Jaén.
                Buscamos dos profesionales sin experiencia previa, aunque se valorará tenerla, para incorporarlos a nuestro equipo. En principio su trabajo sería el desarrollo web, aunque también tenemos proyectos de aplicaciones móviles, así que es una habilidad a valorar.
                La incorporación es inmediata, esto quiere decir que durante un tiempo indeterminado el trabajo será desde casa. Se ofrecerá un equipo informático para este trabajo.",
                ["Back-end: PHP, Java o Python.", "Front-end: JavaScript, CSS, SASS, Ecmascript2019.", "Frameworks webs: Codeigniter, Symfony o Django."],
                "publica"
            ],
            [
                "Auxiliar administrativo",
                "His audiam deserunt in, eum ubique voluptatibus te. In reque dicta usu. Ne rebum dissentiet eam, vim omnis deseruisse id. Ullum deleniti vituperata at quo, insolens complectitur te eos, ea pri dico munere propriae. Vel ferri facilis ut, qui paulo ridens praesent ad. Possim alterum qui cu. Accusamus consulatu ius te, cu decore soleat appareat usu.",
                "Buscamos dos profesionales sin experiencia previa, aunque se valorará tenerla, para incorporarlos a nuestro equipo. En principio su trabajo sería el desarrollo web, aunque también tenemos proyectos de aplicaciones móviles, así que es una habilidad a valorar.",
                ["CF Grado Medio o Superoo en Auxiliar Administrativo", "Conocimientos de SAP", "Ingles C1 desmostrable"],
                "publica"
            ],
            [
                "Dissenyador gràfico",
                "Est ei erat mucius quaeque. Ei his quas phaedrum, efficiantur mediocritatem ne sed, hinc oratio blandit ei sed. Blandit gloriatur eam et. Brute noluisse per et, verear disputando neglegentur at quo. Sea quem legere ei, unum soluta ne duo. Ludus complectitur quo te, ut vide autem homero pro.",
                "Lorem salutandi eu mea, eam in soleat iriure assentior. Tamquam lobortis id qui. Ea sanctus democritum mei, per eu alterum electram adversarium. Ea vix probo dicta iuvaret, posse epicurei suavitate eam an, nam et vidit menandri. Ut his accusata petentium. Vis id minim dicant sensibus. Pri aliquip conclusionemque ad, ad malis evertitur torquatos his. Has ei solum harum reprimique, id illum saperet tractatos his. Ei omnis soleat antiopam quo. Ad augue inani postulant mel, mel ea qualisque forensibus.",
                ["M'aburro", "M'aburo", "M'abuuuuuro mucho !"],
                "publica"
            ],
            [
                "Junior JAVA",
                "Buscamos una persona SIN experiencia en programación con ganas de aprender.",
                null,
                [],
                "publica"
            ],
            [
                "Programador Android",
                "Lorem salutandi eu mea, eam in soleat iriure assentior. Tamquam lobortis id qui. Ea sanctus democritum mei, per eu alterum electram adversarium. Ea vix probo dicta iuvaret, posse epicurei suavitate eam an, nam et vidit menandri. Ut his accusata petentium.",
                "Si tienes experiencia en desarrollo web con Android o IOS e, incluso, has tenido posibilidad de participar en proyectos web y/o app y te consideras alguien polivalente, queremos conocerte. Sabemos que no se puede saber de todo, pero también sabemos que en nuestro sector ser multidisciplinar es algo que nos ha tocado a muchos.",
                ["CFGS Desarrollo de Aplicaciones Multiplataforma", "3 anyos de experiencia en el sector", "Android, React y Angular"],
                "pendent"
            ],
            [
                "Dissenyador web front-end",
                "Vis id minim dicant sensibus. Pri aliquip conclusionemque ad, ad malis evertitur torquatos his. Has ei solum harum reprimique, id illum saperet tractatos his. Ei omnis soleat antiopam quo. Ad augue inani postulant mel, mel ea qualisque forensibus.",
                "Si tienes experiencia en desarrollo web bajo tecnologías LAMP, eres desarrollador de aplicaciones móviles bajo tecnologías Hibridas, Android o IOS e, incluso, has tenido posibilidad de participar en proyectos web y/o app y te consideras alguien polivalente, queremos conocerte. Sabemos que no se puede saber de todo, pero también sabemos que en nuestro sector ser multidisciplinar es algo que nos ha tocado a muchos. En Merkatu nos enfrentamos a apasionantes proyectos con multitud de retos tecnológicos.",
                ["CFGS Desarrollo de Aplicaciones Web", "2 anyos de experiencia", "PHP y Wordpress"],
                "publica"

            ],
            [
                "Symfony Developer",
                "Lorem salutandi eu mea, eam in soleat iriure assentior. Tamquam lobortis id qui. Ea sanctus democritum mei, per eu alterum electram adversarium. Ea vix probo dicta iuvaret, posse epicurei suavitate eam an, nam et vidit menandri. Ut his accusata petentium.",
                "Buscamos profesionales sin experiencia previa, para incorporacion imediata a nuestro equipo. En principio su trabajo sería el desarrollo web, aunque también tenemos proyectos de aplicaciones móviles, así que es una habilidad a valorar.",
                ["CFGS Desarrollo de Aplicaciones Web", "PHP y Symfony", "Valorable Laravel"],
                "publica"
            ],
        ];

        $obj_candidats = [];
        //Per cada candidat de l'array, crear l'objecta Candidat i persisitir dades (10 CANDIDATS)
        //[0] user->EMAIL - [1] user->ROLE - [2] user->PASS - [3] candidat->NOM - [4] candidat->COGNOM - [5] candidat->TELEFON
        //[6] candidat->presentacio - [7] candidat->arrayESTUDIS - [8] candidat->arraySOFTSKILLS - [9] candidat->arrayHARDSKILLS
        for ($i = 0; $i < count($candidats); $i++) {

            //Crear l'usuari
            $usuari = new User();
            $usuari
                ->setEmail($candidats[$i][0])
                ->setRoles($candidats[$i][1])
                ->setPassword($this->passwordEncoder->encodePassword(
                    $usuari,
                    $candidats[$i][2]
                ));
            $manager->persist($usuari);

            //Crear el Candidat amb l'ID de l'usuari creat
            $obj_candidats[$i] = new Candidat();
            $obj_candidats[$i]
                ->setNom($candidats[$i][3])
                ->setCognoms($candidats[$i][4])
                ->setTelefon($candidats[$i][5])
                ->setPresentacio($candidats[$i][6])
                ->setEstudis($candidats[$i][7])
                ->setSoftskills($candidats[$i][8])
                ->setHardskills($candidats[$i][9])
                ->setUsuari($usuari);
            $manager->persist($obj_candidats[$i]);
        }

        $obj_empresas = [];
        //Per cada empresa de l'array, crear l'objecta Empresa i persisitir dades (5 EMPRESAS)
        //[0] user->EMAIL - [1] user->ROLE - [2] user->PASS - [3] empresa->NOM - [4] empresa->TIPUS - [5] empresa->PRESENTACIO
        for ($i = 0; $i < count($empresas); $i++) {

            //Crear l'usuari
            $usuari = new User();
            $usuari
                ->setEmail($empresas[$i][0])
                ->setRoles($empresas[$i][1])
                ->setPassword($this->passwordEncoder->encodePassword($usuari, $empresas[$i][2]));
            $manager->persist($usuari);

            //Crear la Empresa amb l'ID de l'usuari creat
            $obj_empresas[$i] = new Empresa();
            $obj_empresas[$i]
                ->setNom($empresas[$i][3])
                ->setTipus($empresas[$i][4])
                ->setPresentacio($empresas[$i][5])
                ->setUsuario($usuari);
            $manager->persist($obj_empresas[$i]);
        }

        $obj_ofertas = [];
        //Per cada oferta de l'array, crear l'objecta Oferta i persisitir dades (7 OFERTAS)
        //[0] oferta->TITOL - [1] oferta->RESUM - [2] oferta->DESCRIPCIO - [3] oferta->arrayREQUISITS - [4] oferta->ESTAT
        for ($i = 0; $i < count($ofertas); $i++) {

            $data = new DateTime();
            //Crear l'objecta oferta
            $obj_ofertas[$i] = new Oferta();
            $obj_ofertas[$i]
                ->setTitol($ofertas[$i][0])
                ->setResum($ofertas[$i][1])
                ->setDescripcio($ofertas[$i][2])
                ->setRequisits($ofertas[$i][3])
                ->setEstat($ofertas[$i][4])
                ->setDataPublicacio($data);
        }

        // IMPORTANT -> Assignar a cada oferta, empresa propietaria i candidats
        // S'ha de fer manualment

        $obj_ofertas[0]
            ->setEmpresa($obj_empresas[0])
            ->addCandidat($obj_candidats[0])
            ->addCandidat($obj_candidats[3])
            ->addCandidat($obj_candidats[5]);

        $obj_ofertas[1]
            ->setEmpresa($obj_empresas[0]);
        $obj_ofertas[2]
            ->setEmpresa($obj_empresas[1])
            ->addCandidat($obj_candidats[2])
            ->addCandidat($obj_candidats[4])
            ->addCandidat($obj_candidats[6])
            ->addCandidat($obj_candidats[8])
            ->addCandidat($obj_candidats[9]);
        $obj_ofertas[3]
            ->setEmpresa($obj_empresas[1])
            ->addCandidat($obj_candidats[5])
            ->addCandidat($obj_candidats[6])
            ->addCandidat($obj_candidats[7])
            ->addCandidat($obj_candidats[8]);
        $obj_ofertas[4]
            ->setEmpresa($obj_empresas[2])
            ->addCandidat($obj_candidats[3])
            ->addCandidat($obj_candidats[6]);
        $obj_ofertas[5]
            ->setEmpresa($obj_empresas[3])
            ->addCandidat($obj_candidats[7]);
        $obj_ofertas[6]
            ->setEmpresa($obj_empresas[4])
            ->addCandidat($obj_candidats[2]);


        //Per cada oferta, persisitim les dades
        for ($i = 0; $i < count($ofertas); $i++) {
            $manager->persist($obj_ofertas[$i]);
        }

        //FLUSH !!
        $manager->flush();
    }
}

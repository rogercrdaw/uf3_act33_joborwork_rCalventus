# JOBorWORK | Projecte Symfony


CFGS Denevolupament d'Applicacions amb tecnologia Web.
M07 Desenvolupament web en entorn servidor.
UF3. Tècniques d’accés a dades.

## Requisits del projecte 📋

* Web desenvolupada amb el framework **[Symfony](https://symfony.com)**
* Control d'usuaris que limiten l'acces a determiandes parts del website

* Usuaris no registrats no han de poder veure el detall d'una oferta de feina, el perfil d'una empresa o la llista d'empresas colaboradores
* ROLE_USER ha de poder subscriures o donar-se de baixa d'una oferta de feina
* ROLE_EMPRESA ha de poder crear, editar o elimar ofertes de feines
* ROLE_EMPRESA ha de poder gestionar els candidats subscrits a les seves ofertes
* Una oferta de feina no es visible fins que un ROLE_ADMIN la aprovi

* Una Empresa pot tenir moltes ofertes, pero una oferta nomes pot ser d'una empresa (1:N)
* Un candidat nomes pot inscriures a una oferta (1:N) (_millorat_)

### Extras afegits a títol propi 📋

* Gestió d'arrays en base de dades. Els usuaris tenen arrays d'estudis, softskills i hardskills. Les ofertes de feina tenen arrays de requisits.
* Gestió de coleccions. Els candidats poden inscriures a moltes ofertes i viseversa (N:M)
* Perfils d'usuari, empresa i oferta de feina amb mes camps dels indicats al enunciat.
* Candidats i Empreses poden editar el seu perfil pero....
* Control de permisos. Els usuaris nomes poden editar el seu propi perfil. Una empresa nomes pot editar/elimianr les seves propies ofertes
* Evitar les llistes clàssiques amb botons d'opcions i utilitzant les opcions de **TWIG** colocar **Awesome Icons** per als enllaços dels controladors
* Full **Bootstrap 4** i per tant **Full Responsive**


### Desplegament 🔧

Pendent fer el Desplegament en un servidor web púbilc
[How to Deploy a Symfony Application](https://symfony.com/doc/current/deployment.html)
_S'accepten consells i orientacions al respecte_



### Objectius assolits 📌

* DoctrineManager
* Controllers
* Routing and Rendering
* FormTypes

### Objectius no assolits 📌
* Pujar imatges de foto de perfil (logo empreses)


---
😵 Fucking Quarantine !!.
by RC [InsPedralbes](https://inspedralbes.cat)

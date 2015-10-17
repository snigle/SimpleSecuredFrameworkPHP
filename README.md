Annexe - Documentation du projet
================================

Introduction
------------

### Fonctionnalités

Ce framework php a pour but de pouvoir créer une application sécurisée
sans en tenir compte. Il propose les fonctionnalités suivantes :

-   Bloquer les injections SQL

-   Empêcher les failles XSS

-   Bloquer l’accés direct aux fichiers du site pour empêcher les
    listings

-   Cacher les erreurs PHP

-   Forcer une identification avec mot de passe sécurisé

-   Crypter les mots de passes

-   Mettre à  jour des logs

-   Alerter l’administrateur\*\*

\*\* Pour pouvoir utiliser cette fonction vous devrez avoir un serveur
mail opérationnel utilisable par la fonction mail de PHP. Pour activer
le service il faudra modifier le fichier app.xml en ajouter un paramètre
email=“votreEmail” dans la balise root.

### Les prés-requis

De bonnes connaissances en PHP sont nécessaires ainsi qu’en
programmation orienté objet.

L’archive FrameworkPHPEisti.tar.gz

Pour utiliser le framework vous devez avoir un serveur php configurable.
Nous expliquerons dans cette documentation comment configurer un serveur
Apache.

### Configuration d’apache

Avant de continuez, vérifiez que vous pouvez :

-   Activer le module rewrite d’apache (mod\_rewrite);

-   Modifier la racine du serveur.

#### URLRewriting

##### Dans la version 1 d’apache :

il faut modifier le fichier **/etc/apache/httpd.conf** sur linux et dans
le répertoire **apacheconf** pour windows.

##### Dans la version 2 d’apache :

il suffit d’entrer la commande en root :

``` {language="Bash"}
# a2enmod rewrite
```

#### Racine du serveur web

Pour modifier la racine du serveur web vous devez modifier le fichier
**/etc/apache2/sites-available/default** comme ceci :

     DocumentRoot /var/www/htdocs
        <Directory /var/www/htdocs>

Devient :

     DocumentRoot /[Emplacement Framework]/Web/[NomApplication]
        <Directory /[Emplacement Framework]/Web/[NomApplication]>

Pour gérer plusieurs applications sur votre serveur vous devez créer des
serveurs virtuels à l’aide d’apache et d’y inscrire comme emplacement\
**/[Emplacement Framework]/Web/[NomApplication]**\
Par exemple : /home/pepito/FrameWorkPHP/Web/Blog

### Gestion des objets et de la base de données

Pour utiliser une base de données il est conseillé de suivre le schéma
suivant. D’autant plus que le framework utilise ce schéma. Nous allons
expliquer la marche à suivre à l’aide d’un exemple. Nous voulons créer
un site de news (comme un blog). Nous devrons alors créer les classes
News et NewsManager

#### Les entités

La classe News sera alors une entité, on peut associer ce terme à un
élément de la base de données. Une définition simple serait de dire que
tout ce qui possède un id en base de données est une entité. La classe
que nous créerons sera donc une fille de la classe Entity. Notre classe
possédera des arguments, ainsi que des accesseurs de lecture et de
définitions aussi appelées getters et setters. La classe devra se
trouver dans le dossier Applications/NomApplication/Entity/

##### Remarque :

Pour les utilisateurs, la classe Utilisateur est déjà crée, vous pouvez
ajouter vos méthodes et arguments à l’intérieur.\
Pour chaque table de la base de données, vous devez créer un champ id en
auto increment. Pour la table utilisateur, le champ id peut être nul car
c’est celui de l’administrateur. Le script entity générera cette classe
pour vous. Voici la classe News.class.php de notre exemple :

``` {language="php"}
<?php

namespace NomApplication\Entity;
class News extends \Library\Entity
{
    protected $titre;
    protected $contenu;
    protected $auteur;

// SETTER 
    protected function setTitre($variable)
    {
        $this->titre = $variable;//assigne un titre
    }
    protected function setContenu($variable)
    {
        $this->contenu = $variable;//assigne un contenu
    }
    protected function setAuteur($variable)
    {
        $this->auteur = $variable;//assigne un auteur
    }

//GETTER
    protected function titre()
    {
        return $this->titre;//recupere le titre
    }
    protected function contenu()
    {
        return $this->contenu;//recupere le contenu
    }
    protected function auteur()
    {
        return $this->auteur;//recupere l'auteur
    }

} 
```

Vous remarquerez que l’argument id n’est pas définit dans cette classe.
Celui-ci est géré dans la classe mère Entity. Veillez à respecter la
syntaxe avec les majuscules pour éviter les erreurs. De plus pensez à
mettre chaque méthode en protected, cela permet au framework de gérer
les failles XSS.

#### Les managers

Les managers sont les classes qui interagiront directement avec la base
de données. C’est la partie Model du schéma MVC. Ces classes se trouvent
dans le dossier /Applications/NomApplication/Model/ .\
Pour notre exemple de News, nous auront besoin d’un NewsManager. Il faut
obligatoirement créer les méthodes add et update qui effectueront les
requêtes SQL ADD et UPDATE. De plus cette classe sera une fille de la
classe Manager qui contient la méthode save(Entity \$objet).\
La méthode save appelera automatiquement la méthode add si l’id de
l’objet est nulle. Elle appellera la méthode update sinon. Ainsi lorsque
nous voudrons ajouter ou modifier quelque chose dans la base de données,
il suffira de créer l’objet correspondant et d’appeler la méthode save
du manager correspondant.\
Pour récupérer un manager depuis le contrôleur on peut utiliser la
méthode :

``` {language="php"}
 $manager1 = $this->managers->getManagerOf('NomObjet');
 $managerNews = $this->managers->getManagerOf('News');
```

Voici le fichier NewsManager.class.php de notre exemple :

``` {language="php"}
<?php

namespace NomApplication\Model;
class NewsManager extends \Library\Manager
{

    protected function add(\NomApplication\Entity\News $news)
    {
        $req = $this->pdo->prepare('INSERT INTO
news(id,contenu,auteur)VALUES("",:contenu,:auteur)');
        $req->bindValue(':contenu',$news->contenu() );
        $req->bindValue(':auteur',$news->auteur());
        $req->execute();
    }
    
    protected function update(\NomApplication\Entity\News $news)
    {
        $req = $this->pdo->prepare('UPDATE news SET contenu=:contenu
auteur=:auteur WHERE id=:id');
        $req->bindValue(':contenu',$news->contenu());
        $req->bindValue(':auteur',$news->auteur());
        $req->bindValue(':id',$news->id());
        $req->execute();
    }
}
```

Vous pouvez ensuite ajouter les méthodes dont vous avez besoin telles
que “getList” ou encore “delete”. Veillez à toujours envoyer un objet
dans vos requête pour que vous ne mettez jamais une variable d’un objet
directement. Il vaut mieux utiliser l’accesseur depuis le manager pour
éviter des bugs.

### Classes non répertoriées

Si vous avez besoin d’ajouter des classes qui ne font pas parti des
catégories vu précédemment, vous pouvez les mettre dans le dossier
Classes. Avant de coder la classe, pensez à ajouter le namespace suivant
:

``` {language="php"}
 namespace [NomApplication]\Classes;
```

Ensuite pour créer une instance de la classe vous devrez faire comme
ceci :

``` {language="php"}
 $instance = new \[NomApplication]\Classes\[NomClasse];
```

Création d’une application
--------------------------

### Création de l’arborescence des dossiers

Si vous êtes sous linux il est conseillé d’utiliser le script
**ajouterApplication.sh** pour générer automatiquement les dossiers et
les fichiers nécessaires.\
Pour Windows vous pouvez copier le dossier\
**./Applications/Default** et **./Web/Default**\
puis les renommer avec le nom de votre application. Pensez à renommer
également le fichier **Default.class.php** ainsi que dans chaque fichier
PHP.

#### Configurer l’application

L’application se configure directement lors de l’ajout de celle-ci. Si
vous voulez modifier ces réglages il faudra modifier le fichier
**Applications/[NomApplication]/Config/app.xml**. Pour choisir un
nouveau mot de passe pour le compte administrateur il faut exécuter le
script **Applications/[NomApplication]/Config/password.sh**

### Création d’un module

Votre application devra se composer de plusieurs modules, par exemple :
news, commentaire, sondage, etc... Chaque module possédera une ou
plusieurs actions telles que : afficherListe, afficher, ecrire, etc...
Pour les modules réservés à l’administrateur vous devrez les placer dans
le dossier **./ModulesAdmin/[NomModule]** et dans
**./Modules/[NomModule]** pour les autres.

#### Les routes

Avant de créer un module il va falloir lui attribuer un URL. Éditez
alors le fichier : **./NomApplication/Config/routes.xml**. Le fichier
doit respecter la forme suivante :

``` {language="xml"}
 <?xml version="1.0"?>
<conf>
    <route url="/admin/gestionPromo\.htm" module="GestionPromo" 
    action="showForm" method="get" />
    <route url="/admin/gestionPromo\.htm" module="GestionPromo" 
    action="save" method="post" />
</conf>
```

Pour utiliser les modules administrateurs vous devez écrire **/admin/**
devant l’url. Vous devez donc créer une balise route et y inscrire l’URL
tout en respectant la syntaxe d’une expression régulière. Il est donc
important de mettre un antislash devant le point. Pour inclure des
champs variables dans l’URL il faut utiliser les expressions régulières.
Regardez cet example :

``` {language="xml"}
 <?xml version="1.0"?>
<conf>
   <route url="/admin/supprimerUtilisateur-([0-9]+)\.htm" 
   module="GestionUtilisateur" action="supprimer" vars="id" 
   method="get" />
</conf>
```

Ainsi il faut mettre entre parenthèse le champ variable et lui donner un
nom à l’aide du paramètre vars. Si vous avez besoin de plusieurs
variables il suffit d’écrire le nom des variables séparés d’une virgule.
Par exemple : vars=“id,pseudo”.

Nous allons maintenant pouvoir créer notre module et son action
correspondante.

#### Le contrôleur

La base d’un module est son contrôleur qui doit se nommer précisément
[NomModule]Controller.class.php Cette page php est une classe qui
représentera le controleur de votre module, vous devez donc suivre ce
modèle :

``` {language="php"}
 <?php
//Remplacez les crochets par les noms correspondants à ce que vous avez choisit

namespace [NomApplication]\Modules\[NomModule];
//Pour un module administrateur pensez à préciser ModulesAdmin
//namespace [NomApplication]\ModulesAdmin\[NomModule];
//Exemple : Blog\ModulesAdmin\Commentaires;

class [NomModule]Controller extends \Library\Controllers
{
//Exemple : class CommentairesController extends \Library\Controllers
  
  public function rules[Action]()
  {
   //Exemple : public function rulesSupprimer()
  }
  
  public function execute[Action]()
  {
   //Exemple : public function executeSupprimer()
  }
}
```

Ainsi pour chaque action vous devez avoir deux méthodes:

##### rulesAction : 

permet de gérer les droits. Pour autoriser l’accès vous devez passer
l’argument \$this-\>authorized à true. Pour les modulesAdmin, cette
méthode est facultative car le framework vérifie directement les droits
administrateurs. Voici deux exemples d’utilisation :

``` {language="php"}
 <?php
public function rulesFormulaire()
 {
    $this->authorized = true;
    //Tout le monde peut accéder à cette page
 }

 public function rulesAfficher()
 {
    if($this->app()->user()->isAuthenticated())
      $this->authorized = true;
    else
      $this->url = $this->app()->router()->getUrl("Connexion","formulaire");
    //Si l'utilisateur n'est pas connecté on le renvoi au formulaire du module
Connexion
 }
```

Comme vous pouvez le voir il est aussi possible de modifier l’argument\
\$this-\>url pour choisir où rediriger l’utilisateur s’il n’a pas les
droits d’accès. Par défaut il est envoyé vers l’erreur 403.

Vous remarquez ici l’appel de la méthode getUrl pour trouver un url.

``` {language="php"}
//Variable autorisant l'execution de l'action ou non
protected $authorized = false;
//Variable contenant l'url vers laquelle l'utilisateur est rediriger
//s'il n'a pas les droits
protected $url = null;
```

##### executeAction

C’est dans cette méthode que vous appliquez votre code. Voici une liste
d’arguments et de méthodes qui peuvent être utile.

    //Méthode permettant d'ajouter une variable lisible depuis la vue.
     $this->page->addVar(String name,$value);
    //Méthode permettant de récupérer une instance d'un manager.
     $this->managers->getManagerOf(String className);
    //Méthode permettant de définir l'utilisation du layout ou non.
     $this->page->setLayout(Boolean value);

#### La vue

Le fichier de la vue doit se trouver dans le dossier View du module
(qu’il faut créer). Par défaut la vue utilisée est nomdelaction.php mais
vous pouvez en choisir une autre en appelant la méthode
\$this-\>setView(String name) dans le contrôleur. La vue sera ensuite
inclue dans une variable \$content que vous pourrez afficher dans le
layout. Les variables utilisées dans la vue doivent être ajoutées depuis
la contrôleur. Pour afficher vos lien en concordance avec les routes
configurées vous pouvez utiliser la méthode :

``` {language="php"}
 //Méthode retournant l'url correspondant au module, à l'action et aux variables
 $this->app()->router()->getUrl($nomModule,$nomAction, Array ("nom" => $value));
```

Annexe
------

### Layout, images, css

Vous pouvez modifier le layout de votre application dans le dossier\
**Applications/NomApplication/Layout/**. Vous devrez y mettre le fichier
index qui devra s’appeler layout.php. Deplus vous pouvez afficher la
variable \$content qui correspond à la vue de chaque module.\
Le reste des fichiers et dossier (css et images par exemple) doivent se
trouver dans le dossier **Web/NomApplication/**. Pour modifier le
comportement général de l’application vous pouvez modifier le fichier\
**Applications/NomApplication/NomApplication.class.php**. Par exemple
pour ajouter une variable à toute les pages.

### Récapitulatif des méthodes et arguments

##### Crypter les mots de passes

``` {language="php"}
//Méthode permettant prenant un utilisateur avec un mot de passe quelconque
//Renvoi ce mot de passe crypté
//public function crypt(User $utilisateur)
$this->app()->crypt()->crypt($utilisateur)
```

``` {language="php"}
//Méthode permettant de récupérer l'ul d'une action d'un module
 $this -> app()->router()->getUrl("[Module]","[action]");
//Ou si il y a des variables
 $this -> app()->router()->getUrl("[Module]","[action]",
array("[NomVariable]"=> "[Valeur]");
```

Méthode depuis une classe Controller :

``` {language="php"}
//Méthode permettant de rediriger l'utilisateur
$this->app()->httpReponse()->redirect($url);
//Méthode retournant vrai si l'utilisateur est connecté et faux sinon
$this->app()->user()->isAuthenticated()
// Variable autorisant l'execution de l'action ou non
protected $authorized = false ;
// Variable contenant l'url vers laquelle l'utilisateur est rediriger
//s'il n'a pas les droits
protected $url = null ;
// Méthode permettant d'ajouter une variable lisible depuis la vue.
$this ->page -> addVar ( String name , String value );
// Méthode permettant de récupérer une instance d'un manager .
$this -> managers -> getManagerOf ( String className );
// Méthode permettant de définir l'utilisation du layout ou non.
$this ->page -> setLayout ( Boolean value );
```

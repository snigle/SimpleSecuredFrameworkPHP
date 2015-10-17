<?php
namespace Default\Modules\Connexion;

class ConnexionController extends \Library\Controllers
{
  
  public function rulesFormulaire()
  {
    $this->authorized = true;
  }
 
  
  public function executeFormulaire()
  {
    $this->setView("connexion");
  }
  
  public function rulesConnexion()
  {
    $this->authorized = true;
  }
  
  public function executeConnexion()
  {
	    
	    //Fait durer l'execution à 5sc pour empêcher le bruteforce
	    sleep(5);
	    
	    //Recuperation manager
	    //$manager = $this->managers->getManagerof('Utilisateur');
	    //Creation d'un utilisateur avec les $_POST
	    $utilisateurProvisoire = new \Default\Entity\Utilisateur($_POST);
	    
	    $utilisateur = new \Default\Entity\Utilisateur($this->app()->config()->get('root'));
	    
	    //Vérification du root (dans fichier xml de config)
	    
	    if($this->app()->crypt()->crypt($utilisateurProvisoire) == $utilisateur->password() AND $utilisateurProvisoire->login() == $utilisateur->login())
	    {
	      $utilisateur->setAuthenticated();
	      $utilisateur->setFlash("Connexion réussie");
	      $_SESSION['user'] = serialize($utilisateur);
	      header('Location: '.$_SERVER['HTTP_REFERER']);
	    }
	    else
	         $this->app()->user()->setFlash('Mauvais login ou mot de passe : '.$utilisateurProvisoire->login());
	    //else
	    //{
	      //Recupération de l'utilisateur en BDD avec le login
	      //$utilisateur = $manager->getByLogin($utilisateurProvisoire->login());

	      /*if(\Library\CryptPassword::crypt($utilisateurProvisoire) == $utilisateur->password())
	      {
	        $utilisateur->setAuthenticated();
	        $_SESSION['user'] = serialize($utilisateur);
	        header('Location: '.$_SERVER['HTTP_REFERER']);
	      }
	      else
	      {
	        $this->page->addVar('message','Mauvais login ou mot de passe : '.$utilisateurProvisoire->login());
	      }*/
	        
	  //  }
    


    

  }



}
	
	
	

	
	

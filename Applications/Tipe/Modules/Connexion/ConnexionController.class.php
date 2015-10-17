<?php
namespace Tipe\Modules\Connexion;

class ConnexionController extends \Library\Controllers
{
  
  public function rulesFormulaire()
  {
    $this->rulesConnexion();
  }
 
  public function executeFormulaire()
  {
    $this->setView("connexion");
  }
  
  public function rulesConnexion()
  {
    $this->url = $this->app()->router()->getUrl('messages','afficherMessage');
    $this->authorized = !$this->app()->user()->isAuthenticated();
  }
  
  public function executeConnexion()
  {
	    
	    //Fait durer l'execution à 5sc pour empêcher le bruteforce
	    sleep(5);
	    
	    //Recuperation manager
	    $manager = $this->managers->getManagerof('Inscription');
	    //Creation d'un utilisateur avec les $_POST
	    $utilisateurProvisoire = new \Tipe\Entity\Utilisateur($_POST);
	    
	    $utilisateur = new \Tipe\Entity\Utilisateur($this->app()->config()->get('root'));
	    
	    //Vérification du root (dans fichier xml de config)
	    
	    if($this->app()->crypt()->crypt($utilisateurProvisoire) == $utilisateur->password() AND $utilisateurProvisoire->login() == $utilisateur->login())
	    {
	      $utilisateur->setAuthenticated();
	      $utilisateur->setFlash("Connexion réussie");
	      $this->app()->setUser($utilisateur);
	      $this->app()->httpResponse()->redirect($_SERVER['HTTP_REFERER']);
	    }
	    else
	    {
	      //Recupération de l'utilisateur en BDD avec le login
	      $utilisateur = $manager->getByLogin($utilisateurProvisoire->login());
		  $utilisateurProvisoire->setId($utilisateur->id());
	      if($this->app()->crypt()->crypt($utilisateurProvisoire) == $utilisateur->password())
	      {
	      	$utilisateur->setAuthenticated();
	      	$utilisateur->setFlash("Connexion réussie");
	      	$this->app()->setUser($utilisateur);
	      	$this->app()->httpResponse()->redirect($_SERVER['HTTP_REFERER']);
	      }
	      else
	        $this->app()->user()->setFlash('Mauvais login ou mot de passe : '.$utilisateurProvisoire->login());
	      
	        
	    }
   } 
  public function rulesDeconnexion()
  {
    $this->authorized = true;
  }

	public function executeDeconnexion()
	{
    	$user = new \Tipe\Entity\Utilisateur(null);
    	$this->app()->setUser($user);
    	$this->app()->httpResponse()->redirect($this->app()->router()->getUrl('connexion','connexion'));
	}
  
}
	
	
	

	
	

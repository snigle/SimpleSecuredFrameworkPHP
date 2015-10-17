<?php

//Recuperation du nom de la BDD et du mode utilisé Grace au fichier config
namespace Library;
abstract class Controllers extends ApplicationComponent {
  protected $module;

  protected $action;

  protected $page;

  protected $view;
  
  protected $authorized = false;
  
  protected $url = null;
  
  protected $admin = false;
  
  //Contient un instance de Managers
  protected $managers;

  //on crée une page, et on assigne les arguments
  public function __construct($app, $module, $action,$admin = false)
  {
    $this->admin = $admin;
    $parentModule = $this->admin ? 'ModulesAdmin' : 'Modules';
    $this->app = $app;
    $this->module = $module;
    $this->action = $action;
    $this->setView($action);
   
    $this->page = new Page($this->app());
    $this->managers = new Managers($this->app());
  }
  
  //Méthode appelant la fonction d'execution du controller si elle existe
  public function execute()
  {
    $this->rules();
    
    if($this->authorized)
    {
      $method = 'execute'.ucFirst($this->action);
     
      if(method_exists($this,$method))
      {
		   $this->$method();
		   $this->page->setContentFile($this->view);
       
      }
      else
        throw new \Exception(ErrorMessage::controllers(0,$method,get_class($this)));
    }
    else
    {
      if($this->url != null)
        $this->app()->httpResponse()->redirect($this->url);
      else
        $this->app()->httpResponse()->redirect_error('403');
    
    }
    if($this->app->user()->isAuthenticated())
        $_SESSION['user'] = serialize($this->app->user());
    
    
  }
  
  //Fonction vérifiant si la fonction rules associée à l'action existe et l'execute
  public function rules()
  {
    
        $method = 'rules'.ucFirst($this->action);
        if(method_exists($this,$method))
          $this->$method();
        elseif($this->admin)
            $this->rulesAdmin();
        else
            throw new \Exception(ErrorMessage::controllers(1,$method,get_class($this)));
        
  
  }
  
    public function rulesAdmin()
    {
        $this->url = '/connexion.htm';
        if($this->app()->user()->rank() == 'root')
            $this->authorized = true;
    }
    
  public function setView($value)
  {
     $parentModule = $this->admin ? 'ModulesAdmin' : 'Modules';
     $this->view = '../../Applications/'.$this->app()->name().'/'.$parentModule.'/'.ucfirst($this->module).'/View/'.strtolower($value).'.php';
  }

  public function setAction($value)
  {
    $this->action = $value;
  }

  public function setModule($value)
  {
    $this->module = $value;
  }

  public function page()
  {
    return $this->page;
  }
  
  public function managers()
  {
    return $this->managers;
  }



}
?>

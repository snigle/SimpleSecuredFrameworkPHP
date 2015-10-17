<?php

namespace Library;


abstract class Application {
  
  protected $name;

  protected $httpRequest;

  protected $httpResponse;

  protected $user;

  protected $config;
  
  protected $router;
  
  protected $controller;
  
  protected $crypt;
  
  protected $errorHandler;
  
  protected $error = false;

  //initialise les attibuts et instancie les objets
  public function __construct()
  {

    //Recupération du nom de la classe en enlevant le namespace
    $this->name = preg_replace("#^.*\\\#",'',get_class($this));
    
    //Gestion des erreurs
    $this->setErrorParameters();
    
    
    //Récupération du fichier de configuration
    $this->config = new Config($this, 'app');
    $this->crypt = new CryptPassword($this);
       
    //Paramétrage de l'email. N'a pas été fait avant pour être sur que la configuration n'a pas d'erreur.
    $root = $this->config()->get('root');
    
    if(isset($root['email']))
    {
        $email = new \Library\Mail($this);
        $this->errorHandler->attach($email);
    }
    
    //Instanciation des arguments
    $this->user = isset($_SESSION['user'])? unserialize($_SESSION['user']) : new User(null);
    $this->httpResponse = new HTTPResponse($this);
    
    //Creation du controller demandé si il existe
    $this->router = new \Library\Router($this);
    $this->controller = $this->router->getController($this);
    
  }
  
  public function setErrorParameters()
  {
    //Gestion des erreurs
    $this->errorHandler = new \Library\ErrorHandler($this);
     
    set_error_handler(array ($this->errorHandler, 'error'),E_ALL | E_STRICT);
    set_exception_handler(array ($this->errorHandler, 'exception'));
    
    $log = new \Library\Log($this);
    $this->errorHandler->attach($log);
    
  }

  final public function getHttpRequest()
  {
    return $this->httpRequest;
  }

  final public function httpResponse()
  {
    return $this->httpResponse;
  }

  final public function name()
  {
    return $this->name;
  }
  
  public function config()
  {
    return $this->config;
  }

  public function user()
  {
    return $this->user;
  }
  public function setUser(User $value)
  {
  	$this->user = $value;
  }
  public function error()
  {
    return $this->error;
  }
  public function setError($value)
  {
    $this->error = $value;
  }
  
  public function crypt()
  {
    return $this->crypt;
  }

  
  public function controller()
  {
    return $this->controller;
  }
  public function router()
  {
    return $this->router;
  }
  
  //Chargement et transmission de la réponse
  public function run()
  {
    $this->controller->execute();
    $this->httpResponse->setPage($this->controller->page());
    $this->httpResponse->send();
    
    
  }
  
 public function __destruct()
 {
    $_SESSION['user'] = serialize($this->user());
 }
  


}
?>

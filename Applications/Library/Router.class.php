<?php
/*
Classe permettant d'obtenir le controller en fonction de l'url
Elle se base sur le fichier de configuration routes.xml
*/
namespace Library;
class Router extends ApplicationComponent 
{
  
  protected $config;
  
  public function __construct($app)
  {
    parent::__construct($app);
    $this->config = new Config($app,'routes');
  
  }
  
  //Permet de retourner le controller en fonction de l'url
  public function getController()
  {
  	$controller = null;
  	
  	foreach($this->config->getList('route') as $route)
  	{
  	  if(isset($route['url']) && isset($route['module']) && isset($route['action']) && isset($route['method']))
  	  {
  	    if(preg_match("#^".$route['url']."$#", $_SERVER['REQUEST_URI'], $matches) AND $_SERVER['REQUEST_METHOD']==strtoupper($route['method']))
  	    {
  	    
  	      $module = ucfirst($route['module']);
    	  $action = ucfirst($route['action']);
          $admin = preg_match("#^/admin/#", $_SERVER['REQUEST_URI']);
          //Génère le nom de la classe du controller
          $namespace = '\\'.$this->app()->name();
           if($admin)
            $namespace .='\\ModulesAdmin\\'.$module;
          else
            $namespace .='\\Modules\\'.$module;
          $namespace .='\\'.$module.'Controller';
          
          //Génère le chemin du fichier à importer
          $file = '../../Applications'.str_replace('\\','/',$namespace).'.class.php';
          
          if(file_exists($file))
    	     $controller = new $namespace($this->app(), $module, $action, $admin);
    	    else
    	      throw new \Exception(ErrorMessage::router(0,$file));
    	 
    	 //Ajout des variables $_GET
    	  if(isset($route['vars']))
          { 
            $vars = explode(',',$route['vars']);
            foreach($vars as $key => $var)
            {
                if(isset($matches[$key+1]))
                {
                    $_GET[$var] = $matches[$key+1];
                }
            }
          }
          
          
    	    break;
  	    }
  	  }
  	  else
  	    throw new \Exception(ErrorMessage::router(1));
  	}
  	if (!$controller)
  	{
  	 $this->app()->httpResponse()->redirect_error('404');
  	}
  	
  	
    return $controller;
  }
  
  /*
  nom : getUrl
  precond : nom du module
               nom de l'action
  postcond : retourne l'url correspondant au module et à l'action
  */
    public function getUrl($module,$action,$vars = array())
    {
        $found=false;
        $url = "";
        foreach($this->config->getList('route') as $route)
  	    {
  	        if(strtolower($module) == strtolower($route['module']) && strtolower($action) == strtolower($route['action']))
  	        {
  	            $url = $route['url'];
  	            if(isset($route['vars']) )
  	                $varsName = explode(',',$route['vars']);
  	            else
  	                $varsName = array();
                if(sizeof($varsName) == sizeof($vars))
                {
                    $url = preg_replace("#\\\#","",$url);
                    foreach($vars as $var)
                        $url = preg_replace("#\(.+\)#",$var,$url,1);
                    $found = true;
                    break;
                }
  	               //else
  	                  //  throw new \Exception(ErrorMessage::router(2));
  	            
  	                  
  	        }
  	    }
  	    if(!$found)
  	        throw new \Exception(ErrorMessage::router(2));
  	    return $url;
    
    
    }

}
?>

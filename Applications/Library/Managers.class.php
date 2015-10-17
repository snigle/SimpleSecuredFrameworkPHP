<?php

namespace Library;
class Managers extends ApplicationComponent
{
  //liste des managers disponibles
  protected $managers = array();

  public function getManagerOf($module)
  {
    //Si on n'a jamais instancié ce manager
    if(!isset($this->managers[$module]))
    {
      //Génère le nom de la classe à appeler
      $namespace = '\\'.$this->app()->name().'\\Model\\'.ucFirst($module).'Manager';
      
      //Génère le nom du fichier à inclure
      $file = '../../Applications'.str_replace('\\','/',$namespace).'.class.php';
      
      if(file_exists($file))
      {
        //Recupération de la configuration de la pdo
        $pdo = $this->app()->config()->get('pdo');
        
        if(isset($pdo['dao'],$pdo['host'],$pdo['db'],$pdo['user'],$pdo['password']))
        {
          $method = 'get'.ucFirst($pdo['dao']).'Connexion';
          $this->managers[$module] = new $namespace(PDOFactory::$method($pdo['host'],$pdo['db'],$pdo['user'],$pdo['password']));
        }
        else
        {
          throw new \Exception(ErrorMessage::managers(1,$this->app()->config()->file()));
        }
      }
      else
        throw new \Exception(ErrorMessage::managers(0,$file));
    }
   
    return $this->managers[$module];
      
  }

}
?>

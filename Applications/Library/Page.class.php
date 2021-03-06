<?php

namespace Library;
class Page extends ApplicationComponent {
  //Le nom du fichier a inclure
  protected $contentFile;
  
  protected $layout = true;
  //Les variables de la page
  //vars['nom variable'] = valeur;
  //faire un explode pour recreer les variables
  protected $vars = array();

  public function setContentFile($value)
  {
    $this->contentFile = $value;
  }

  //Precondition :
  //	$name est une chaine non nulle
  public function addVar($name, $value)
  {
   if(is_string($name) AND !empty($name))
    $this->vars[$name]=$value;
  
  }

  public function getGeneratedPage()
  {
     
      extract($this->vars);
      //Ferme le tampon au cas ou il a été ouvert et qu'il y a eut une erreur lors de l'inclusion
      ob_end_clean();
      ob_start();
      if(file_exists($this->contentFile))
        require $this->contentFile; 
      $content = ob_get_clean();
      
      if($this->layout)
      {
          ob_start();
          require '../../Applications/'.$this->app()->name().'/Layout/layout.php';
          $result = ob_get_clean();
      }
      else
        $result = $content;
      
      return $result;
  }
  
  public function getUrl($module,$action,$vars = array())
  {
    return $this->app()->router()->getUrl($module,$action,$vars);
  }
  
  public function setLayout($layout)
  {
    $this->layout = (bool) $layout;
  }
  
  public function layout()
  {
    return $this->layout;
  }

}
?>

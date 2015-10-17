<?php

namespace Library;
class Config extends ApplicationComponent
{
  protected $vars;
  protected $dom;
  protected $file;

  //assignation de toutes les variables de configuration
  public function __construct($app,$name)
  {
    parent::__construct($app);
    $this->dom = new \DOMDocument; 
    $this->file = '../../Applications/'.$this->app->name().'/Config/'.$name.'.xml';

  	if(file_exists($this->file))
  	{
  	  $this->dom->load($this->file);
  	  $this->setVars();
  	}
  	else
  	{
  	  throw new \Exception(ErrorMessage::config(0,$this->file));
    }
  }

  public function getConfigDOM($tagName)
  {
    //Récupération du fichier de configuration
  	return $this->dom->getElementsByTagName($tagName);
  	
  }
  
  public function getList($key)
  {
    if(isset($this->vars[$key]))
     return $this->vars[$key];
    else
      throw new \Exception(ErrorMessage::config(1,$key,$this->file));
  }
  
  public function get($key)
  {
    if(isset($this->vars[$key]) AND isset($this->vars[$key][0]))
     return $this->vars[$key][0];
    else
      throw new \Exception(ErrorMessage::config(1,$key,$this->file));
  }
  
  public function file()
  {
    return $this->file;
  }
  
  public function setVars()
  {
  //Parcour de toutes les balises conf
    foreach ($this->dom->getElementsByTagName('conf') as $conf)
    {
    //Parcour de tout les noeuds enfants
      foreach ($conf->childNodes as $element)
      {
      //Si le noeud enfant est un noeud (pas un txt)
        if ($element->nodeType == XML_ELEMENT_NODE)
        {
          //On parcourt ses attributs
          $tabAttribut = array();
          foreach ($element->attributes as $attr=> $node)
          {
            //On sauvegarde dans un même tableau les attributs
            $tabAttribut[$node->name] = $node->value; 
          }
          //On ajoute le tableau a notre tableau pere
          $this->vars[$element->tagName][]=$tabAttribut;
        }
      }
      
    }

  }

}
?>

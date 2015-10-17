<?php
namespace Library;
abstract class Entity// implements \ArrayAccess
{
	protected $id = 0;
    public static $view = true;
	
	public function __construct($tab)
	{
		if(!empty($tab))
			$this->hydrate($tab);
	  //Vérification que les méthodes sont protégées
	  $this->protect();
	}
	
	public static function setView($val)
	{
	  self::$view = (bool) $val;
	}
	
	public function __call($method, $arg)
	{
	    if(method_exists($this,$method))
	    {

	      //On regarde si la méthode retourne quelque chose
	      $result = $this->$method(implode(', ', $arg));
	      
	      //Si ca vient de page on sécurise
	      if($result AND self::$view)
	      {
	         return htmlspecialchars($result);
	      }
	      else
	      {
	         return $result;
	      }
	    }
	    else
	      throw new \Exception(ErrorMessage::entity(1,$method,get_class($this)));
	}
	
	/*Vérifie si les méthodes sont protégées*/
	protected function protect()
	{
	   $reflector = new \ReflectionClass($this);
		 foreach($reflector->getMethods() as $method)
		 {
		    if(!preg_match('#^(__|set).+#',$method->name) AND !$method->isprotected())
		      throw new \Exception(ErrorMessage::entity(0,$method->name,$reflector->name));
	   }
	}
	
	protected function hydrate(Array $tab)
	{

		foreach($tab as $key => $value)
		{
			//Si il y a un point devant la chaine
			if($pos = strpos($key,'.'))
				$key = substr($key,$pos,-1);
				
			$method = 'set'.ucFirst($key);
			if(method_exists($this,$method))
			{
				  $this->$method($value);
		  }
		}
	}
	
	//Vérifie si l'entité existe en base de donnée ou pas
	protected function isNew()
	{
		return empty($this->id);
	}
	
	//Getters Setters
	protected function setId($value)
	{
		$this->id = (int) $value;
	}
	
	protected function id()
	{
		return $this->id;
	}

	
	//Array access :
/*	public function offsetSet($offset, $value) {
     $this->$offset = $value;

    }
    public function offsetExists($offset) {
        return true;
    }
    public function offsetUnset($offset) {
        
    }
    public function offsetGet($offset) {
        $method = $offset;
        return $this->$method();
    }
*/
}

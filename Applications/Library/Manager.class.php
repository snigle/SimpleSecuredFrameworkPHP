<?php

namespace Library;
class Manager 
{
  protected $pdo;

  public function __construct($pdo)
  {
    $this->protect();
    $this->pdo = $pdo;
    
  }
  
  public function __call($method, $arg)
	{
	    if(method_exists($this,$method))
	    {
            Entity::setView(false);
            $result = call_user_func_array(array($this,$method),$arg);
            //$result = $this->$method($arg[0],$arg[1]);
	        Entity::setView(true);
	        return $result;
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
		    if(!preg_match('#^(__).+#',$method->name) AND !$method->isprotected())
		      throw new \Exception(ErrorMessage::entity(0,$method->name,$reflector->name));
	   }
	}
	
	protected function save(Entity $entity)
	{
	  if($entity->isNew())
	    $this->add($entity);
	  else
	    $this->update($entity);
	  
	  return $this->pdo->lastInsertId();
	  
	}

}


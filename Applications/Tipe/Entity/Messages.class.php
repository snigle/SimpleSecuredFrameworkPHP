<?php
namespace Tipe\Entity ;
class Messages extends \Library\Entity
{
protected $message ;
protected $idLogin ;
protected $time ;
// SETTER
protected function setMessage($variable)
{
$this->message = $variable ;// assigne un message
}
protected function setIdLogin($variable)
{
$this->idLogin = $variable ;// assigne un idLogin
}
protected function setTime($variable)
{
$this->time = $variable ;// assigne un temps
}
// GETTER
protected function message()
{
return $this->message;// recupere le message
}
protected function idLogin()
{
return $this->idLogin;// recupere le idLogin
}
protected function time()
{
return $this->time;// recupere le temps
}
}

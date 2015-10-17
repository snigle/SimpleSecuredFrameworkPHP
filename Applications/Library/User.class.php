<?php

namespace Library;

class User extends Entity
{
  protected $authenticated = false;
  protected $login;
  protected $password;
  protected $flash;
  protected $rank = null;
  
  
  
  protected function isAuthenticated()
  {
    return $this->authenticated;
  }
  
	protected function login()
	{
		return $this->login;
	}
	protected function hasFlash()
	{
	    return !empty($this->flash);
	}
	protected function flash()
	{
		$result = $this->flash;
		$this->flash = "";
		return $result;
	}
	protected function setFlash($value)
	{
		$this->flash=$value;
	}
	protected function password()
	{
		return $this->password;
	}
  public function setLogin($value)
	{
		$this->login = $value;
	}
	protected function rank()
	{
		return $this->rank;
	}
  public function setRank($value)
	{
		$this->rank = $value;
	}
	public function setPassword($value)
	{
		$this->password = $value;
	}
  public function setAuthenticated()
  {
    $this->authenticated = true;
  }
}

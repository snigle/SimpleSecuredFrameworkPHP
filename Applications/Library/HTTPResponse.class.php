<?php

namespace Library;

class HTTPResponse extends ApplicationComponent
{
  protected $page;
  
  
  public function send()
  {
    exit($this->page->getGeneratedPage());
  }


  public function setPage($page)
  {
    $this->page = $page;
  
  }
  
  public function redirect($url)
  {
    header('Location: '.$url);
  }
  
  public function redirect_error($num)
  {
    $this->app->setError(true);
    $file = '../../Applications/Erreurs/'.$num.'.php';
    $this->page = new Page($this->app());
    if(file_exists($file))
    {
      $this->page->setContentFile($file);
      $this->send();
    }
    else
      throw new \Exception(ErrorMessage::httpResponse(0,$file));
  }
}

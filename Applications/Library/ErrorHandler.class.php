<?php
namespace Library;

class ErrorHandler extends ApplicationComponent implements \SplSubject
{
  protected $observers = array();
  protected $formatedError;
  
  public function attach(\SplObserver $observer)
  {
    if(!in_array($observer,$this->observers))
      $this->observers[] = $observer;
  }
  
  public function detach(\SplObserver $observer)
  {
    if($key = array_keys($observer))
      unset($this->observers[$key]);
  }
  
  public function notify()
  {
    foreach($this->observers as $observer)
    {
      $observer->update($this); 
    }
    $this->app()->httpResponse()->redirect_error("500");
  }
  
  public function error($numero, $message, $fichier, $ligne)
  {
    $this->formatedError = 'Erreur n°'.$numero.': '.$message.'';
    $this->formatedError .='; Ligne '.$ligne.'; Fichier '.$fichier;
    $this->notify();
    
  }
  
  public function exception(\Exception $exception)
  {
    $this->formatedError = 'Exception n°0: '.$exception->getMessage().'';
    $this->notify();
    
  }
  public function formatedError()
  {
    return $this->formatedError;
  }

}

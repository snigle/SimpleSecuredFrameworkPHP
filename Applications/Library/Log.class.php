<?php
namespace Library;

class Log extends ApplicationComponent implements \SplObserver
{

  /*Fonction appelée lors d'une erreur*/
  public function update(\SplSubject $subject)
  {
    $error = $subject->formatedError();
    $date = '['.date('d/m/y').']['.date('H:i:s').']';
    $texte = "\n".$date.$error.'; Repetition ';
    $name = "../../Applications/".$this->app()->name()."/error_log.txt";
    
    //Récupération de la derniere ligne du fichier
    $fichier = file($name);
    $position = sizeof($fichier)-1;
    if($position >= 0)
        $derniere = $fichier[$position];
    
    if(!isset($derniere) OR strpos($derniere,$error)==0)
        file_put_contents($name,$texte, FILE_APPEND );
    else
        file_put_contents($name,$date.' ', FILE_APPEND );
        
 
  }

}

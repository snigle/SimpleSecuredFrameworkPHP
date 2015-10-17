<?php

namespace Library;

abstract class ApplicationComponent {
  protected $app;

  //Initialise l'application demandée
  public function __construct(Application $app)
  {
    $this->app = $app;
  }

  final public function app()
  {
    return $this->app;
  }



}
?>

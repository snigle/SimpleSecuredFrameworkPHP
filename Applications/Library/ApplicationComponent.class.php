<?php

namespace Library;

abstract class ApplicationComponent {
  protected $app;

  //Initialise l'application demand�e
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

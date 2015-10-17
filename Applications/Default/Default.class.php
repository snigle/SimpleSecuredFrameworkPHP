<?php

namespace Default;

class Default extends \Library\Application
{

  public function run()
  {
    /*if(!$this->user->isAuthenticated())
      $this->controller = new \Default\Modules\Connexion\ConnexionController($this,'Connexion','connexion');
      */
      parent::run();

  }

}

<?php

namespace Tipe;

class Tipe extends \Library\Application
{

  public function run()
  {
    /*if(!$this->user->isAuthenticated())
      $this->controller = new \Tipe\Modules\Connexion\ConnexionController($this,'Connexion','connexion');
      */
      parent::run();

  }

}

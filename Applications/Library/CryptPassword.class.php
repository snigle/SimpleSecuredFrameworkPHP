<?php

namespace Library;

class CryptPassword extends ApplicationComponent
{
  public function crypt(User $utilisateur)
  {
    $file = file('../../Applications/'.$this->app()->name().'/Config/key.ini');
    if(sizeof($file)==2)
    {
        $file[0] = str_replace("\n","",$file[0]);
        $file[1] = str_replace("\n","",$file[1]);
        
        $key1 = md5($utilisateur->id()).$file[0].md5($utilisateur->id());
        $key2 = md5($utilisateur->id()).$file[1].md5($utilisateur->id());
        return md5(sha1($key1.$utilisateur->password().$key2));
      }
     else
        throw new \Exception(ErrorMessage::cryptPassword(1));
  }

}

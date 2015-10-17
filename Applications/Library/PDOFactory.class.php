<?php
namespace Library;

class PDOFactory
{
  public static function getMysqlConnexion($host,$db,$user,$password)
  {
    $pdo = new \PDO('mysql:host='.$host.';dbname='.$db,$user,$password);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }
  
  public static function getPgsqlConnexion()
  {
    $pdo = new \PDO('pgsql:host='.$host.';dbname='.$db,$user,$password);
    $pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);
    return $pdo;
  }
  

  
 }
 ?>

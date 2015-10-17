<?php

namespace Library;

abstract class ErrorMessage
{
  public static function router($id,$var1=null)
  {
    switch ($id)
    {
      //Erreur Router.class.php
      case 0:
        return "Le fichier ".$var1." n'a pas été cré veuillez vous référer à la documentation.";
        break;
      case 1:
        return "Les routes ne sont pas correctement configurées, veuillez vous référer à la documentation";
        break;
        case 2:
        return "Le nombre de variables envoyées ne correspond pas au lien dans le fichier routes.xml";
        break;
      default:
        return 'Le message d\'erreur n\'a pas été configuré';
    } 
  
  }
  
  public static function controllers($id,$var1,$var2)
  {
    switch ($id)
    {
      case 0: //Si il n'y a pas la méthode execute
        return "La méthode ".$var1." est introuvable dans la classe ".$var2.". Vérifiez la configuration des url et la classe indiquée pour résoudre le problème";
        break;
      case 1: //Si il n'y a pas la méthode rules
        return "La méthode ".$var1." est introuvable dans la classe ".$var2.". Vous devez spécifier les droits pour exécuter l'action demandée.";
        break;
      default:
        return 'Le message d\'erreur n\'a pas été configuré';
    } 
  }
  
  public static function managers($id,$var1)
  {
    switch ($id)
    {
      case 0:
        return "Vous tentez d'inclure le fichier ".$var1.". Mais celui-ci n'existe pas.";
        break;
      case 1:
        return "La configuration de votre base de données est incorrecte dans le fichier : ".$var1.". Veuillez vous référer à la documentation";
        break;
      default:
        return 'Le message d\'erreur n\'a pas été configuré';
    } 
  }
  
  public static function httpResponse($id,$var1)
  {
    switch ($id)
    {
      case 0:
        return "Vous devez créer le fichier ".$var1." pour personnaliser vos erreurs.";
        break;
      default:
        return 'Le message d\'erreur n\'a pas été configuré';
    } 
  }
  
  public static function config($id,$var1,$var2=null)
  {
    switch ($id)
    {
      case 0:
        return "Le fichier de configuration ".$var1." n'existe pas, veuillez vous référer à la documentation.";
        break;
      case 1:
        return "La configuration correspondant au mot clé '".$var1."' n'existe pas. Veuillez vérifier le fichier ".$var2.".";
        break;
      default:
        return 'Le message d\'erreur n\'a pas été configuré';
    } 
  }
  
  public static function entity($id,$var1,$var2=null)
  {
    switch ($id)
    {
      case 0:
        return "Les méthodes get (accesseurs) doivent être protected. Cela permet d'empécher toute faille de sécurité XSS liée à un objet : corrigez la méthode public $var1 dans la classe $var2";
        break;
      case 1:
        return "La méthode $var1 n'existe pas dans la classe $var2";
        break;
     
      default:
        return 'Le message d\'erreur n\'a pas été configuré';
    } 
  }
   public static function cryptPassword($id)
  {
    switch ($id)
    {
      case 0:
        return "Le fichier key.ini du dossier Config de l'application est invalide. Vous pouvez en générer un nouveau en installant une nouvelle application.";
        break;

      default:
        return 'Le message d\'erreur n\'a pas été configuré';
    } 
  }

}

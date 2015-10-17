<?php
namespace Tipe\ModulesAdmin\Inscription;

class InscriptionController extends \Library\Controllers
{

public function executeForm()
{
	$managerInscription = $this->managers->getManagerOf("Inscription");
	$this->page->addVar("listeDesUtilisateurs",$managerInscription->select());
}

public function executeSend()
{
	$managerInscription = $this->managers->getManagerOf("Inscription");
	$utilisateur = new \Tipe\Entity\Utilisateur($_POST);
	$utilisateur->setId($managerInscription->save($utilisateur));
	$utilisateur->setPassword($this->app()->crypt()->crypt($utilisateur));
	$managerInscription->save($utilisateur);
	$this->app()->httpResponse()->redirect($this->app()->router()->getUrl('Inscription','form'));
}

public function executeSupprimer()
{
	$managerInscription = $this->managers->getManagerOf("Inscription");
	$utilisateur = new \Tipe\Entity\Utilisateur($_GET);
	$managerInscription->delete($utilisateur);
	$this->app()->httpResponse()->redirect($this->app()->router()->getUrl('Inscription','form'));
}
}

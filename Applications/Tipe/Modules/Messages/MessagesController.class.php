<?php
namespace Tipe\Modules\Messages;

class MessagesController extends \Library\Controllers
{
public function rulesAfficherMessage()
{
 $this -> authorized = true;
}

public function rulesSaveMessage()
{
	$this->authorized = $this->app()->user()->isAuthenticated();
}

public function rulesSupprimerMessage()
{
	$this->authorized = $this->app()->user()->isAuthenticated();
}

public function executeAfficherMessage()
{
	$managerMessage = $this->managers->getManagerOf("Messages");
	$this->page->addVar("listeDeMessages",$managerMessage->select());
}

public function executeSaveMessage()
{
	$managerMessage = $this->managers->getManagerOf("Messages");
	$message = new \Tipe\Entity\Messages($_POST);
	$managerMessage->save($message);
	$this->app()->httpResponse()->redirect($this->app()->router()->getUrl('messages','afficherMessage'));
}

public function executeSupprimerMessage()
{
	$managerMessage = $this->managers->getManagerOf("Messages");
	$message = new \Tipe\Entity\Messages($_GET);
	$managerMessage->delete($message);
	$this->app()->httpResponse()->redirect($this->app()->router()->getUrl('messages','afficherMessage'));
}

}

<?php
namespace Tipe\Model;
class MessagesManager extends \Library\Manager
{
protected function add(\Tipe\Entity\Messages $messages)
{
$req = $this->pdo->prepare('INSERT INTO messages(id,message,idLogin,time) VALUES ("",:message,:idLogin,:time)');
$req -> bindValue(':message',$messages->message());
$req -> bindValue(':idLogin',$messages->idLogin());
$req -> bindValue(':time',time());
$req -> execute();
}
protected function update(\Tipe\Entity\Messages $messages)
{
$req = $this->pdo->prepare('UPDATE messages SET message=:message,idLogin=:idLogin,time=:time WHERE id=:id');
$req -> bindValue(':message',$messages->message());
$req -> bindValue(':idLogin',$messages->idLogin());
$req -> bindValue(':time',$messages->time());
$req -> bindValue(':id',$messages->id());
$req -> execute();
}

protected function delete(\Tipe\Entity\Messages $messages)
{
	$req = $this->pdo->prepare('DELETE FROM messages WHERE id=:id');
	$req -> bindValue(':id',$messages->id());
	$req -> execute();
}

	protected function select()
	{
		$req = $this->pdo->prepare('SELECT * FROM messages ORDER BY id DESC');
		$req->execute();
		$res =array();
		while($donnee = $req->fetch(\PDO::FETCH_ASSOC))
			$res[] = new \Tipe\Entity\Messages($donnee);	
		return $res;
	}
}

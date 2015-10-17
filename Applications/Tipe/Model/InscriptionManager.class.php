<?php
namespace Tipe\Model;
class InscriptionManager extends \Library\Manager
{
protected function add(\Tipe\Entity\Utilisateur $utilisateur)
{
$req = $this->pdo->prepare('INSERT INTO user(id,login,rank) VALUES ("",:login,:rank)');
$req -> bindValue(':login',$utilisateur->login());
//$req -> bindValue(':password',$utilisateur->password());
$req -> bindValue(':rank',$utilisateur->rank());
$req -> execute();
}
protected function update(\Tipe\Entity\Utilisateur $utilisateur)
{
$req = $this->pdo->prepare('UPDATE user SET login=:login,password=:password,rank=:rank WHERE id=:id');
$req -> bindValue(':login',$utilisateur->login());
$req -> bindValue(':password',$utilisateur->password());
$req -> bindValue(':rank',$utilisateur->rank());
$req -> bindValue(':id',$utilisateur->id());
$req -> execute();
}

protected function delete(\Tipe\Entity\Utilisateur $utilisateur)
{
	$req = $this->pdo->prepare('DELETE FROM user WHERE id=:id');
	$req -> bindValue(':id',$utilisateur->id());
	$req -> execute();
}

protected function select()
{
$req = $this->pdo->prepare('SELECT * FROM user');
$req -> execute();
$res =array();
while($donnee = $req->fetch(\PDO::FETCH_ASSOC))
	$res[] = new \Tipe\Entity\Utilisateur($donnee);	
return $res;
}

protected function getByLogin($login)
{
	$req = $this->pdo->prepare('SELECT * FROM user WHERE login = :login');
	$req -> bindValue(':login',$login);
	$req -> execute();
	$donnee = $req->fetch(\PDO::FETCH_ASSOC);
	$res = new \Tipe\Entity\Utilisateur($donnee);	
	return $res;
}
}

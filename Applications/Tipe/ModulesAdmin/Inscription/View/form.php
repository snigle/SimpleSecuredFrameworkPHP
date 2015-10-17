<form method="post" action="<?php echo $this->app()->router()->getUrl('Inscription','send'); ?>">
<p><label>Login : <input type="text" name="login" /></label></p>
<br />
<p><label>Password : <input type="password" name="password" /></label></p>
<br />
<p><label for="rank">Rang : </label>
<select id="rank" name="rank" >
	<option value="inscrit">Utilisateur</option>
	<option value="root">Administrateur</option>
</select>
</p>
<br />
<input type="submit" value="Envoyer" />
</form>
<br />
<p>Liste des utilisateurs : <p>
<br />
<?php
foreach($listeDesUtilisateurs as $utilisateur)
{
	$id = array("id" => $utilisateur->id());
	echo $utilisateur->login().' '.$utilisateur->password().'  <a href="'.$this->app()->router()->getUrl('Inscription','supprimer',$id).'">X</a><br />';
}

?>

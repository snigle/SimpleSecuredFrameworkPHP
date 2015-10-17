<h1>Connexion</h1>

<form action="<?php echo $this->app()->router()->getUrl('Connexion','connexion'); ?>" method="post">
<p>
	<label for="login">Login : </label><input type="text" id="login" name="login" /><br/>
	<label for="password">Mot de passe : </label><input type="password" id="password" name="password" /><br/>
	<input type="submit" id="btnok" name="btnok" value="OK" />
</p>
</form>

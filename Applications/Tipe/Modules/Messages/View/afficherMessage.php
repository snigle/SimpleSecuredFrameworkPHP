<h1 class="h-text-1">Application Message</h1>
<form method="post" action="<?php echo $this->app()->router()->getUrl('Messages','saveMessage'); ?>">
<textarea name="message" id="message"></textarea>
<input type="submit" value="Envoyer" />
</form>
<br />
<p>Liste des messages : <p>
<br />
<?php
foreach($listeDeMessages as $message)
{
	$id = array("id" => $message->id());
	echo nl2br($message->message()).'  <a href="'.$this->app()->router()->getUrl('messages','supprimerMessage',$id).'">X</a><br />';
}
?>

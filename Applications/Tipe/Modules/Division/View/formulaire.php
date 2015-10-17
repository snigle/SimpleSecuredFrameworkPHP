<h1 class="h-text-1">Application Message</h1>
<br />
<form method="post" action="<?php echo $this->app()->router()->getUrl('Division','division'); ?>">
<input type="text" name="n1" />/<input type="text" name="n2" /><input type="submit" value="=" />
</form>
<?php if(!empty($res)) echo '<p> Le résultat est :'.$res; ?>

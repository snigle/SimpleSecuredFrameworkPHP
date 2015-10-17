<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <meta http-equiv="Content-Type"
 content="text/html; charset=utf-8">
  <title>Your Company</title>
  <link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="container">
<div id="header"> <img src="/images/logo.jpg" alt="" id="logo">
<h1 id="logo-text">Your Company</h1>
</div>
<div id="nav">
<ul>
  <li><a href="/messages.htm">Home</a></li>
  <?php if ($this->app()->user()->isAuthenticated())
  echo '<li><a href="'.$this->app()->router()->getUrl('connexion','deconnexion').'">Deconnexion</a></li>';
  else echo '<li><a href="'.$this->app()->router()->getUrl('connexion','connexion').'">Connexion</a></li>';
  ?>
  <li><a href="<?php echo $this->app()->router()->getUrl('Inscription','form');?>">Inscription(Admin)</a></li>
  <li><a href="<?php echo $this->app()->router()->getUrl('Division','division');?>">Division</a></li>
</ul>
</div>
<div id="site-content">
<div id="col-left">
<?php if($this->app()->user()->hasFlash())	echo $this->app()->user()->flash(); ?>
<?php echo $content;  ?>
</div>
</div>
<div id="footer">
<!--DO NOT Remove The Footer Links-->
<p>&copy; Copyright 2010. Designed by <a target="_blank"
 href="http://www.htmltemplates.net">HTML Templates</a><br>
<!--Template distributed by--><a href="http://www.htmltemplates.net"></a>
<!--Funding and graphics by--><a href="http://www.onlinecasino.im"></a>
<!--DO NOT Remove The Footer Links-->
</p>
</div>
</div>
</body>
</html>

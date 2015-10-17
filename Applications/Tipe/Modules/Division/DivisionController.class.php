<?php
namespace Tipe\Modules\Division;

class DivisionController extends \Library\Controllers
{

public function rulesFormulaire()
{
	$this -> authorized = true;
}

public function rulesDivision()
{
 $this -> authorized = true;
}

public function executeFormulaire()
{
 $this->page->addVar("res",null);
}

public function executeDivision()
{
	$n1 = $_POST["n1"];
	$n2 = $_POST["n2"];
	$res = $n1/$n2;
	$this->page->addVar("res",$res);
	$this->setView('formulaire');
}
}

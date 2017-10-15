<?php
require_once __DIR__ . '/classes/crkrdir.php';

class RkFail extends CRkRdir{
	
	public function __construct() 
	{
		parent::__construct('rkfail.log', 'fail');
	}
}
new RkFail();


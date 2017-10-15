<?php
require_once __DIR__ . '/classes/crkrdir.php';

class RkSuccess extends CRkRdir{
	
	public function __construct() 
	{
		parent::__construct('rksuc.log', 'success');
	}
}
new RkSuccess();

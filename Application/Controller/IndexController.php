<?php
/**
* Index Controller Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.15.1026
* @license SaSeed\license.txt
*/ 

namespace Application\Controller;

use SaSeed\Output\View;

class IndexController
{

	public static function index()
	{
		View::redirect('http://angularity.pe.hu');
	}


}

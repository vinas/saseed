<?php
/**
* Category Controller Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/03
* @version 1.16.1103
* @license SaSeed\license.txt
*/

namespace Application\Controller;

use SaSeed\Output\View;
use SaSeed\Handlers\Exceptions;

use Application\Service\CategoryService;

class CategoryController
{

	private $service;

	public function __construct()
	{
		$this->service = new CategoryService();
	}

	public function getList()
	{
		$res = [];
		try {
			$res = $this->service->getList();
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			View::renderJson($res);
		}
	}
}

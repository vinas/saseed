<?php
/**
* Users Controller Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.1026
* @license SaSeed\license.txt
*/

namespace Application\Controller;

use SaSeed\Output\View;
use SaSeed\Handlers\Request;
use SaSeed\Handlers\Exceptions;
use SaSeed\Handlers\Mapper;

use Application\Model\UserModel;
use Application\Model\UserResponseModel;
use Application\Service\ResponseHandlerService;
use Application\Service\UserService;

class UsersController
{

	private $params;
	private $service;

	public function __construct()
	{
		$this->params = new Request();
		$this->service = new UserService();
	}

	public function listUsers()
	{
		$res = [];
		try {
			$res = $this->service->listUsers();
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			View::renderJson($res);
		}
	}

	public function getUser()
	{
		$responseHandler = new ResponseHandlerService();
		$res = $responseHandler->handleResponse(new UserResponseModel());
		try {
			$params = $this->params->getParams();
			$res = $this->service->getUserById($params[0]);
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			View::renderJson($res);
		}
	}

	public function save()
	{
		$responseHandler = new ResponseHandlerService();
		$res = $responseHandler->handleResponse(new UserResponseModel());
		try {
			$mapper = new Mapper();
			$user = $mapper->populate(new UserModel(), $this->params->getParams());
			$res = $this->service->save($user);
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			View::renderJson($res);
		}
	}

	public function delete()
	{
		$responseHandler = new ResponseHandlerService();
		$res = $responseHandler->handleResponse(new UserResponseModel());
		try {
			$params = $this->params->getParams();
			$this->service->delete($params[0]);
			$res = $responseHandler->handleResponse($res, 202);
		} catch (Exception $e) {
			Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
		} finally {
			View::renderJson($res);
		}
	}
}

<?php
/**
* Application Error Handling Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/10/19
* @version 1.16.1026
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;

class ResponseHandlerService
{
	public function handleResponse($res, $code = false)
	{
		switch ($code) {
			case 100:
				$res->setCode($code);
				$res->setMessage($this->error('Empty or invalid user data.'));
				break;
			case 101:
				$res->setCode($code);
				$res->setMessage($this->error('User could not be saved.'));
				break;
			case 102:
				$res->setCode($code);
				$res->setMessage($this->error('User could not be loaded.'));
				break;
			case 103:
				$res->setCode($code);
				$res->setMessage($this->error('Empty or invalid user id.'));
				break;
			case 200:
				$res->setCode($code);
				$res->setMessage($this->info('User saved successfully.'));
				break;
			case 201:
				$res->setCode($code);
				$res->setMessage($this->info('User loaded successfully.'));
				break;
			case 202:
				$res->setCode($code);
				$res->setMessage($this->info('User deleted successfully.'));
				break;
			default:
				$res->setCode(666);
				$res->setMessage($this->warning());
		}
		return $res;
	}

	private function error($msg = false)
	{
		if ($msg) {
			return 'Error: '.$msg;
		}
		return 'Error: An unexpected error. not that we are expecting any...';
	}

	private function warning($msg = false)
	{
		if ($msg) {
			return 'Warning: '.$msg;
		}
		return 'Warning: Some uninterpreted odd behavior has occured. Fishy...';
	}

	private function info($msg = false)
	{
		if ($msg) {
			return 'Info: '.$msg;
		}
		return 'Info: You should take notice of somehing. We just happened to forget tell you what.';
	}
}

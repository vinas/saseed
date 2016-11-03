<?php
/**
* Post Controller Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/03
* @version 1.16.1103
* @license SaSeed\license.txt
*/

namespace Application\Controller;

use SaSeed\Output\View;
use SaSeed\Handlers\Requests;
use SaSeed\Handlers\Exceptions;
use SaSeed\Handlers\Mapper;

use Application\Service\PostService;
use Application\Model\PostModel;

class PostController
{

    private $service;

    public function __construct()
    {
        $this->service = new PostService();
    }

    public function save()
    {
        $res = [];
        try {
            $params = Requests::getParams();
            $post = Mapper::populate(new PostModel(), $params);
            $res = $this->service->save($post);
            $this->service->tieToParent($params['parentId'], $res->getId());
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            View::renderJson($res);
        }
    }

    public function getTitleList()
    {
        $res = [];
        try {
            $res = $this->service->getTitleList();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            View::renderJson($res);
        }
    }

    public function getChildren()
    {
        $res = [];
        try {
            $res = $this->service->getChildren();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            View::renderJson($res);
        }
    }

    public function get()
    {
        $res = [];
        try {
            $res = $this->service->getChildren();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            View::renderJson($res);
        }
    }
}

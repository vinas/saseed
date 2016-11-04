<?php
/**
* Post Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/03
* @version 1.16.1103
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;

use Application\Factory\PostFactory;

class PostService {

    private $factory;

    public function __construct()
    {
        $this->factory = new PostFactory();
    }

    public function getById($id = false)
    {
        try {
            if ($id > 1)
                return $this->factory->getById($id);
            if ($id == 1) {
                $children = $this->getChildren(1);
                if (isset($children[0]))
                    return $this->factory->getById($children[0]->getChildId());
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        }
        return (object) [];
    }

    public function save($post)
    {
        try {
            $post->setTitle(str_replace("'", '&#39;', $post->getTitle()));
            $post->setContent(str_replace("'", '&#39;', $post->getContent()));
            $post->setLastUpdated(date("Y-m-d"));
            if ($post->getId() > 0) {
                $this->factory->update($post);
            } else {
                $post->setDate(date("Y-m-d"));
                $post = $this->factory->saveNew($post);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $post;
        }
    }

    public function getTitleList($filter)
    {
        try {
            if ($filter)
                return $this->factory->getTitlesByTitle($filter);
            return $this->factory->listAllTitleActive();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
            return [];
        }
    }

    public function tieToParent($parent, $child)
    {
        $res = false;
        try {
            $this->factory->eraseChild($child);
            $this->factory->setParentalRelation($parent, $child);
            $res = true;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $res;
        }
    }

    public function getChildren($parent)
    {
        $res = [];
        try {
            $res = $this->factory->getChildren($parent);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $res;
        }
    }
}

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

    public function save($post)
    {
        try {
            $post->setTitle(str_replace("'", '&#39;', $post->getTitle()));
            $post->setContent(str_replace("'", '&#39;', $post->getContent()));
            if ($post->getId() > 0) {
                $this->factory->update($post);
            } else {
                $post = $this->factory->saveNew($post);
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $post;
        }
    }

    public function getTitleList()
    {
        $res = [];
        try {
            $res = $this->factory->listAllTitleActive();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $res;
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

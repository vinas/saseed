<?php
/**
* Post Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.2027
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Handlers\Mapper;
use SaSeed\Handlers\Exceptions;

use Application\Model\PostModel;
use Application\Model\CategoryResponseModel;
use Application\Model\TitleModel;

class PostFactory extends \SaSeed\Database\DAO {

    private $db;
    private $queryBuilder;
    private $table = 'posts';

    public function __construct()
    {
        $this->db = parent::setDatabase('hostinger');
        $this->queryBuilder = parent::setQueryBuilder();
    }

    public function getById($postId = false)
    {
        $post = new PostModel();
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->where([
                    'id',
                    '=',
                    $postId,
                    $this->queryBuilder->getMainTableAlias()
                ]);
            $post = Mapper::populate(
                    $post,
                    $this->db->getRow($this->queryBuilder->getQuery())
                );
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $post;
        }
    }

    public function listAll()
    {
        $post = [];
        try {
            $this->queryBuilder->from($this->table);
            $post = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($post); $i++) {
                $post[$i] = Mapper::populate(
                        new PostModel(),
                        $post[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $post;
        }
    }

    public function listAllActive()
    {
        $list = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->where(['isActive', '=', 1]);
            $list = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($list); $i++) {
                $list[$i] = Mapper::populate(
                        new PostModel(),
                        $list[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function listAllTitleActive()
    {
        $list = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->select(['id', 'title']);
            $this->queryBuilder->where(['isActive', '=', 1]);
            $list = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($list); $i++) {
                $list[$i] = Mapper::populate(
                        new TitleModel(),
                        $list[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }

    public function saveNew($post)
    {
        try {
            $now = date("Y-m-d");
            $this->db->insertRow(
                $this->table,
                array(
                    $post->getCategoryId(),
                    $post->getTitle(),
                    $post->getContent(),
                    $now,
                    $now,
                    1
                )
            );
            $post = $this->getById($this->db->lastId());
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $post;
        }
    }

    public function update($post)
    {
        $res = false;
        try {
            if (!$post->getId()) {
                Exceptions::throwNew(
                    __CLASS__,
                    __FUNCTION__,
                    'No Post Id informed.'
                );
                return false;
            }
            $this->db->update(
                $this->table,
                array(
                    $post->getCategoryId(),
                    $post->getContent(),
                    'NOW()',
                    1
                ),
                array(
                    'categoryId',
                    'content',
                    'lastUpdated'
                ),
                "id = ".$post->getId()
            );
            $res = true;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $res;
        }
    }

    public function eraseChild($id)
    {
        try {
            $this->db->deleteRow($this->table, ['childId', '=', $id]);
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        }
    }

    public function setParentalRelation($parent, $child)
    {
        $res = false;
        try {
            $this->db->insertRow(
                'parentChild',
                array(
                    $parent,
                    $child
                )
            );
            $res = true;
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $res;
        }
    }

    public function getChildren($parent)
    {
        $list = [];
        try {
            $this->queryBuilder->from('parentChild');
            $this->queryBuilder->select(['id', 'title']);
            $this->queryBuilder->where(['parentId', '=', $parent]);
            $list = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($list); $i++) {
                $list[$i] = Mapper::populate(
                        new TitleModel(),
                        $list[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $list;
        }
    }
}

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
use Application\Model\ParentChildModel;

class PostFactory extends \SaSeed\Database\DAO {

    private $db;
    private $table = 'posts';

    public function __construct()
    {
        $this->db = parent::setDatabase('hostinger');
    }

    public function getById($postId = false)
    {
        $post = new PostModel();
        try {
            $queryBuilder = parent::setQueryBuilder();
            $queryBuilder->from($this->table);
            $queryBuilder->where([
                    'id',
                    '=',
                    $postId,
                    $queryBuilder->getMainTableAlias()
                ]);
            $post = Mapper::populate(
                    $post,
                    $this->db->getRow($queryBuilder->getQuery())
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
            $queryBuilder = parent::setQueryBuilder();
            $queryBuilder->from($this->table);
            $post = $this->db->getRows($queryBuilder->getQuery());
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
            $queryBuilder = parent::setQueryBuilder();
            $queryBuilder->from($this->table);
            $queryBuilder->where(['isActive', '=', 1]);
            $list = $this->db->getRows($queryBuilder->getQuery());
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
            $queryBuilder = parent::setQueryBuilder();
            $queryBuilder->from($this->table);
            $queryBuilder->select(['id', 'title']);
            $queryBuilder->where(['isActive', '=', 1]);
            $list = $this->db->getRows($queryBuilder->getQuery());
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

    public function getTitlesByTitle($titlePart)
    {
        $list = [];
        try {
            $queryBuilder = parent::setQueryBuilder();
            $queryBuilder->from($this->table);
            $queryBuilder->select(['id', 'title']);
            $queryBuilder->where(['title', 'LIKE', "%{$titlePart}%"]);
            $list = $this->db->getRows($queryBuilder->getQuery());
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
            $this->db->insertRow(
                $this->table,
                array(
                    $post->getCategoryId(),
                    $post->getTitle(),
                    $post->getContent(),
                    $post->getDate(),
                    $post->getLastUpdated(),
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
                    $post->getTitle(),
                    $post->getContent(),
                    $post->getLastUpdated(),
                    1
                ),
                array(
                    'categoryId',
                    'title',
                    'content',
                    'lastUpdated',
                    'isActive'
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
            $queryBuilder = parent::setQueryBuilder();
            $queryBuilder->from('parentChild');
            $queryBuilder->select(['id', 'parentId', 'childId']);
            $queryBuilder->where(['parentId', '=', $parent]);
            $list = $this->db->getRows($queryBuilder->getQuery());
            for ($i = 0; $i < count($list); $i++) {
                $list[$i] = Mapper::populate(
                        new ParentChildModel(),
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

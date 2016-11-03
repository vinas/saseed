<?php
/**
* Category Factory Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2015/10/26
* @version 1.16.2027
* @license SaSeed\license.txt
*/
namespace Application\Factory;

use SaSeed\Handlers\Mapper;
use SaSeed\Handlers\Exceptions;

use Application\Model\CategoryModel;
use Application\Model\CategoryResponseModel;

class CategoryFactory extends \SaSeed\Database\DAO {

    private $db;
    private $queryBuilder;
    private $table = 'categories';

    public function __construct()
    {
        $this->db = parent::setDatabase('hostinger');
        $this->queryBuilder = parent::setQueryBuilder();
    }

    public function listAll()
    {
        $categories = [];
        try {
            $this->queryBuilder->from($this->table);
            $categories = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($categories); $i++) {
                $categories[$i] = Mapper::populate(
                        new CategoryModel(),
                        $categories[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $categories;
        }
    }

    public function listAllActive()
    {
        $categories = [];
        try {
            $this->queryBuilder->from($this->table);
            $this->queryBuilder->select(['id', 'category']);
            $this->queryBuilder->where(['isActive', '=', 1]);
            $categories = $this->db->getRows($this->queryBuilder->getQuery());
            for ($i = 0; $i < count($categories); $i++) {
                $categories[$i] = Mapper::populate(
                        new CategoryResponseModel(),
                        $categories[$i]
                    );
            }
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        } finally {
            return $categories;
        }
    }
}

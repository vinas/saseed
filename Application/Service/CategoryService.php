<?php
/**
* Category Service Class
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/03
* @version 1.16.1103
* @license SaSeed\license.txt
*/

namespace Application\Service;

use SaSeed\Handlers\Exceptions;

use Application\Factory\CategoryFactory;

class CategoryService {

    private $factory;

    public function __construct()
    {
        $this->factory = new CategoryFactory();
    }

    public function getList()
    {
        try {
            return $this->factory->listAllActive();
        } catch (Exception $e) {
            Exceptions::throwing(__CLASS__, __FUNCTION__, $e);
        }
    }
}

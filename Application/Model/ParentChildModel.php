<?php
/**
* Parent Child Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/03
* @version 1.15.1104
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class ParentChildModel implements \JsonSerializable
{

    private $id;
    private $parentId;
    private $childId;

    public function setId($id = false) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setParentId($parentId = false) {
        $this->parentId = $parentId;
    }
    public function getParentId() {
        return $this->parentId;
    }

    public function setChildId($childId = false) {
        $this->childId = $childId;
    }
    public function getChildId() {
        return $this->childId;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}

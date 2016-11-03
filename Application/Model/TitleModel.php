<?php
/**
* Title Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/03
* @version 1.15.1103
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class TitleModel implements \JsonSerializable
{

    private $id;
    private $title;

    public function setId($id = false) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setTitle($title = false) {
        $this->title = $title;
    }
    public function getTitle() {
        return $this->title;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}

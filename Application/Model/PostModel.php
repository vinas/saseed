<?php
/**
* Category Model
*
* @author Vinas de Andrade <vinas.andrade@gmail.com>
* @since 2016/11/03
* @version 1.15.1103
* @license SaSeed\license.txt
*/ 

namespace Application\Model;

class PostModel implements \JsonSerializable
{

    private $id;
    private $categoryId;
    private $title;
    private $content;
    private $date;
    private $lastUpdated;
    private $isActive;

    public function setId($id = false) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setCategoryId($categoryId = false) {
        $this->categoryId = $categoryId;
    }
    public function getCategoryId() {
        return $this->categoryId;
    }

    public function setTitle($title = false) {
        $this->title = $title;
    }
    public function getTitle() {
        return $this->title;
    }

    public function setContent($content = false) {
        $this->content = $content;
    }
    public function getContent() {
        return $this->content;
    }

    public function setDate($date = false) {
        $this->date = $date;
    }
    public function getDate() {
        return $this->date;
    }

    public function setLastUpdated($lastUpdated = false) {
        $this->lastUpdated = $lastUpdated;
    }
    public function getLastUpdated() {
        return $this->lastUpdated;
    }

    public function setIsActive($isActive = false) {
        $this->isActive = $isActive;
    }
    public function getIsActive() {
        return $this->isActive;
    }

    public function listProperties() {
        return array_keys(get_object_vars($this));
    }

    public function JsonSerialize()
    {
        return get_object_vars($this);
    }
}

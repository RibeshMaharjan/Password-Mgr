<?php


require_once __DIR__.'/../core/model.php';
class User extends Model {
    public $name;

    function __construct() {
        parent::__construct();
    }

}
<?php

require_once __DIR__.'/../helpers/session_helper.php';
require_once __DIR__.'/../core/controller.php';
require_once __DIR__.'/../models/passwordgeneratormodel.php';

class GeneratorController extends Controller {
    
    private $generator;
    function __construct(){    
        // create an instance of the model
        $this->generator = new GeneratorModel();
        // $credential = $this->model("credential");
    }

    public function generatePassword($length, $lowercase, $uppercase, $number, $symbols){
        $password = $this->generator->generatePasswords($length, $lowercase, $uppercase, $number, $symbols);

        $this->view('passwordgenerator', $password);
        // return $password
    }
    
    public function showPassword(){
        $this->view('passwordgenerator', '');
    }
}
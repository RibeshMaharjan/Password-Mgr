<?php

require_once __DIR__.'/../core/controller.php';
require_once __DIR__.'/../models/credentialmodel.php';
class Credential extends Controller{

    private $user_id;
    private $site;
    private $username;
    private $password;

    // function __construct(){    
    //     // create an instance of the model
    //     $this->credential = new Credential;
    // }

    // function hello_get($name = ''){

	// 	$this->credential->sayHello('CJ_MODEL');
	// }
    // public function __construct($user_id = '', $site = '', $username = '', $password = '') {
    //     $this->user_id = $user_id;
    //     $this->site = $site;
    //     $this->username = $username;
    //     $this->password = $password;
    // }

    public function addCredentials() {
        // if($this->emptyInput() == false) {
        //     header("location: ../index.php?error=emptyinput");
        //     exit();
        // }
        // if($this->invalidUsername() == false) {
        //     header("location: ../index.php?error=Username");
        //     exit();
        // }
        // if($this->invalidEmail() == false) {
        //     header("location: ../index.php?error=Email");
        //     exit();
        // }

        $this->createCredential($this->user_id, $this->site, $this->username, $this->password);
    }

    // private function emptyInput() {
    //     $result;

    //     if(empty($this->user_id) || empty($this->site) || empty($this->username) || empty($this->password)){
    //         $result = false;
    //     }
    //     else {
    //         $result = true;
    //     }
    //     return $result;
    // }
    
    // private function invalidUsername() {
    //     $result;

    //     if(!preg_match("/^[a-zA-z0-9]*$/", $this->uname)){
    //         $result = false;
    //     }
    //     else{
    //         $result = true;
    //     }
    //     return $result;
    // }

    // private function invalidEmail() {
    //     $result;

    //     if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
    //         $result = false;
    //     }
    //     else{
    //         $result = true;
    //     }
    //     return $result;
    // }

    public function showCredentials() {

        $credential = $this->model('credentialmodel');
        $data = $credential->showCredential();

        $this->view('credentials/show', $data);
        // return $data;
    }

}
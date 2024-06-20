<?php

class CredentialController extends Credential{

    private $user_id;
    private $site;
    private $username;
    private $password;

    public function __construct($user_id = '', $site = '', $username = '', $password = '') {
        $this->user_id = $user_id;
        $this->site = $site;
        $this->username = $username;
        $this->password = $password;
    }

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

        $data = $this->showCredential();

        return $data;
    }

}
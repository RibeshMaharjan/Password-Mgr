<?php

require_once __DIR__.'/../helpers/session_helper.php';
require_once __DIR__.'/../core/controller.php';
require_once __DIR__.'/../models/credentialmodel.php';
class Credential extends Controller{

    private $user_id;
    private $site;
    private $username;
    private $password;
    private $credential;

    function __construct(){    
        // create an instance of the model
        $this->credential = new CredentialModel;
        // $credential = $this->model("credential");
    }

    public function addCredentials($user_id, $site, $username, $password) {
        if($this->emptyInput($user_id, $site, $username, $password) == false) {
            header("location: ../../public/index.php?error=emptyinput");
            exit();
        }
        if($this->invalidUsername($username) == false) {
            header("location: ../../public/index.php?error=Username");
            exit();
        }
        // if($this->invalidEmail() == false) {
        //     header("location: ../../public/index.php?error=Email");
        //     exit();
        // }
        $this->credential->createCredential($user_id, $site, $username, $password);
        header("location: ../../public/index.php");
        exit();
    }

    public function updateCredentials($id, $site, $username, $password) {
        if($this->emptyInput(NULL, $site, $username, $password) == false) {
            header("location: ../../public/index.php?error=emptyinput");
            exit();
        }

        $this->credential->updateCredential($id, $site, $username, $password);

    }
    public function deleteCredentials($id) {
        
        $credential = $this->model('credentialmodel');
        $credential->deleteCredential($id);
    }

    private function emptyInput($user_id, $site = '', $username = '', $password = '') {
        $result;
        $user_result = false;
        
        if (isset($user_id)) {
            if(empty($user_id)){
                $user_result = false;
            }
        }

        if($user_result || empty($site) || empty($username) || empty($password)){
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }
    
    private function invalidUsername($uname) {
        $result;

        if(!preg_match("/^[a-zA-z0-9]*$/", $uname)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function invalidEmail($email) {
        $result;

        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    public function showCredentials() {

        $data = $this->credential->showCredential();

        $this->view('credentials/show', $data);
        // return $data;
    }
}

$init = new Credential;

if (isset($_POST["add"])) 
{
    // Grabbing the data
    $user_id = $_SESSION["userid"];
    $site = $_POST["site"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Running error handlers and insert credential
    $init->addCredentials($user_id, $site, $username, $password);

    // Going back to front page
    header("location: ../../public/index.php?error=none");
}

if (isset($_POST["update"])) 
{
    // Grabbing the data
    $user_id = $_SESSION["userid"];
    $id = $_POST["id"];
    $site = $_POST["site"];
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Updateing the credential
    $init->updateCredentials($id, $site, $username, $password);

    // Going back to front page
    header("location: ../../public/index.php?error=none");
}

if (isset($_POST["delete"])) 
{
    // Grabbing the data
    $id = $_POST["id"];
    $user_id = $_SESSION["userid"];

    // Deleting credential
    $init->deleteCredentials($id);

    // Going back to front page
    header("location: ../../public/index.php?error=none");
}
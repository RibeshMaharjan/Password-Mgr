<?php

require_once __DIR__.'/../helpers/session_helper.php';
require_once __DIR__.'/../core/controller.php';
require_once __DIR__.'/../models/userprofilemodel.php';

class Userprofilecontroller extends Controller {

    private $Userprofile;

    function __construct(){    
        // create an instance of the model
        $this->Userprofile = new UserProfileModel;
    }

    public function profile($id) {
        $user = $this->Userprofile->getUserById($id);
        $data = [
            'user' => $user
        ];
        $this->view('userprofile', $data);
    }

    public function updateProfile($id, $username, $email, $passowrd, $key) {
        $this->Userprofile->updateUserById($id, $username, $email, $passowrd, $key);
    }
}
<!-- Task like change something in the database -->
<?php

require_once __DIR__.'/../helpers/session_helper.php';
require_once __DIR__.'/../core/controller.php';
require_once __DIR__.'/../models/login.php';

class LoginController extends Controller {
    
    private $uname;
    private $pwd;
    private $login;

    public function __construct($uname, $pwd) {
        $this->uname = $uname;
        $this->pwd = $pwd;
        // $this->login = new Login;
        $this->login = $this->model("login");
    }

    public function loginUser() {
        if($this->emptyInput() == false) {
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        $this->login->getUser($this->uname, $this->pwd);
    }

    private function emptyInput() {
        $result = true;

        if (empty($this->uname) || empty($this->pwd)) {
            $result = false;
        }

        return $result;
    }
}
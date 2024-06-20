<!-- Task like change something in the database -->
<?php


class LoginController extends Login {
    
    private $uname;
    private $pwd;

    public function __construct($uname, $pwd) {
        $this->uname = $uname;
        $this->pwd = $pwd;
    }

    public function loginUser() {
        if($this->emptyInput() == false) {
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        $this->getUser($this->uname, $this->pwd);
    }

    private function emptyInput() {
        $result;
        if (empty($this->uname) || empty($this->pwd)) {
            $result = false;
        }
        else {
            $result = true;
        }
        return $result;
    }
}
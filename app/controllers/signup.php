<!-- Task like change something in the database -->
<?php 

class SignupController extends Signup{

    private $uname;
    private $email;
    private $pwd;
    private $pwdRepeat;

    public function __construct($uname, $email, $pwd, $pwdRepeat)
    {
        $this->uname = $uname;
        $this->email = $email;
        $this->pwd = $pwd;
        $this->pwdRepeat = $pwdRepeat;
    }

    public function signupUser() {
        if($this->emptyInput() == false) {
            header("location: ../login.php?error=emptyinput");
            exit();
        }
        if($this->invalidUsername() == false) {
            header("location: ../login.php?error=Username");
            exit();
        }
        if($this->invalidEmail() == false) {
            header("location: ../login.php?error=Email");
            exit();
        }
        if($this->pwdMatch() == false) {
            header("location: ../login.php?error=PasswordMatch");
            exit();
        }
        if($this->usernameExists() == false) {
            header("location: ../login.php?error=usernameExists");
            exit();
        }

        $this->setUser($this->uname, $this->email, $this->pwd);
    }

    private function emptyInput() {
        $result = true;

        if(empty($this->uname) || empty($this->email) || empty($this->pwd) || empty($this->pwdRepeat)){
            $result = false;
        }

        return $result;
    }

    private function invalidUsername() {
        $result = true;

        if(!preg_match("/^[a-zA-z0-9]*$/", $this->uname)){
            $result = false;
        }

        return $result;
    }

    private function invalidEmail() {
        $result = true;

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $result = false;
        }

        return $result;
    }

    private function pwdMatch() {
        $result = true;

        if($this->pwd !== $this->pwdRepeat){
            $result = false;
        }

        return $result;
    }

    private function usernameExists() {
        $result = true;

        if(!$this->checkUser($this->uname, $this->email)){
            $result = false;
        }
        
        return $result;
    }
}
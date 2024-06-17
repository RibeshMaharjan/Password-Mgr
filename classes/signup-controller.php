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
        $result;

        if(empty($this->uname) || empty($this->email) || empty($this->pwd) || empty($this->pwdRepeat)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function invalidUsername() {
        $result;

        if(!preg_match("/^[a-zA-z0-9]*$/", $this->uname)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function invalidEmail() {
        $result;

        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function pwdMatch() {
        $result;

        if($this->pwd !== $this->pwdRepeat){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

    private function usernameExists() {
        $result;

        if(!$this->checkUser($this->uname, $this->email)){
            $result = false;
        }
        else{
            $result = true;
        }
        return $result;
    }

}
<!-- Task like change something in the database -->
<?php


class LoginController extends Controller {
    
    private $uname;
    private $pwd;

    public function
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

if (isset($_POST["login"])) 
{
    // Grabbing the data
    $uname = $_POST["uname"];
    $pwd = $_POST["pwd"];

    // Instantiate SignupContr class
    require_once __DIR__.'/../app/dbh.php';
    // include "../app/config/dbh.php"; 
    include "../app/models/login.php";
    include "../app/controllers/login.php";

    $login = new LoginController($uname, $pwd);

    // Running error handlers and user signup
    $login->loginUser();

    // Going back to front page
    header("location: ../public/index.php?error=none");
}
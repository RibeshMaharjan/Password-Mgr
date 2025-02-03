<?php

require_once __DIR__ . '/../helpers/session_helper.php';
require_once __DIR__ . '/../core/controller.php';
require_once __DIR__ . '/../models/credentialmodel.php';
class Credential extends Controller
{

    private $credential;

    function __construct()
    {
        // create an instance of the model
        $this->credential = new CredentialModel;
    }

    public function addSites($site_name, $site_url)
    {
        if (empty($site_name) || empty($site_url)) {
            header("location: ../../public/index.php?error=site_name_input");
            exit();
        }
        $message = $this->credential->addSite($site_name, $site_url);
        if (!($message["success"] == true)) {
            header("location: ../../public/index.php?error=SiteAdditionFailed");
            exit();
        }
        return $message["site_id"];
    }

    public function addCredentials($user_id, $site, $username, $password, $notes)
    {
        if ($this->emptyInput($user_id)) {
            header("location: ../../public/index.php?error=$site");
            exit();
        }
        if ($this->emptyInput($site)) {
            header("location: ../../public/index.php?error=$site");
            exit();
        }
        if ($this->emptyInput($username)) {
            header("location: ../../public/index.php?error=$site");
            exit();
        }
        if ($this->emptyInput($password)) {
            header("location: ../../public/index.php?error=$site");
            exit();
        }
        $this->credential->createCredential($user_id, $site, $username, $password, $notes);
        header("location: ../../public/index.php");
        exit();
    }

    public function updateCredentials($id, $username, $password, $notes)
    {
        if ($this->emptyInput($username) == true) {
            header("location: ../../public/index.php?error=emptyusername");
            exit();
        }
        if ($this->emptyInput($password) == true) {
            header("location: ../../public/index.php?error=emptypassword");
            exit();
        }

        $this->credential->updateCredential($id, $username, $password, $notes);
    }
    public function deleteCredentials($id)
    {
        $credential = $this->model('credentialmodel');
        $credential->deleteCredential($id);
    }

    private function emptyInput($input)
    {
        $result = false;

        if (empty($input)) {
            $result = true;
        }

        return $result;
    }

    private function invalidUsername($uname)
    {
        $result = false;

        if (preg_match("/^[a-zA-z0-9]*$/", $uname)) {
            $result = true;
        }
        return $result;
    }

    private function invalidEmail($email)
    {
        $result = false;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $result = false;
        } else {
            $result = true;
        }
        return $result;
    }

    public function showCredentials($site_id)
    {

        $data = $this->credential->showCredential($site_id);

        $this->view('singlecredential', $data);
    }
    public function showCredentialsUpdateHistorys($id)
    {

        $data = $this->credential->showCredentialsUpdateHistory($id);

        $this->view('update_credentials/show_updated_credentials', $data);
    }
}

$init = new Credential;

if (isset($_POST["add"])) {
    // Grabbing the data
    $user_id = $_SESSION["userid"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $notes = $_POST["notes"];

    if (!($site_id = $_POST["site_id"])) {
        $site_name = $_POST["site_name"];
        $site_url = $_POST["site_url"];

        $site_id = $init->addSites($site_name, $site_url);
    }

    // Running error handlers and insert credential
    $init->addCredentials($user_id, $site_id, $username, $password, $notes);

    // Going back to front page
    header("location: ../../public/single.php?error=none");
}

if (isset($_POST["update"])) {
    // Grabbing the data
    $user_id = $_SESSION["userid"];
    $id = $_POST["id"];
    $username = $_POST["username"];
    $password = $_POST["password"];
    $notes = $_POST["notes"];

    // Updateing the credential
    $init->updateCredentials($id, $username, $password, $notes);

    // Going back to front page
    header("location: ../../public/single.php?site_id=");
}

if (isset($_POST["delete"])) {
    // Grabbing the data
    $id = $_POST["id"];
    $user_id = $_SESSION["userid"];

    // Deleting credential
    $init->deleteCredentials($id);

    // Going back to front page
    header("location: ../../public/single.php?error=none");
}

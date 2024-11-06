<?php

    require_once __DIR__.'/../helpers/session_helper.php';
    require_once __DIR__.'/../core/model.php';

class Sitemodel extends Model {
    
    function __construct() {
        parent::__construct();
    }

    public function getSite(){
        $stmt = $this->connect()->prepare("SELECT * FROM sites");
        $stmt->execute();

        $siteResult = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // $stmt = null;
        $stmt = $this->connect()->prepare("SELECT * FROM credentials WHERE users_id = :user_id");
        $stmt->bindParam(':user_id', $_SESSION['userid']);
        $stmt->execute();
        $credentials = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $sites = [];

        foreach($siteResult as $site){
                $count = 0;
            foreach($credentials as $credential){
                if($site['site_id'] == $credential['site_id']) {
                    $count++;
                }
            }
            if($count > 0){
                $site['count'] = $count;
                $sites[] = $site;
            }
        }
        
        return $sites;
    }
}
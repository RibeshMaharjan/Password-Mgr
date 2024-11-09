<?php
require_once __DIR__.'/../dbh.php';


    $conn;
    $dbh = new Dbh();
    if ($dbh) {
        $conn = $dbh->connect();
    } else {
        throw new Exception('Failed to instantiate Dbh class.');
    }
    


    function getSite($site_id){
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM sites WHERE site_id = :site_id;");
        $stmt->bindParam(':site_id', $site_id);
        $stmt->execute();

        $site = $stmt->fetch(PDO::FETCH_ASSOC);

        return $site;
    }
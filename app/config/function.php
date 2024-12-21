<?php
require_once __DIR__.'/../dbh.php';

    function getSite($site_id){
        global $dbh;

        $stmt = $dbh->prepare("SELECT * FROM sites WHERE site_id = :site_id;");
        $stmt->bindParam(':site_id', $site_id);
        $stmt->execute();

        $site = $stmt->fetch(PDO::FETCH_ASSOC);

        return $site;
    }
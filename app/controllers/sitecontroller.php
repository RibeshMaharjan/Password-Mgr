<?php

require_once __DIR__.'/../helpers/session_helper.php';
require_once __DIR__.'/../core/controller.php';
require_once __DIR__.'/../models/site.php';

class SiteController extends Controller {

    private $siteModel;
    function __construct(){
        $this->siteModel = new Sitemodel;
    }

    public function showSites(){
        $sites = $this->siteModel->getSite();
        $this->view('site', $sites);
    }
}
<?php
//file: view/main/index.php

require_once(__DIR__."/../../core/ViewManager.php");
$view = ViewManager::getInstance();

$main = $view->getVariable("main");
$currentuser = $view->getVariable("currentusername");
?>

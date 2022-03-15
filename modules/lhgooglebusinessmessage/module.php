<?php

$Module = array( "name" => "Google Business Message" );

$ViewList = array();

$ViewList['callback'] = array(
    'params' => array(),
    'uparams' => array()
);

$ViewList['activation'] = array (
    'params' => array(),
    'uparams' => array(),
    'functions' => array('use_admin'),
);

$ViewList['index'] = array (
    'params' => array(),
    'uparams' => array(),
    'functions' => array('use_admin'),
);

$ViewList['agents'] = array (
    'params' => array(),
    'uparams' => array(),
    'functions' => array('use_admin'),
);

$ViewList['newagent'] = array (
    'params' => array(),
    'uparams' => array(),
    'functions' => array('use_admin'),
);

$ViewList['editagent'] = array (
    'params' => array('id'),
    'uparams' => array(),
    'functions' => array('use_admin'),
);

$FunctionList['use_admin'] = array('explain' => 'Allow operator to configure Facebook Messenger');

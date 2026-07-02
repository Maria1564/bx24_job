<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/api/json-header.php");
Service::setStatus($_REQUEST['service_id'],$_REQUEST['status']);
echo json_encode(['code' => $_REQUEST,'statusText'=>Service::getStatusTextById($_REQUEST['status'])]);

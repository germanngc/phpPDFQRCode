<?php



include "Thybag\SharePointAPI.php";
include "Thybag\Auth\SharePointOnlineAuth.php";
include "Thybag\Auth\SoapClientAuth.php";
include "Thybag\Auth\StreamWrapperHttpAuth.php";
include "Thybag\Service\ListService.php";
include "Thybag\Service\QueryObjectService.php";
use Thybag\SharePointAPI;



$sp = new SharePointAPI($username, $password, $path_to_WSDL);


$data = $sp->read('Documents');
var_dump($data);


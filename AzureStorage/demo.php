<?php

require_once 'vendor\autoload.php';
use WindowsAzure\Common\ServicesBuilder;

//DefaultEndpointsProtocol=[http|https];AccountName=[yourAccount];AccountKey=[yourKey]
$connectionString = "DefaultEndpointsProtocol=http;AccountName=wishtree;AccountKey=gK/aVIfRUq3MB0PX9bDqWrMmsLOjk3szVWJMOjnOJm64HruQEW7CfPUef7TwbbxOm6OAxIpofYtpwGT6PKPPwg==";

$blobRestProxy = ServicesBuilder::getInstance()->createBlobService($connectionString);



try {
    // List blobs.
    $blob_list = $blobRestProxy->listBlobs("mycontainer");
    $blobs = $blob_list->getBlobs();

    foreach($blobs as $blob)
    {
        echo $blob->getName().": ".$blob->getUrl()."<br />";
    }
}
catch(ServiceException $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/library/azure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}

?>
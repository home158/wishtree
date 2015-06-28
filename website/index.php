<?php 
echo "1234567890";
require_once 'WindowsAzure/WindowsAzure.php';
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;
use WindowsAzure\Blob\Models\Block;
use WindowsAzure\Blob\Models\BlobBlockType;

echo "1234567890";
    /*
try {

    $connectionString = "UseDevelopmentStorage=true";
    $instance = ServicesBuilder::getInstance();
    $blobRestProxy = $instance -> createBlobService($connectionString);
    $containerName = "mycontainer";
    $blobName = "DSC01166.jpg";
    $content = fopen("d:\DSC01166.jpg", "rb");
    $index = 0;
    $continue = True;
    $counter = 1;
    $blockIds = array();
    while (!feof($content))
    {
        $blockId = str_pad($counter, 6, "0", STR_PAD_LEFT);
        $block = new Block();
        $block -> setBlockId(base64_encode($blockId));
        $block -> setType("Uncommitted");
        array_push($blockIds, $block);
        echo $blockId . " | " . base64_encode($blockId) . " | " . count($blockIds);
        echo " \n ";
        echo " -----------------------------------------";
        $data=fread($content, CHUNK_SIZE);
        echo "Read " . strlen($data) . " of data from file";
        echo " \n ";
        echo " -----------------------------------------";
        echo " \n ";
        echo " -----------------------------------------";
        echo "Uploading block #: " . $blockId + " into blob storage. Please wait.";
        echo " -----------------------------------------";
        echo " \n ";
        $blobRestProxy -> createBlobBlock($containerName, $blobName, base64_encode($blockId), $data);
        echo "Uploaded block: " . $blockId . " into blob storage. Please wait";
        echo " \n ";
        echo " -----------------------------------------";
        echo " \n ";
        $counter = $counter + 1;
    }
    fclose($content); 
    echo "Now committing block list. Please wait.";
    echo " -----------------------------------------";
    echo " \n ";
    echo "hello";
    $blobRestProxy -> commitBlobBlocks($containerName, $blobName, $blockIds);
    echo " -----------------------------------------";
    echo " \n ";
    echo "Blob created successfully.";
}
catch(Exception $e){
    // Handle exception based on error codes and messages.
    // Error codes and messages are here: 
    // http://msdn.microsoft.com/en-us/library/windowsazure/dd179439.aspx
    $code = $e->getCode();
    $error_message = $e->getMessage();
    echo $code.": ".$error_message."<br />";
}
*/
?>
<?php
/**
 * A Windows Azure helper library for Code Igniter
 *
 * @author Thomas Antony
 * @website http://www.thomasantony.net
 * 
 */
require_once (dirname(__FILE__) . '/vendor/autoload.php');
use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Blob\Models\CreateContainerOptions;
use WindowsAzure\Blob\Models\PublicAccessType;
class Azure {
    private $connectionString = "DefaultEndpointsProtocol=%s;AccountName=%s;AccountKey=%s";

    function __construct()
    {
        $this->CI =& get_instance();
        $this->connectionString =  sprintf($this->connectionString ,
            $this->CI->config->item('azure_storage_protocol'),
            $this->CI->config->item('azure_storage_account_name'),
            $this->CI->config->item('azure_storage_account_key')
        );


    }

    function createBlobService(){
        return ServicesBuilder::getInstance()->createBlobService($this->connectionString);
    }
    function createTableService(){
        return ServicesBuilder::getInstance()->createTableService($this->connectionString);
    }
    function createContainerOptions(){
        $createContainerOptions = new CreateContainerOptions(); 
        $createContainerOptions->setPublicAccess(PublicAccessType::BLOBS_ONLY); 
        return $createContainerOptions;
    }
    
}
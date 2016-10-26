<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Documents extends Service
{
	
	public function find($documentKey = '')
    {
        $data = array();
        return $this->client->request("/documents/$documentKey", "GET", $data, 200);
    }
    
    public function listsignatures($documentKey)
    {
    	$data = array();
    	return $this->client->request("/documents/$documentKey/list", "GET", $data, 200);
    }
    
    public function status($status)
    {
    	$data = array();
    	return $this->client->request("/documents/$status/status", "GET", $data, 200);
    }
    
    public function safe($safeKey)
    {
    	$data = array();
    	return $this->client->request("/documents/$safeKey/safe", "GET", $data, 200);
    }

    public function upload($uuid_safe, $filePath)
    {
    	
    	if (!$uuid_safe){
    		return 'UUID Safe not set.';
    	}
    	
		return $this->_upload($uuid_safe, $filePath);
    	
    }

    public function cancel($documentKey)
    {
    	$data = array();
    	return $this->client->request("/documents/$documentKey/cancel", "POST", $data, 200);
    }

    public function createList($documentKey, $signers, $skipEmail = false)
    {
        $data = array("signers" => json_encode($signers));
        return $this->client->request("/documents/$documentKey/createlist", "POST", $data, 200);
    }
    
    public function webhookadd($documentKey, $url)
    {
    	$data = array("url" => json_encode($url));
    	return $this->client->request("/documents/$documentKey/webhooks", "POST", $data, 200);
    }
    
    public function webhooklist($documentKey)
    {
    	return $this->client->request("/documents/$documentKey/webhooks", "GET", null, 200);
    }
    
    public function sendToSigner($documentKey, $message = '', $workflow = '0', $skip_email = false)
    {
    	$data = array("message" => json_encode($message), "workflow" => json_encode($workflow), "skip_email" => json_encode($skip_email));
    
    	return $this->client->request("/documents/$documentKey/sendtosigner", "POST", $data, 200);
    }

    public function resend($documentKey, $email)
    {
        $data = array("email" => json_encode($email));
        return $this->client->request("/documents/$documentKey/resend", "POST", $data, 200);
    }
    
    public function getfileurl($documentKey, $type)
    {
    	$data = array("type" => json_encode($type));
    	return $this->client->request("/documents/$documentKey/download", "POST", $data, 200);
    }
    

    private function _upload($uuid_safe, $filePath)
    {
        $f = $this->_getCurlFile($filePath);
        
        $data = array("file" => $f);
        
        return $this->client->request("/documents/$uuid_safe/upload", "POST", $data, 200);

    }

    private function _getCurlFile($filename, $contentType='', $postname='')
    {
        // PHP 5.5 introduced a CurlFile object that deprecates the old @filename syntax
        // See: https://wiki.php.net/rfc/curl-file-upload
        if (function_exists('curl_file_create'))
        {
        	$finfo = finfo_open(FILEINFO_MIME_TYPE);
        	$finfo = finfo_file($finfo, $filename);
        	
           return curl_file_create($filename, $finfo, basename($filename));
        }

        // Use the old style if using an older version of PHP
        $postname = $postname or $filename;
        $value = "@{$filename};filename=" . $postname;
        if ($contentType){
            $value .= ';type=' . $contentType;
        }else{
	    $value .= ';type=' . mime_content_type($filename);
	}

        return $value;
    }
}

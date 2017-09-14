<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Documents extends Service
{
	
	public function changeemail($documentKey, $email_before, $email_after,$key='')
    {
        $data = array("email-before" => json_encode($email_before),"email-after" => json_encode($email_after),"key-signer" => json_encode($key));
        return $this->client->request("/documents/$documentKey/changeemail", "POST", $data, 200);
    }
	
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
    
    public function safe($safeKey, $uuid_folder = '')
    {
    	$data = array();
    	return $this->client->request("/documents/$safeKey/safe/$uuid_folder", "GET", $data, 200);
    }

    public function upload($uuid_safe, $filePath, $uuid_folder = '')
    {
    	
    	if (!$uuid_safe){
    		return 'UUID Safe not set.';
    	}
    	
		return $this->_upload($uuid_safe, $filePath, $uuid_folder);
    	
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
    
    public function makedocumentbytemplate($documentKey, $name_document, $templates, $uuid_folder = '')
    {
    	$data = array("templates" => json_encode($templates), "name_document"=>json_encode($name_document), "uuid_folder"=>json_encode($uuid_folder));
    	return $this->client->request("/documents/$documentKey/makedocumentbytemplate", "POST", $data, 200);
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
    
    public function addinfo($documentKey, $email = '', $display_name = '', $documentation = '', $birthday = '', $key='')
    {
    	$data = array("key_signer" => json_encode($key),"email" => json_encode($email), "display_name" => json_encode($display_name), "documentation" => json_encode($documentation), "birthday" => json_encode($birthday));
    
    	return $this->client->request("/documents/$documentKey/addinfo", "POST", $data, 200);
    }

    public function resend($documentKey, $email, $key='')
    {
        $data = array("email" => json_encode($email),"key_signer" => json_encode($key));
        return $this->client->request("/documents/$documentKey/resend", "POST", $data, 200);
    }
    
    public function getfileurl($documentKey, $type)
    {
    	$data = array("type" => json_encode($type));
    	return $this->client->request("/documents/$documentKey/download", "POST", $data, 200);
    }
    

    private function _upload($uuid_safe, $filePath, $uuid_folder = '')
    {
        $f = $this->_getCurlFile($filePath);
        
        $data = array("file" => $f, "uuid_folder"=> json_encode($uuid_folder));
        
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
    	if ($contentType)
        {
            $value .= ';type=' . $contentType;
        }else{
	    	$value .= ';type=' . mime_content_type($filename);
		}

        return $value;
    }
}

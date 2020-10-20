<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Certificate extends Service
{
	public function find($uuid_arquivo, $key_signer)
    {
        $data = array('key_signer'=>$key_signer);
        return $this->client->request("/certificate/$uuid_arquivo/list", "POST", $data, 200);
    }
    public function add($uuid_arquivo, $key_signer, $document_type, $document_number = '', $pades='')
    {
    	$data = array("key_signer" => $key_signer,
    	    "document_type" => $document_type,
	    "pades" => $pades,
    	    "document_number" => $document_number
    	);
    	return $this->client->request("/certificate/$uuid_arquivo/add", "POST", $data, 200);
    }
}

<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Folders extends Service
{
	
	public function find($uuidSafe)
    {
        $data = array();
        return $this->client->request("/folders/$uuidSafe/find", "GET", $data, 200);
    }

    public function create($uuidSafe, $folder_name)
    {
    	$data = array("folder_name" => json_encode($folder_name));
    	return $this->client->request("/folders/$uuidSafe/create", "POST", $data, 200);
    }
    
    public function rename($uuidSafe, $uuidFolder, $folder_name)
    {
    	$data = array("folder_name" => json_encode($folder_name), "uuid_folder" => json_encode($uuidFolder));
    	return $this->client->request("/folders/$uuidSafe/rename", "POST", $data, 200);
    }

}

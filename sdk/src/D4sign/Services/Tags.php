<?php

namespace D4sign\Services;

use D4sign\Client;
use D4sign\Service;

class Tags extends Service
{
	public function find($uuid_arquivo)
    {
        $data = array();
        return $this->client->request("/tags/$uuid_arquivo", "GET", $data, 200);
    }
    public function add($uuid_arquivo, $tag)
    {
    	$data = array("tag" => json_encode($tag));
    	return $this->client->request("/tags/$uuid_arquivo/add", "POST", $data, 200);
    }
    public function remove($uuid_arquivo, $tag)
    {
        $data = array("tag" => json_encode($tag));
        return $this->client->request("/tags/$uuid_arquivo/remove", "POST", $data, 200);
    }
    public function erase($uuid_arquivo, $tag)
    {
        $data = array("tag" => json_encode($tag));
        return $this->client->request("/tags/$uuid_arquivo/erase", "POST", $data, 200);
    }

}

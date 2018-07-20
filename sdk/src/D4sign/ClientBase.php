<?php

namespace D4sign;

abstract class ClientBase
{
    protected $url = "https://secure.d4sign.com.br/api/";
    protected $accessToken = null;
    protected $cryptKey = null;
    protected $timeout = 240;
    protected $version = "v1";

    public function setUrl($url)
    {
        $this->url = $url;
    }
    
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }
    
    public function getAccessToken()
    {
    	return $this->accessToken;
    }
    
    public function setCryptKey($cryptKey)
    {
    	$this->cryptKey = $cryptKey;
    }
    
    public function getCryptKey()
    {
    	return $this->cryptKey;
    }

    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
    }

    public function setVersion($version)
    {
        $this->version = $version;
    }

    protected function doRequest($url, $method, $data, $contentType = null)
    {
        $c = curl_init();

        $header = array("Accept: application/json");
        
        array_push($header, "tokenAPI: $this->accessToken");
        
    	$url = $this->url . $this->version . $url . "?tokenAPI=" . $this->accessToken."&cryptKey=".$this->cryptKey;
	
        switch($method)
        {
            case "GET":
                curl_setopt($c, CURLOPT_HTTPGET, true);
                if(count($data))
                {
                    $url .= "&" . http_build_query($data);
                }
                break;

            case "POST":
                curl_setopt($c, CURLOPT_POST, true);
                if(count($data))
                {
                    curl_setopt($c, CURLOPT_POSTFIELDS, $data);
                }
                break;

            case "DELETE":
                curl_setopt($c, CURLOPT_CUSTOMREQUEST, $method);
                if ($data)
                {
                    curl_setopt($c, CURLOPT_POST, true);
                    curl_setopt($c, CURLOPT_POSTFIELDS, $data);
                }
                break;
        }
        
        
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_TIMEOUT, $this->timeout);
        
        curl_setopt($c, CURLOPT_HTTPHEADER, $header);
        curl_setopt($c, CURLOPT_HEADER, true);
        
        curl_setopt($c, CURLOPT_URL, $url);
        curl_setopt($c, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($c, CURLOPT_SSL_VERIFYPEER, false);
        
        $response = curl_exec($c);
        
        curl_close($c);

        return $response;
    	
    }

    public function request($url, $method, $data, $expectedHttpCode, $contentType = '')
    {
    	
        $response = $this->doRequest($url, $method, $data, $contentType);
        
        return $this->parseResponse($url, $response, $expectedHttpCode);
    }

    public function parseResponse($url, $response, $expectedHttpCode)
    {
        $header = false;
        $content = array();
        $status = 200;
		
        foreach(explode("\r\n", $response) as $line)
        {
            if (strpos($line, "HTTP/1.1") === 0)
            {
                $lineParts = explode(" ", $line);
                $status = intval($lineParts[1]);
                $header = true;
            }
            else if ($line == "")
            {
                $header = false;
            }
            else if ($header)
            {
                $line = explode(": ", $line);
                if($line[0] == "Status")
                {
                    $status = intval(substr($line[1], 0, 3));
                }
            }
            else
            {
                $content[] = $line;
            }
        }

        if($status !== $expectedHttpCode)
        {
            //throw new D4signException("Expected status [$expectedHttpCode], actual status [$status], URL [$url]", D4signException::INVALID_HTTP_CODE);
        	throw new D4signException($content[0], D4signException::INVALID_HTTP_CODE);
        }

        $object = json_decode(implode("\n", $content));

        return $object;
    }
}

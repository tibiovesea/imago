<?php

class UrlMap {
    private $apiString;
    private $urlMap;
    private $config;

    function __construct($apiString, $config) {
        if(!$apiString) {
            throw new IllegalArgumentException('api string must be set');
        }
        if(gettype($apiString) !== 'string') {
            throw new IllegalArgumentException('api string must be of type string');
        }

        $this->apiString = $apiString;
        $this->config = $config;
    }

    function getMap() {
        if(!$this->urlMap) {
            $this->urlMap = $this->parseApi();
        }

        return $this->urlMap;
    }

    private function parseApi() {
        $getParts = array();

        ////////////////////////////////////////
        //pictures
        ////////////////////////////////////////
        preg_match_all('/^(picture)$/', $this->apiString, $getParts);
        if(isset($getParts[0][0])) {
            $urlMap = array(
                'api' => $getParts[1][0],
                'action' => 'list',
                
                'page' => 0,
                'pageSize' => $this->config['pageSize']
            );

            return $urlMap;
        }

        preg_match_all('/^(picture)\/p([0-9]+)$/', $this->apiString, $getParts);
        if(isset($getParts[0][0])) {
            $urlMap = array(
                'api' => $getParts[1][0],
                'action' => 'list',
                
                'page' => $getParts[2][0],
                'pageSize' => $this->config['pageSize']
            );

            return $urlMap;
        }

        ///////////////////////////////////////
        //tags
        ///////////////////////////////////////
        preg_match_all('/^(picture)\/(tag)$/', $this->apiString, $getParts);
        if(isset($getParts[0][0])) {
            $urlMap = array (
                'api' => $getParts[1][0],
                'action' => 'tag',

                'page' => 0
            );

            return $urlMap;
        }

        preg_match_all('/^(picture)\/(tag)\/([a-zA-Z0-9\-]+)$/', $this->apiString, $getParts);
        if(isset($getParts[0][0])) {
            $urlMap = array(
                'api' => $getParts[1][0],
                'action' => 'listByTag',

                'tag' => $getParts[3][0],
                'page' => 0,
                'pageSize' => $this->config['pageSize']
            );

            return $urlMap;
        }

        preg_match_all('/^(picture)\/(tag)\/([a-zA-Z0-9\-]+)\/p([0-9]+)$/', $this->apiString, $getParts);
        if(isset($getParts[0][0])) {
            $urlMap = array(
                'api' => $getParts[1][0],
                'action' => 'listByTag',

                'tag' => $getParts[3][0],
                'page' => $getParts[4][0],
                'pageSize' => $this->config['pageSize']
            );

            return $urlMap;
        }

        ///////////////////////////////////////
        //picture single
        ///////////////////////////////////////
        preg_match_all('/^(picture)\/([a-zA-Z0-9]{8})$/', $this->apiString, $getParts);
        if(isset($getParts[0][0])) {
            $urlMap = array(
                'api' => $getParts[1][0],
                'action' => 'show',

                'uniq' => $getParts[2][0],
            );

            return $urlMap;
        }
        
        preg_match_all('/^(picture)\/(tag)\/([a-zA-Z0-9\-]+)\/([a-zA-Z0-9]{8})$/', $this->apiString, $getParts);
        if(isset($getParts[0][0])) {
            $urlMap = array(
                'api' => $getParts[1][0],
                'action' => 'show',

                'tag' => $getParts[3][0],
                'uniq' => $getParts[4][0]
            );

            return $urlMap;
        }

        ///////////////////////////////////////
        //picture comments
        ///////////////////////////////////////
        preg_match_all('/^(picture)\/([a-zA-Z0-9]{8})\/(comment)$/', $this->apiString, $getParts);
        if(isset($getParts[0][0])) {
            $urlMap = array(
                'api' => $getParts[1][0],
                'action' => 'comment',
                
                'uniq' => $getParts[2][0],
                'comment' => $getParts[3][0],
            );

            return $urlMap;
        }

        throw new UnknownApiException($this->apiString);
    }
}

?>
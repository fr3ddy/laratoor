<?php

namespace Fr3ddy\Laratoor;

use Fr3ddy\Laratoor\ToornamentApi;

class AccountApi extends ToornamentApi{

    private $baseUrl = 'https://api.toornament.com/account/v2/';

    private $scope = 'user:info';

    public function __construct(){
        parent::__construct();
    }

    public function getAuthUrl($redirect_url = null){
        return $this->getAuthUrlWithScope($this->scope,$redirect_url);
    }

    protected function get($url,$headers = null){
        if(!$this->authorizationValid()){
            $this->reauthorize();
        }
        $url = $this->baseUrl.$url;
        $headers = [
            'Authorization' => 'Bearer '.session('toornament_access_token'),
        ];
        $response = parent::get($url,$headers);
        
        $return['status'] = $response->getStatusCode();
        $return['data'] = json_decode($response->getBody());
        
        return $return;
    }

    public function getUser(){
        $request = $this->get('me/info');
        return $this->dataToModel('User',$request);
    }
}
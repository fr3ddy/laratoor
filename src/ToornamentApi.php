<?php

namespace Fr3ddy\Laratoor;

use GuzzleHttp\Client;

class ToornamentApi{

    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_NOCONTENT = 204;
    const STATUS_PARTIALCONTENT = 206;

    protected $authUrl = "https://api.toornament.com/oauth/v2/token";

    protected $userAuthUrl = "https://account.toornament.com/oauth2/authorize";

    protected $client;

    public function __construct(){
        $this->client = new Client([
            'headers' => [
                'X-Api-Key' => env('TOORNAMENT_KEY')
            ],
            'verify' => false,
            'http_errors' => false,
        ]);
    }

    protected function getAuthUrlWithScope($scope,$redirect_url){
        $scopes = session('toornament_permission_scopes',collect());
        if(!$scopes->contains($scope)) $scopes->push($scope);
        session([
            'toornament_state' => str_random(30),
            'toornament_redirect_url' => $redirect_url,
            'toornament_permission_scopes' => $scopes,
        ]);
        return $this->userAuthUrl.'?response_type=code&client_id='.env('TOORNAMENT_CLIENT_ID')
                    .'&redirect_uri='.urlencode(url('/toornament/redirect'))
                    .'&scope='.urlencode($scope)
                    .'&state='.session('toornament_state');
    }

    public function authorize(){
        $response = $this->client->request('POST',$this->authUrl,[
            'body' => 'grant_type=authorization_code&client_id='.
                        env('TOORNAMENT_CLIENT_ID').'&client_secret='.
                        env('TOORNAMENT_CLIENT_SECRET').'&redirect_uri='.
                        urlencode(url('/toornament/redirect')).'&code='.session('toornament_code'),
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ]);
        if($response->getStatusCode() == 200){
            $body = json_decode($response->getBody());
            session([
                'toornament_access_token' => $body->access_token,
                'toornament_refresh_token' => $body->refresh_token,
                'toornament_access_token_end' => \Carbon\Carbon::now()->addSeconds($body->expires_in)
            ]);
            return true;
        }else{
            session()->forget('toornament_permission_scopes');
            return false;
        }
    }

    public function reauthorize(){
        if(session()->has('toornament_refresh_token')){
            $response = $this->client->request('POST',$this->authUrl,[
                'body' => 'grant_type=refresh_token&client_id='.
                            env('TOORNAMENT_CLIENT_ID').'&client_secret='.
                            env('TOORNAMENT_CLIENT_SECRET').'&refresh_token='.session('toornament_refresh_token'),
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded',
                ],
            ]);
            if($response->getStatusCode() == 200){
                $body = json_decode($response->getBody());
                session([
                    'toornament_access_token' => $body->access_token,
                    'toornament_refresh_token' => $body->refresh_token,
                    'toornament_access_token_end' => \Carbon\Carbon::now()->addSeconds($body->expires_in)
                ]);
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }

    public function authorizationValid($scope = null){
        if(\Carbon\Carbon::now()->diffInSeconds(session('toornament_access_token_end',\Carbon\Carbon::now())) > 0){
            if($scope && session('toornament_permission_scopes',collect())->contains($scope)){
                return true;
            }
        }
        return false;
    }

    protected function get($url,$headers){
        return $this->client->request('GET',$url,[
            'headers' => $headers
        ]);
    }

    protected function getAll($url,$unit,$size){
        $return = array();
        $return["data"] = collect();
        $return["from"] = 0;
        $from = 0;
        $to = $size - 1;
        do{
            $response = $this->get($url,$unit,$from,$to);
            if(!$this->isSuccessStatus($response['status'])){
                return $response;
            }
            
            $return['status'] = $response['status'];
            $return["to"] = $response["to"];
            $return["total"] = $response["total"];
            $return["data"] = $return["data"]->concat($response["data"]);
            
            $from = $to + 1;
            $to = $to + $size;
        }while($response["to"] < $response["total"] - 1);

        return $return;
    }

    /**
     * Returns the position from where this call contains data
     * 
     * @param Array $rangeHeader
     * @return null|int
     */
    protected function getRangeFrom($rangeHeader){
        if(isset($rangeHeader[0])){
            $exploded = explode(' ',$rangeHeader[0]);
            $exploded = explode('-',$exploded[1]);
            return $exploded[0];
        }
        
        return null;
    }

    /**
     * Returns the position to where this call contains data
     * 
     * @param Array $rangeHeader
     * @return null|int
     */
    protected function getRangeTo($rangeHeader){
        if(isset($rangeHeader[0])){
            $exploded = explode(' ',$rangeHeader[0]);
            $exploded = explode('-',$exploded[1]);
            $exploded = explode('/',$exploded[1]);
            return $exploded[0];
        }
        
        return null;
    }

    /**
     * Returns the total amount of available entries for this unit
     * 
     * @param Array $rangeHeader
     * @return null|int
     */
    protected function getRangeTotal($rangeHeader){
            if(isset($rangeHeader[0])){
            $exploded = explode(' ',$rangeHeader[0]);
            $exploded = explode('-',$exploded[1]);
            $exploded = explode('/',$exploded[1]);
            return $exploded[1];
        }
        
        return null;
    }

    /**
     * Returns if Status is Success Status
     * 
     * @param int $status
     * @return boolean
     */
    public function isSuccessStatus($status){
        switch ($status) {
            case self::STATUS_OK:
            case self::STATUS_CREATED:
            case self::STATUS_NOCONTENT:
            case self::STATUS_PARTIALCONTENT:
                return true;
                break;
            
            default:
                return false;
                break;
        }
    }

    protected function getQueryByFilter($filter){
        if($filter){
            $query = '?';
            $firstOuter = true;
            foreach($filter as $key => $values){
                if(!$firstOuter){
                    $query .= "&";
                }
                if(is_array($values)){
                    $query .= $key."=";
                    $firstInner = true;
                    foreach($values as $value){
                        if(!$firstInner){
                            $query .= ",";
                        }
                        $query .= $value;
                        $firstInner = false;
                    }
                }else{
                    $query .= $key."=".$values;
                }
                $firstOuter = false;
            }
            return $query;
        }else{
            return '';
        }
    }

    /**
     * @param string $classname Name of the Class to create
     * @param array $data Data Array
     * @param int|null $parent
     * @return any Class of Type specified
     */
    public function dataToModel($classname,$data,$parent = null){
        $classname = "\Fr3ddy\Laratoor\Model\\".$classname;
        if($this->isSuccessStatus($data["status"])){
            if($parent != null){
                return new $classname($parent, $data["data"]);
            }else{
                return new $classname($data["data"]);
            }
        }
        return false;
    }

    /**
     * @param string $classname Name of the Class to create
     * @param array $data Data Array
     * @param int|null $parent
     * @return array Collection of Classes of Type specified
     */
    public function dataToModels($classname,$data,$parent = null){
        $classname = "\Fr3ddy\Laratoor\Model\\".$classname;
        if($this->isSuccessStatus($data["status"])){
            $return = collect();
            foreach($data["data"] as $classdata){
                if($parent != null){
                    $return->push(new $classname($parent, $classdata));
                }else{
                    $return->push(new $classname($classdata));
                }
            }
            return $return;
        }
        return false;
    }
}
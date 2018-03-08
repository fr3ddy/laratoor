<?php

namespace Fr3ddy\Laratoor;

use GuzzleHttp\Client;

class ToornamentApi{

    const STATUS_OK = 200;
    const STATUS_CREATED = 201;
    const STATUS_NOCONTENT = 204;
    const STATUS_PARTIALCONTENT = 206;

    protected $client;

    public function __construct(){
        $this->client = new Client([
            'headers' => [
                'X-Api-Key' => env('TOORNAMENT_SECRET')
            ],
            'verify' => false,
            'http_errors' => false,
        ]);
    }

    protected function get($url,$headers){
        return $this->client->request('GET',$url,[
            'headers' => $headers
        ]);
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
    protected function isSuccessStatus($status){
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
}
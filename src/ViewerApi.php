<?php

namespace Fr3ddy\Laratoor;

use Fr3ddy\Laratoor\ToornamentApi;

class ViewerApi extends ToornamentApi{

    private $baseUrl = 'https://api.toornament.com/viewer/v2/';

    protected function get($url,$unit = null,$from = null,$to = null){
        $url = $this->baseUrl.$url;
        $headers = array();
        if($unit != null){
            $headers["Range"] = $unit.'='.$from.'-'.$to;
        }
        $response = parent::get($url,$headers);

        $return['status'] = $response->getStatusCode();
        $return['from'] = $this->getRangeFrom($response->getHeader('Content-Range'));
        $return['to'] = $this->getRangeTo($response->getHeader('Content-Range'));
        $return['total'] = $this->getRangeTotal($response->getHeader('Content-Range'));
        $return['data'] = collect(json_decode($response->getBody()));
        
        return $return;
    }

    public function getAll($url,$unit,$size){
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

    public function getAllDisciplines(){
        return $this->getAll('disciplines','disciplines',50);
    }

    public function getDisciplines($from = 0,$to = 49){
        return $this->get('disciplines','disciplines',$from,$to);
    }

    public function getDiscipline($id){
        return $this->get('disciplines/'.$id);
    }

    public function getAllFeaturedTournaments($filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/featured'.$query,'tournaments',50);
    }

    public function getFeaturedTournaments($filter,$from,$to){
        return $this->getAll('tournaments/featured','tournaments',$from,$to);
    }

    public function getTournament($id){
        return $this->get('tournaments/'.$id);
    }

    public function getTournamentCustomFields($id,$filter){
        return $this->get('tournaments/'.$id.'/custom-fields');
    }
}
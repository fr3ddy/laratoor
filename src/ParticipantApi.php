<?php

namespace Fr3ddy\Laratoor;

use Fr3ddy\Laratoor\ToornamentApi;

class ParticipantApi extends ToornamentApi{

    private $baseUrl = 'https://api.toornament.com/participant/v2/';

    public $scope = 'participant:manage_registrations';

    public function __construct(){
        parent::__construct();
    }

    public function getAuthUrl($redirect_url = null){
        return $this->getAuthUrlWithScope($this->scope,$redirect_url);
    }

    protected function get($url,$unit = null,$from = null,$to = null){
        $url = $this->baseUrl.$url;
        $headers = [
            'Authorization' => 'Bearer '.session('toornament_access_token'),
        ];
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

    public function getTournament($tournament_id){
        $request = $this->get('tournaments/'.$tournament_id);
        return $this->dataToModel('Tournament',$request);
    }

    public function getTournamentCustomFields($tournament_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/custom-fields'.$query);
    }

    public function getAllRegistrations($filter = null){
        $query = $this->getQueryByFilter($filter);
        $request = $this->getAll('me/registrations'.$query,'registrations',50);
        return $this->dataToModels('Registration',$request);
    }

    public function getRegistrations($filter = null,$from = 0 ,$to = 49){
        $query = $this->getQueryByFilter($filter);
        $request = $this->get('me/registrations'.$query,'registrations',$from,$to);
        return $this->dataToModels('Registration',$request);
    }

    public function getRegistration($registration_id){
        $request = $this->get('me/registrations/'.$registration_id);
        return $this->dataToModel('Registration',$request);
    }
}
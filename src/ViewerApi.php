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

    public function getAllParticipantsOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/participants'.$query,'participants',50);
    }

    public function getParticipantsOfTournament($tournament_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/participants'.$query,'participants',$from,$to);
    }

    public function getParticipantOfTournament($tournament_id,$participant_id){
        return $this->get('tournaments/'.$tournament_id.'/participants/'.$participant_id);
    }

    public function getStagesOfTournament($tournament_id){
        return $this->get('tournaments/'.$tournament_id.'/stages');
    }

    public function getStageOfTournament($tournament_id,$stage_id){
        return $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id);
    }

    public function getGroupsOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/groups'.$query);
    }

    public function getGroupOfTournament($tournament_id,$group_id){
        return $this->get('tournaments/'.$tournament_id.'/groups/'.$group_id);
    }

    public function getRoundsOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/rounds'.$query);
    }

    public function getRoundOfTournament($tournament_id,$round_id){
        return $this->get('tournaments/'.$tournament_id.'/groups/'.$group_id);
    }

    public function getAllMatchesOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/matches'.$query,'matches',128);
    }

    public function getMatchesOfTournament($tournament_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/matches'.$query,'matches',$from,$to);
    }

    public function getMatchOfTournament($tournament_id,$match_id){
        return $this->get('tournaments/'.$tournament_id.'/matches'.$match_id);
    }

    public function getAllMatchesByDiscipline($discipline_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('disciplines/'.$discipline_id.'/matches'.$query,128);
    }

    public function getMatchesByDiscipline($discipline_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('disciplines/'.$discipline_id.'/matches'.$query,'matches',$from,$to);
    }

    public function getAllBracketsOfStageInTournament($tournament_id,$stage_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/bracket-nodes'.$query,'nodes',128);
    }

    public function getBracketsOfStageInTournament($tournament_id,$stage_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/bracket-nodes'.$query,'nodes',$from,$to);
    }

    public function getAllRankingsOfStageInTournament($tournament_id,$stage_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/ranking-items'.$query,'items',128);
    }

    public function getRankingsOfStageInTournament($tournament_id,$stage_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/ranking-items'.$query,'items',$from,$to);
    }

    public function getAllStreamsOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/streams'.$query,'streams',50);
    }

    public function getStreamsOfTournament($tournament_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/streams'.$query,'streams',$from,$to);
    }

    public function getAllVideosOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/videos'.$query,'videos',50);
    }

    public function getVideosOfTournament($tournament_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/videos'.$query,'videos',$from,$to);
    }

    public function getAllVideosOfMatchInTournament($tournament_id,$match_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/matches/'.$match_id.'/videos'.$query,'videos',50);
    }

    public function getVideosOfMatchInTournament($tournament_id,$match_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/matches/'.$match_id.'/videos'.$query,'videos',$from,$to);
    }
}
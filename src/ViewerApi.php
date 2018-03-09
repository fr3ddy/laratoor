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
     * @return array
     */
    public function getAllDisciplines(){
        return $this->getAll('disciplines','disciplines',50);
    }

    /**
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getDisciplines($from = 0,$to = 49){
        return $this->get('disciplines','disciplines',$from,$to);
    }

    /**
     * @param int $id Discipline ID
     * @return array
     */
    public function getDiscipline($id){
        return $this->get('disciplines/'.$id);
    }

    /**
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllFeaturedTournaments($filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/featured'.$query,'tournaments',50);
    }

    /**
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getFeaturedTournaments($filter,$from,$to){
        return $this->getAll('tournaments/featured','tournaments',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @return array
     */
    public function getTournament($tournament_id){
        return $this->get('tournaments/'.$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getTournamentCustomFields($tournament_id,$filter){
        return $this->get('tournaments/'.$tournament_id.'/custom-fields');
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllParticipantsOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/participants'.$query,'participants',50);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getParticipantsOfTournament($tournament_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/participants'.$query,'participants',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $participant_id Participant Id
     * @return array
     */
    public function getParticipantOfTournament($tournament_id,$participant_id){
        return $this->get('tournaments/'.$tournament_id.'/participants/'.$participant_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @return array
     */
    public function getStagesOfTournament($tournament_id){
        return $this->get('tournaments/'.$tournament_id.'/stages');
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @return array
     */
    public function getStageOfTournament($tournament_id,$stage_id){
        return $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getGroupsOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/groups'.$query);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $group_id Group Id
     * @return array
     */
    public function getGroupOfTournament($tournament_id,$group_id){
        return $this->get('tournaments/'.$tournament_id.'/groups/'.$group_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getRoundsOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/rounds'.$query);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $group_id Group Id
     * @return array
     */
    public function getRoundOfTournament($tournament_id,$round_id){
        return $this->get('tournaments/'.$tournament_id.'/groups/'.$group_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllMatchesOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/matches'.$query,'matches',128);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getMatchesOfTournament($tournament_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/matches'.$query,'matches',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $match_id Match Id
     * @return array
     */
    public function getMatchOfTournament($tournament_id,$match_id){
        return $this->get('tournaments/'.$tournament_id.'/matches'.$match_id);
    }

    /**
     * @param int $discipline_id Disciplione Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllMatchesByDiscipline($discipline_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('disciplines/'.$discipline_id.'/matches'.$query,128);
    }

    /**
     * @param int $discipline_id Discipline Id
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */    
    public function getMatchesByDiscipline($discipline_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('disciplines/'.$discipline_id.'/matches'.$query,'matches',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllBracketsOfStageInTournament($tournament_id,$stage_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/bracket-nodes'.$query,'nodes',128);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getBracketsOfStageInTournament($tournament_id,$stage_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/bracket-nodes'.$query,'nodes',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllRankingsOfStageInTournament($tournament_id,$stage_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/ranking-items'.$query,'items',128);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getRankingsOfStageInTournament($tournament_id,$stage_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/ranking-items'.$query,'items',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllStreamsOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/streams'.$query,'streams',50);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getStreamsOfTournament($tournament_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/streams'.$query,'streams',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllVideosOfTournament($tournament_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/videos'.$query,'videos',50);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getVideosOfTournament($tournament_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/videos'.$query,'videos',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $match_id Match Id
     * @param array $filter Filter as an array
     * @return array
     */
    public function getAllVideosOfMatchInTournament($tournament_id,$match_id,$filter){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/matches/'.$match_id.'/videos'.$query,'videos',50);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $match_id Match Id
     * @param array $filter Filter as an array
     * @param int $from Start for pagination
     * @param int $to End for pagination
     * @return array
     */
    public function getVideosOfMatchInTournament($tournament_id,$match_id,$filter,$from,$to){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/matches/'.$match_id.'/videos'.$query,'videos',$from,$to);
    }
}
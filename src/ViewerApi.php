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

    /**
     * @throws 
     * @return array $disciplines Array with Disciplines
     */
    public function getAllDisciplines(){
        $request = $this->getAll('disciplines','disciplines',50);
        return $this->dataToModels('Discipline',$request);
    }

    /**
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */
    public function getDisciplines($from = 0,$to = 49){
        $request = $this->get('disciplines','disciplines',$from,$to);
        return $this->dataToModels('Discipline',$request);
    }

    /**
     * @param int $id Discipline ID
     * @return Fr3ddy\Laratoor\Model\Discipline Discipline
     */
    public function getDiscipline($id){
        $request = $this->get('disciplines/'.$id);
        return $this->dataToModel('Discipline',$request);
    }

    /**
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getAllFeaturedTournaments($filter = null){
        $query = $this->getQueryByFilter($filter);
        $request = $this->getAll('tournaments/featured'.$query,'tournaments',50);
        return $this->dataToModels('Tournament',$request);
    }

    /**
     * @param array|null $filter Filter as an array
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */
    public function getFeaturedTournaments($filter = null,$from = 0,$to = 49){
        $query = $this->getQueryByFilter($filter);
        $request = $this->getAll('tournaments/featured'.$query,'tournaments',$from,$to);
        return $this->dataToModels('Tournament',$request);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @return array
     */
    public function getTournament($tournament_id){
        $request = $this->get('tournaments/'.$tournament_id);
        return $this->dataToModel('Tournament',$request);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getTournamentCustomFields($tournament_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/custom-fields'.$query);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getAllParticipantsOfTournament($tournament_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        $request = $this->getAll('tournaments/'.$tournament_id.'/participants'.$query,'participants',50);
        return $this->dataToModels('Participant',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */
    public function getParticipantsOfTournament($tournament_id,$filter = null,$from = 0,$to = 49){
        $query = $this->getQueryByFilter($filter);
        $request = $this->get('tournaments/'.$tournament_id.'/participants'.$query,'participants',$from,$to);
        return $this->dataToModels('Participant',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $participant_id Participant Id
     * @return array
     */
    public function getParticipantOfTournament($tournament_id,$participant_id){
        $request = $this->get('tournaments/'.$tournament_id.'/participants/'.$participant_id);
        return $this->dataToModel('Participant',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @return array
     */
    public function getStagesOfTournament($tournament_id){
        $request = $this->get('tournaments/'.$tournament_id.'/stages');
        return $this->dataToModels('Stage',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @return array
     */
    public function getStageOfTournament($tournament_id,$stage_id){
        $request = $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id);
        return $this->dataToModel('Stage',$request,$tournament_id);
    }

    /**
     * getAllGroupsOfTournament
     *
     * @param int $tournament_id
     * @param array|null $filter
     * @return void
     */
    public function getAllGroupsOfTournament($tournament_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        $request = $this->getAll('tournaments/'.$tournament_id.'/groups'.$query,"groups",50);
        return $this->dataToModels('Group',$request,$tournament_id);
    }

    /**
     * getGroupsOfTournament
     *
     * @param int $tournament_id
     * @param array|null $filter
     * @param int $from
     * @param int $to
     * @return array
     */
    public function getGroupsOfTournament($tournament_id,$filter = null,$from = 0 , $to = 49){
        $query = $this->getQueryByFilter($filter);
        $request = $this->get('tournaments/'.$tournament_id.'/groups'.$query,"groups",$from,$to);
        return $this->dataToModels('Group',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $group_id Group Id
     * @param int $from
     * @param int $to
     * @return array
     */
    public function getGroupOfTournament($tournament_id,$group_id){
        $request = $this->get('tournaments/'.$tournament_id.'/groups/'.$group_id);
        return $this->dataToModel('Group',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @param int $from
     * @param int $to
     * @return array
     */
    public function getAllRoundsOfTournament($tournament_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        $request = $this->get('tournaments/'.$tournament_id.'/rounds'.$query,'rounds',50);
        return $this->dataToModels('Round',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @param int $from
     * @param int $to
     * @return array
     */
    public function getRoundsOfTournament($tournament_id,$filter = null,$from = 0,$to = 49){
        $query = $this->getQueryByFilter($filter);
        $request = $this->get('tournaments/'.$tournament_id.'/rounds'.$query,'rounds',$from,$to);
        return $this->dataToModels('Round',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $group_id Group Id
     * @return array
     */
    public function getRoundOfTournament($tournament_id,$round_id){
        $request = $this->get('tournaments/'.$tournament_id.'/groups/'.$group_id);
        return $this->dataToModel('Round',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getAllMatchesOfTournament($tournament_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        $request = $this->getAll('tournaments/'.$tournament_id.'/matches'.$query,'matches',128);
        return $this->dataToModels('Match',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */
    public function getMatchesOfTournament($tournament_id,$filter = null,$from = 0,$to = 127){
        $query = $this->getQueryByFilter($filter);
        $request = $this->get('tournaments/'.$tournament_id.'/matches'.$query,'matches',$from,$to);
        return $this->dataToModels('Match',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $match_id Match Id
     * @return array
     */
    public function getMatchOfTournament($tournament_id,$match_id){
        $request = $this->get('tournaments/'.$tournament_id.'/matches'.$match_id);
        return $this->dataToModel('Match',$request,$tournament_id);
    }

    /**
     * @param int $discipline_id Disciplione Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getAllMatchesByDiscipline($discipline_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        $request = $this->getAll('disciplines/'.$discipline_id.'/matches'.$query,'matches',128);
        return $this->dataToModels('Match',$request,$tournament_id);
    }

    /**
     * @param int $discipline_id Discipline Id
     * @param array|null $filter Filter as an array
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */    
    public function getMatchesByDiscipline($discipline_id,$filter = null,$from = 0,$to = 128){
        $query = $this->getQueryByFilter($filter);
        $request = $this->get('disciplines/'.$discipline_id.'/matches'.$query,'matches',$from,$to);
        return $this->dataToModels('Match',$request,$tournament_id);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getAllBracketsOfStageInTournament($tournament_id,$stage_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/bracket-nodes'.$query,'nodes',128);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @param array|null $filter Filter as an array
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */
    public function getBracketsOfStageInTournament($tournament_id,$stage_id,$filter = null,$from = 0,$to = 128){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/bracket-nodes'.$query,'nodes',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getAllRankingsOfStageInTournament($tournament_id,$stage_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/ranking-items'.$query,'items',128);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $stage_id Stage Id
     * @param array|null $filter Filter as an array
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */
    public function getRankingsOfStageInTournament($tournament_id,$stage_id,$filter = null,$from = 0,$to = 49){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/stages/'.$stage_id.'/ranking-items'.$query,'items',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getAllStreamsOfTournament($tournament_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/streams'.$query,'streams',50);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */
    public function getStreamsOfTournament($tournament_id,$filter = null,$from = 0,$to = 49){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/streams'.$query,'streams',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getAllVideosOfTournament($tournament_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/videos'.$query,'videos',50);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param array|null $filter Filter as an array
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     * @return array
     */
    public function getVideosOfTournament($tournament_id,$filter = null,$from = 0,$to = 49){
        $query = $this->getQueryByFilter($filter);
        return $this->get('tournaments/'.$tournament_id.'/videos'.$query,'videos',$from,$to);
    }

    /**
     * @param int $tournament_id Tournament Id
     * @param int $match_id Match Id
     * @param array|null $filter Filter as an array
     * @return array
     */
    public function getVideosOfMatchInTournament($tournament_id,$match_id,$filter = null){
        $query = $this->getQueryByFilter($filter);
        return $this->getAll('tournaments/'.$tournament_id.'/matches/'.$match_id.'/videos'.$query);
    }
}
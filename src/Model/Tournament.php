<?php

namespace Fr3ddy\Laratoor\Model;

use Fr3ddy\Laratoor\ViewerApi;

class Tournament extends \Fr3ddy\Laratoor\Model{

    /**
     * $discipline
     *
     * @var string
     */
    public $discipline;

    /**
     * $name
     *
     * @var string
     */
    public $name;

    /**
     * $full_name
     *
     * @var string
     */
    public $full_name;

    /**
     * $status
     *
     * @var string
     */
    public $status;

    /**
     * $scheduled_date_start
     *
     * @var \Carbon\Carbon
     */
    public $scheduled_date_start;

    /**
     * $scheduled_date_end
     *
     * @var \Carbon\Carbon
     */
    public $scheduled_date_end;

    /**
     * $timezone
     *
     * @var string
     */
    public $timezone;
    
    /**
     * $public
     *
     * @var bool
     */
    public $public;

    /**
     * $size
     *
     * @var int
     */
    public $size;

    /**
     * $participant_type
     *
     * @var string
     */
    public $participant_type;

    /**
     * $online
     *
     * @var bool
     */
    public $online;

    /**
     * $location
     *
     * @var string
     */
    public $location;

    /**
     * $country
     *
     * @var string
     */
    public $country;

    /**
     * $organization
     *
     * @var string
     */
    public $organization;

    /**
     * $contact
     *
     * @var string
     */
    public $contact;

    /**
     * $discord
     *
     * @var string
     */
    public $discord;

    /**
     * $website
     *
     * @var string
     */
    public $website;

    /**
     * $description
     *
     * @var string
     */
    public $description;

    /**
     * $rules
     *
     * @var string
     */
    public $rules;

    /**
     * $prize
     *
     * @var string
     */
    public $prize;

    /**
     * $platforms
     *
     * @var array
     */
    public $platforms;

    /**
     * $logo_small
     *
     * @var string
     */
    public $logo_small;
    
    /**
     * $logo_medium
     *
     * @var string
     */
    public $logo_medium;

    /**
     * $logo_large
     *
     * @var string
     */
    public $logo_large;

    /**
     * $logo_original
     *
     * @var string
     */
    public $logo_original;

    /**
     * $registration_enabled
     *
     * @var bool
     */
    public $registration_enabled;

    /**
     * $registration_opening_datetime
     *
     * @var \Carbon\Carbon
     */
    public $registration_opening_datetime;

    /**
     * $registration_closing_datetime
     *
     * @var \Carbon\Carbon
     */
    public $registration_closing_datetime;

    /**
     * __construct
     *
     * @param array $data
     * @return void
     */
    public function __construct($data){
        parent::__construct();
        foreach($data as $key => $value){
            if($value != null){
                switch ($key) {
                    case 'logo':
                        $this->logo_small = $value->logo_small;
                        $this->logo_medium = $value->logo_medium;
                        $this->logo_large = $value->logo_large;
                        $this->logo_original = $value->original;
                        break;
                    
                    case 'scheduled_date_start':
                    case 'scheduled_date_end':
                    case 'registration_opening_datetime':
                    case 'registration_closing_datetime':
                        $this->$key = \Carbon\Carbon::parse($value);
                        break;
    
                    default:
                        $this->$key = $value;
                        break;
                }
            }
        }
    }

    /**
     * getCustomFieldsTeam
     *
     * @return void
     */
    public function getCustomFieldsTeam(){
        $filter = [ "target_type" => "team" ];
        $request = $this->viewerApi->getTournamentCustomFields($this->id,$filter);
        if($this->viewerApi->isSuccessStatus($request["status"]) && isset($request["data"][0])){
            return $request["data"][0];
        }else{
            return null;
        }
    }

    /**
     * getCustomFieldsTeamPlayer
     *
     * @return void
     */
    public function getCustomFieldsTeamPlayer(){
        $filter = [ "target_type" => "team_player" ];
        $request = $this->viewerApi->getTournamentCustomFields($this->id,$filter);
        if($this->viewerApi->isSuccessStatus($request["status"]) && isset($request["data"][0])){
            return $request["data"][0];
        }else{
            return null;
        }
    }

    /**
     * getCustomFieldsPlayer
     *
     * @return void
     */
    public function getCustomFieldsPlayer(){
        $filter = [ "target_type" => "player" ];
        $request = $this->viewerApi->getTournamentCustomFields($this->id,$filter);
        if($this->viewerApi->isSuccessStatus($request["status"]) && isset($request["data"][0])){
            return $request["data"][0];
        }else{
            return null;
        }
    }

    /**
     * getAllParticipants
     *
     * @param mixed $filter
     * @return void
     */
    public function getAllParticipants($filter = null){
        return $this->viewerApi->getAllParticipantsOfTournament($this->id,$filter);
    }

    /**
     * getParticipants
     *
     * @param array $filter
     * @param int $from
     * @param int $to
     * @return void
     */
    public function getParticipants($filter = null,$from = 0,$to = 49){
        return $this->viewerApi->getParticipantsOfTournament($this->id,$filter,$from,$to);
    }

    /**
     * getParticipant
     *
     * @param int $participant_id
     * @return void
     */
    public function getParticipant($participant_id){
        return $this->viewerApi->getParticipantOfTournament($this->id,$participant_id);
    }

    /**
     * getStages
     *
     * @return void
     */
    public function getStages(){
        return $this->viewerApi->getStagesOfTournament($this->id);
    }

    /**
     * getStage
     *
     * @param mixed $stage_id
     * @return void
     */
    public function getStage($stage_id){
        return $this->viewerApi->getStageOfTournament($this->id,$stage_id);
    }

    /**
     * getAllGroups
     *
     * @param mixed $filter
     * @return void
     */
    public function getAllGroups($filter = null){
        return $this->viewerApi->getAllGroupsOfTournament($this->id,$filter);
    }

    /**
     * getGroups
     *
     * @param mixed $filter
     * @param mixed $from
     * @param mixed $to
     * @return void
     */
    public function getGroups($filter = null,$from = 0,$to = 49){
        return $this->viewerApi->getGroupsOfTournament($this->id,$filter,$from,$to);
    }

    /**
     * getGroup
     *
     * @param mixed $group_id
     * @return void
     */
    public function getGroup($group_id){
        return $this->viewerApi->getGroupOfTournament($this->id,$group_id);
    }

    /**
     * getAllRounds
     *
     * @param mixed $filter
     * @return void
     */
    public function getAllRounds($filter = null){
        return $this->viewerApi->getAllRoundsOfTournament($this->id,$filter);
    }

    /**
     * getRounds
     *
     * @param mixed $filter
     * @param mixed $from
     * @param mixed $to
     * @return void
     */
    public function getRounds($filter = null,$from = 0,$to = 49){
        return $this->viewerApi->getRoundsOfTournament($this->id,$filter,$from,$to);
    }

    /**
     * getRound
     *
     * @param mixed $round_id
     * @return void
     */
    public function getRound($round_id){
        return $this->viewerApi->getRoundOfTournament($this->id,$round_id);
    }

    /**
     * getAllMatches
     *
     * @param mixed $filter
     * @return void
     */
    public function getAllMatches($filter = null){
        return $this->viewerApi->getAllMatchesOfTournament($this->id,$filter);
    }

    /**
     * getMatches
     *
     * @param mixed $filter
     * @param mixed $from
     * @param mixed $to
     * @return void
     */
    public function getMatches($filter = null,$from = 0,$to = 127){
        return $this->viewerApi->getMatchesOfTournament($this->id,$filter,$from,$to);
    }

    /**
     * getMatch
     *
     * @param mixed $match_id
     * @return void
     */
    public function getMatch($match_id){
        return $this->viewerApi->getMatchOfTournament($this->id,$match_id);
    }

    /**
     * getAllStreams
     *
     * @param mixed $filter
     * @return void
     */
    public function getAllStreams($filter = null){
        return $this->viewerApi->getAllStreamsOfTournament($this->id,$filter);
    }

    /**
     * getStreams
     *
     * @param mixed $filter
     * @param mixed $form
     * @param mixed $to
     * @return void
     */
    public function getStreams($filter = null,$form = 0, $to = 49){
        return $this->viewerApi->getStreamsOfTournament($this->id,$filter,$from,$to);
    }

    /**
     * getAllVideos
     *
     * @param mixed $filter
     * @return void
     */
    public function getAllVideos($filter = null){
        return $this->viewerApi->getAllVideosOfTournament($this->id,$filter);
    }

    /**
     * getVideos
     *
     * @param mixed $filter
     * @param mixed $form
     * @param mixed $to
     * @return void
     */
    public function getVideos($filter = null,$form = 0, $to = 49){
        return $this->viewerApi->getVideosOfTournament($this->id,$filter,$from,$to);
    }

}
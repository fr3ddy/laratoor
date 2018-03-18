<?php

namespace Fr3ddy\Laratoor\Model;

use Fr3ddy\Laratoor\ViewerApi;

class Match extends \Fr3ddy\Laratoor\Model{

    /**
     * $stage_id
     *
     * @var string
     */
    public $stage_id;

    /**
     * $group_id
     *
     * @var string
     */
    public $group_id;

    /**
     * $round_id
     *
     * @var string
     */
    public $round_id;

    /**
     * $number
     *
     * @var int
     */
    public $number;

    /**
     * $type
     *
     * @var string
     */
    public $type;

    /**
     * $status
     *
     * @var string
     */
    public $status;

    /**
     * $scheduled_datetime
     *
     * @var \Carbon\Carbon
     */
    public $scheduled_datetime;

    /**
     * $played_at
     *
     * @var \Carbon\Carbon
     */
    public $played_at;

    /**
     * $opponents
     *
     * @var array
     */
    public $opponents;

    /**
     * $games
     *
     * @var array|null
     */
    public $games = null;
    
    /**
    * __construct
    *
    * @param array $data
    * @return void
    */
    public function __construct($tournament_id, $data){
        parent::__construct();
        $this->tournament_id = $tournament_id;
        foreach($data as $key => $value){
            if($value != null){
                switch ($key) {
                    case 'scheduled_datetime':
                    case 'played_at':
                        $this->key = \Carbon\Carbon::parse($value);
                        break;

                    default:
                        $this->$key = $value;
                        break;
                }
            }
       }
    }

    

    /**
    * getTournament
    *
    * @return Tournament
    */
    public function getTournament(){
        return $this->viewerApi->getTournament($this->tournament_id);
    }
 
    /**
    * getStage
    *
    * @return Stage
    */
    public function getStage(){
        return $this->viewerApi->getStageOfTournament($this->tournament_id,$this->stage_id);
    }
 
    /**
    * getGroup
    *
    * @return Group
    */
    public function getGroup(){
        return $this->viewerApi->getGroupOfTournament($this->tournament_id,$this->group_id);
    }
 
    /**
    * getGroup
    *
    * @return Group
    */
    public function getVideos($filter = null){
        return $this->viewerApi->getVideosOfMatchInTournament($this->tournament_id,$this->id,$filter);
    }

    /**
     * getGames
     *
     * @return Collection
     */
    public function getGames(){
        return $this->games;
    }

    /**
     * getGame
     *
     * @param int $number
     * @return array
     */
    public function getGame($number){
        foreach($this->games as $game){
            if($game->number == $number){
                return $game;
            }
        }
        return null;
    }
}
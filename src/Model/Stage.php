<?php

namespace Fr3ddy\Laratoor\Model;

use Fr3ddy\Laratoor\ViewerApi;

class Stage extends \Fr3ddy\Laratoor\Model{

    /**
     * $tournament_id
     *
     * @var int
     */
    public $tournament_id;

    /**
     * $number
     *
     * @var int
     */
    public $number;

    /**
     * $name
     *
     * @var string
     */
    public $name;

    /**
     * $type
     *
     * @var string
     */
    public $type;

    /**
     * $closed
     *
     * @var bool
     */
    public $closed;

    /**
     * $settings
     *
     * @var array
     */
    public $settings;
    
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
                $this->$key = $value;
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

    public function getAllBrackets($filter = null){
        return $this->viewerApi->getAllBracketsOfStageInTournament($this->tournament_id,$this->id,$filter);
    }

    public function getBrackets($filter = null,$from = 0,$to = 127){
        return $this->viewerApi->getBracketsOfStageInTournament($this->tournament_id,$this->id,$filter,$from,$to);
    }

    public function getAllRankings($filter = null){
        return $this->viewerApi->getAllRankingsOfStageInTournament($this->tournament_id,$this->id,$filter);
    }

    public function getRankings($filter = null,$from = 0,$to = 49){
        return $this->viewerApi->getRankingsOfStageInTournament($this->tournament_id,$this->id,$filter,$from,$to);
    }


}
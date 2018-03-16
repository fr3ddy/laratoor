<?php

namespace Fr3ddy\Laratoor\Model;

use Fr3ddy\Laratoor\ViewerApi;

class Group extends \Fr3ddy\Laratoor\Model{

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

   /**
    * getStage
    *
    * @return Stage
    */
    public function getStage(){
        return $this->viewerApi->getStageOfTournament($this->tournament_id,$this->stage_id);
    }
}
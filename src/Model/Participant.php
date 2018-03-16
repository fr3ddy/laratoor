<?php

namespace Fr3ddy\Laratoor\Model;

use Fr3ddy\Laratoor\ViewerApi;

class Participant extends \Fr3ddy\Laratoor\Model{

    /**
     * $tournament_id
     *
     * @var int
     */
    public $tournament_id;

    /**
     * $name
     *
     * @var string
     */
    public $name;

    /**
     * $custom_fields
     *
     * @var array
     */
    public $custom_fields;

    /**
     * $lineup
     *
     * @var array
     */
    public $lineup;

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
}
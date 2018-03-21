<?php

namespace Fr3ddy\Laratoor\Model;

use Fr3ddy\Laratoor\ViewerApi;

class Participant extends \Fr3ddy\Laratoor\Model{

    public $tournament_id;

    public $type;

    public $status;

    public $name;

    public $custom_fields;

    public $lineup;

    /**
     * __construct
     *
     * @param array $data
     * @return void
     */
    public function __construct($data = null){
        parent::__construct();
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }

}
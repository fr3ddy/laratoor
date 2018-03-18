<?php

namespace Fr3ddy\Laratoor\Model;

use Fr3ddy\Laratoor\ViewerApi;

class User extends \Fr3ddy\Laratoor\Model{

    /**
     * $name
     *
     * @var string
     */
    public $name;

    /**
     * $country
     *
     * @var string
     */
    public $country;

    public function __construct($data){
        parent::__construct();
        foreach($data as $key => $value){
            $this->$key = $value;
        }
    }

}
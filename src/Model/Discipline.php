<?php

namespace Fr3ddy\Laratoor\Model;

class Discipline extends \Fr3ddy\Laratoor\Model{

    /**
     * @var string $name Name of the dscipline
     */
    public $name;

    /**
     * @var string $shortname Short-Name of the discipline
     */
    public $shortname;

    /**
     * @var string $fullname Full-Name of the discipline
     */
    public $fullname;

    /**
     * @var string $copyrights Company that owns copyright on this discipline
     */
    public $copyrights;

    /**
     * @var array|null $platforms_available Available Platforms for this discipline
     */
    public $platforms_available;

    /**
     * @var int|null $min_team_size Minimum Team Size for this discipline
     */
    public $min_team_size;

    /**
     * @var int|null $max_team_size Maximum Team Size for this discpline
     */
    public $max_team_size;

    public function __construct($data){
        parent::__construct();
        foreach($data as $key => $value){
            if($key == "team_size"){
                $this->min_team_size = $value->min;
                $this->max_team_size = $value->max;
            }else{
                $this->$key = $value;
            }
        }
    }

    public function loadDetails(){
        $discipline = $this->viewerApi->getDiscipline($this->id);
        $this->platforms_available = $discipline->platforms_available;
        $this->min_team_size = $discipline->min_team_size;
        $this->max_team_size = $discipline->max_team_size;
    }
}
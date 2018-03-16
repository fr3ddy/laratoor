<?php

namespace Fr3ddy\Laratoor\Model;

use Fr3ddy\Laratoor\ViewerApi;

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

    /**
     * __construct
     *
     * @param array $data
     * @return void
     */
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

    /**
     * loadDetails
     *
     * @return void
     */
    public function loadDetails(){
        $discipline = $this->viewerApi->getDiscipline($this->id);
        $this->platforms_available = $discipline->platforms_available;
        $this->min_team_size = $discipline->min_team_size;
        $this->max_team_size = $discipline->max_team_size;
    }

    /**
     * @param string|null $filter Filter
     */
    public function getAllMatches($filter = null){
        $viewer = new ViewerApi();
        return $viewer->getAllMatchesByDiscipline($this->id,$filter);
    }

    /**
     * @param string|null $filter Filter
     * @param int|null $from Start for pagination
     * @param int|null $to End for pagination
     */
    public function getMatches($filter = null,$from = 0,$to = 49){
        $viewer = new ViewerApi();
        return $viewer->getMatchesByDiscipline($this->id,$filter,$from,$to);
    }
}
<?php

namespace Fr3ddy\Laratoor;

use Fr3ddy\Laratoor\ViewerApi;

class Model{

    /**
     * @var string $id Unique Identifier
     */
    public $id;

    /**
     * @var \Fr3ddy\Laratoor\ViewerApi $viewerApi Viewer Api singleton
     */
    protected $viewerApi;

    public function __construct(){
        $this->viewerApi = new ViewerApi();
    }

}
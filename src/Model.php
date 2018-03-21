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

    /**
     * @var \Fr3ddy\Laratoor\AccountApi $viewerApi Account Api singleton
     */
    protected $accountApi;

    /**
     * @var \Fr3ddy\Laratoor\ParticipantApi $participantApi Participant Api singleton
     */
    protected $participantApi;

    public function __construct(){
        $this->viewerApi = new ViewerApi();
        $this->accountApi = new AccountApi();
        $this->participantApi = new ParticipantApi();
    }

}
# Laratoor

This package will support you in any development related to the official [Toornament API](https://developer.toornament.com). After realeasing V2 of the API, many things changed. You can find a full documentation on the Toornament Page.

## Installation
Installation can be done easly with composer

```php
    composer require fr3ddy/laratoor
```

Add Fr3ddy\Laratoor\LaratoorServiceProvider::class to your providers array in your config/app.php

```php
    Fr3ddy\Laratoor\LaratoorServiceProvider::class
```

Add your API Token to your application from [Toornament](https://developer.toornament.com/applications/).

```php
    TOORNAMENT_SECRET=
```

## Usage
Since version two, Toornament does have four different layers in their API.

### Viewer API
The Viewer API helps in accessing data like disciplines, featured tournaments, match information and many more.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    $disciplines = $viewer->getAllDisciplines();
    $disciplines = $viewer->getDisciplines($from = 0,$to = 49);
    $discipline = $viewer->getDiscipline($id);
    $tournaments = $viewer->getAllFeaturedTournaments($filter = null);
    $tournaments = $viewer->getFeaturedTournaments($filter,$from,$to);
    $tournament = $viewer->getTournament($tournament_id);
    $tournament_fields = $viewer->getTournamentCustomFields($tournament_id,$filter);
    $participants = $viewer->getAllParticipantsOfTournament($tournament_id,$filter);
    $participants = $viewer->getParticipantsOfTournament($tournament_id,$filter,$from,$to);
    $participant = $viewer->getParticipantOfTournament($tournament_id,$participant_id);
    $stages = $viewer->getStagesOfTournament($tournament_id);
    $stage = $viewer->getStageOfTournament($tournament_id,$stage_id);
    $groups = $viewer->getGroupsOfTournament($tournament_id,$filter);
    $group = $viewer->getGroupOfTournament($tournament_id,$group_id);
    $rounds = $viewer->getRoundsOfTournament($tournament_id,$filter);
    $round = $viewer->getRoundOfTournament($tournament_id,$round_id);
    $matches = $viewer->getAllMatchesOfTournament($tournament_id,$filter);
    $matches = $viewer->getMatchesOfTournament($tournament_id,$filter,$from,$to);
    $matche = $viewer->getMatchOfTournament($tournament_id,$match_id);
    $matches = $viewer->getAllMatchesByDiscipline($discipline_id,$filter);
    $matches = $viewer->getMatchesByDiscipline($discipline_id,$filter,$from,$to);
    $brackets = $viewer->getAllBracketsOfStageInTournament($tournament_id,$stage_id,$filter);
    $brackets = $viewer->getBracketsOfStageInTournament($tournament_id,$stage_id,$filter,$from,$to);
    $rankings = $viewer->getAllRankingsOfStageInTournament($tournament_id,$stage_id,$filter);
    $rankings = $viewer->getRankingsOfStageInTournament($tournament_id,$stage_id,$filter,$from,$to);
    $streams = $viewer->getAllStreamsOfTournament($tournament_id,$filter);
    $streams = $viewer->getStreamsOfTournament($tournament_id,$filter,$from,$to);
    $videos = $viewer->getAllVideosOfTournament($tournament_id,$filter);
    $videos = $viewer->getVideosOfTournament($tournament_id,$filter,$from,$to);
    $videos = $viewer->getAllVideosOfMatchInTournament($tournament_id,$match_id,$filter);
    $videos = $viewer->getVideosOfMatchInTournament($tournament_id,$match_id,$filter,$from,$to);

```

### Account API
TBD

### Participant API
TBD

### Organizer API
Comming soon

### Responses
As a response, an array will be returned.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    $tournaments = $viewer->getFeaturedTournaments();
    
    echo $tournaments['status']; //200 Status Code
    echo $tournaments['from']; //0 Start of Pagination
    echo $tournaments['to']; //50 End of Pagination
    echo $tournaments['total']; //300 Total amount of available Items
    var_dump($tournaments['data']); //Collection of tournaments
```

#### Disclaimer
This packages is not related in any way to [Oxent](https://oxent.net) or any other company related to Toornament.

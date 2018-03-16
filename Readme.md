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

#### Filter
Some of the methods allow to specify a filter. This can be done by specifying an array with the respective content to filter on.

For example:
```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    
    $discipline = $viewer->getDiscipline($id);
    $filter = array(
        'is_featured' => 1, //returns matches of featured tournaments
        'statuses' => [ //pass an array of status you want to have in your list
            'pending',
            'running'
        ]
    );
    $matches = $discipline->getAllMatches($filter);
```
You can find the possibilities to filter on the Toornament API page with the respective API call as Query Parameters.

#### Discipline

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    
    //Collection of all disciplines
    $disciplines = $viewer->getAllDisciplines();
    //Collection of disciplines with pagination
    $disciplines = $viewer->getDisciplines($from,$to);
    //Discipline without platforms_available & team_size
    $first_discipline = $disciplines->first();
    //Discipline with platforms_available & team_size
    $first_discipline->loadDetails();
    //Discipline with platforms_available & team_size
    $discipline = $viewer->getDiscipline($id);
    //All Matches of this discipline
    $matches = $discipline->getAllMatches($filter);
    //Matches of this discipline with Pagination
    $matches = $discipline->getMatches($filter,$from,$to);

```

#### Tournaments



```php
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

#### Disclaimer
This packages is not related in any way to [Oxent](https://oxent.net) or any other company related to Toornament.

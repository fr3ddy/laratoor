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
Since version two, Toornament does have four different layers in their API. The Viewer API gives you publicly available informations. The Account API will give you access to the user data. The Participant API allows you to register to a tournament and the organizer API helps you managing tournaments.

**Status of implementation**
Viewer API: *Beta* Working version which may need some more optimization

Account API: *TBD* Not already implemented.

Participant API: *TBD* Not already implemented.

Organizer API: *TBD* Not already implemented by Toornament itself.


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
Disciplines are different games that are supported by Toornament. All major games are listed here with the publisher and some more information.
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
> A tournament is a competition involving a given set of competitors. These competitors play against each others following a predefined path. Some competitors are eliminated along the way and, at the end, a single competitor is declared winner.
In Toornament, competitors are defined as participants. The predefined path of matches is defined as the tournament’s structure and is composed of stages, groups, rounds, brackets, rankings and matches. A match can be further detailed with subsets of a match usually called games or match games.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#tournament)*

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    
    //Collection of all featured tournaments with filter
    $tournaments = $viewer->getAllFeaturedTournaments($filter);
    //Collection of featured tournaments with filter and pagination
    $tournaments = $viewer->getFeaturedTournaments($filter,$from,$to);
    //Tournament by Tournamnet ID
    $tournament = $viewer->getTournament($tournament_id);


    //Custom Fields of Teams for this tournament
    $custom_fields_team = $tournament->getCustomFieldsTeam();
    //Custom Fields of Team Players for this tournament
    $custom_fields_teamplayer = $tournament->getCustomFieldsTeamPlayer();
    //Custom Fields of Players for this tournament
    $custom_fields_player = $tournament->getCustomFieldsPlayer(); 
```

#### Participants
> The participant refers to the attendance of a competitor in a single tournament. A participant is tied to its tournament. In the case of one competitor taking part in several tournaments, he will be represented by one distinctive participant for each tournament.
The participant is referenced each time there is a need to clearly identify a competitor in the tournament. For example, to identify who is playing a match or to identify the rank of a competitor in a ranking.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#participant)*

The participants can either be selected directly from the tournament or by the tournament id.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();

    //By Tournament
    $tournament = $viewer->getTournament($tournament_id);
    //All Participants of this tournament with filter
    $participants = $tournament->getAllParticipants($filter);
    //Participants of this tournament with pagination
    $participants = $tournament->getParticipants($filter,$from,$to);
    //Participant of this tournament
    $participant = $tournament->getParticipant($participant_id);

    //By Tournamnet Id
    //All Participants of this tournament with filter
    $participants = $viewer->getAllParticipantsOfTournament($tournament_id,$filter);
    //Participants of this tournament with pagination
    $participants = $viewer->getParticipantsOfTournament($tournament_id,$filter,$from,$to);
    //Participant of this tournament
    $participant = $viewer->getParticipantOfTournament($tournament_id,$participant_id);
```

#### Stages
>A stage is a major step in a tournament. Its purpose is to arrange and organize the competition for some of the participants following a specific and standardized method. The method is defined by the type of stage.
There are currently six different types of stage supported on Toornament: single elimination, double elimination, round-robin groups, bracket groups, league and swiss system.
Each has its own method to arrange matches between participants. Depending on its type, a stage may involve sub-elements of the structure: groups, rounds, matches, brackets and rankings.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#stage)*

Stages can be selected directly from the tournament or by the tournament id.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    
    //By Tournament
    $tournament = $viewer->getTournament($tournament_id);
    //All Stages of this tournament
    $stages = $tournament->getStages();
    //Details of this Stage of this tournament
    $stage = $tournament->getStage($stage_id);

    //By Tournament ID
    //All Stages of this tournament
    $stages = $viewer->getStagesOfTournament($tournament_id);
    //Details of this Stage of this tournament
    $stage = $viewer->getStageOfTournament($tournament_id,$stage_id);
```

#### Groups
>A group represents a portion of a stage that usually involves only a subset of the participants. Most of the time groups can be played simultaneously because they involve different participants. However, in some cases, a group may have to wait the outcome of another group in order to receive additional participants and continue.
Some stage types do not require groups. In such case, a single group is still created as a placeholder to comply with the structure of the other stages.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#group)*

Groups can be selected directly from the tournament or with the specific tournament id.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    
    //By Tournament
    $tournament = $viewer->getTournament($tournament_id);
    //All Groups of this tournament with filter
    $groups = $tournament->getAllGroups($filter);
    //Groups of this tournament with filter and pagination
    $groups = $tournament->getGroups($filter,$from,$to);
    //Group details of this group of the specific tournament
    $group = $tournament->getGroup($group_id);

    //By Tournament ID
    //All Groups of this tournament with filter
    $groups = $viewer->getAllGroupsOfTournament($tournament_id,$filter);
    //Groups of this tournament with filter and pagination
    $groups = $viewer->getGroupsOfTournament($tournament_id,$filter,$from,$to);
    //Group details of this group of the specific tournament
    $group = $viewer->getGroupOfTournament($tournament_id,$group_id);
```

#### Rounds
> A round represents a small step inside a group in which all participants play no more than one match. The purpose of a round is to provide a step in which all participants can, if necessary, play simultaneously.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#round)*

Rounds can be selected directly from the tournament or with the specific tournament id.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    
    //By Tournament
    $tournament = $viewer->getTournament($tournament_id);
    //Get all Round for this tournament
    $rounds = $tournament->getAllRounds($filter);
    //Get Rounds with pagination for this tournament
    $rounds = $tournament->getRounds($filter,$from,$to);
    //Get Round details
    $round = $tournament->getRound($round_id);

    //By Tournament ID
    //Get all Round for this tournament
    $rounds = $viewer->getAllRoundsOfTournament($tournament_id,$filter);
    //Get Rounds with pagination for this tournament
    $rounds = $viewer->getRoundsOfTournament($tournament_id,$filter,$from,$to);
    //Get Round details
    $round = $viewer->getRoundOfTournament($tournament_id,$round_id);
```

#### Brackets
> A bracket represents a type of competition in which the outcome of a match (a win or a loss) determines where the participants go next. Matches in a bracket are therefore connected between them and are often represented as a tree.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#round)*

Brackets can be selected directly from the stage of a tournament or with the specific tournament and stage id.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();

    //By Stage
    $tournament = $viewer->getTournament($tournament_id);
    $stage = $tournament->getStage($stage_id);
    //Get all Brackets of this stage with filter
    $brackets = $stage->getAllBrackets($filter);
    //Get Brackets of this stage with filter and pagination
    $brackets = $stage->getAllBrackets($filter,$from,$to);
    
    //By Tournament and Stage id
    //Get all Brackets of this stage with filter
    $brackets = $viewer->getAllBracketsOfStageInTournament($tournament_id,$stage_id,$filter);
    //Get Brackets of this stage with filter and pagination
    $brackets = $viewer->getBracketsOfStageInTournament($tournament_id,$stage_id,$filter,$from,$to);
```

#### Rankings
> A ranking represents a type of competition in which the outcome of a match rewards the participants with points. These points are then used to calculate a ranking. Once the stage or the group is completed, the ranking is then used to determine the final standing of the participants in the stage.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#ranking)*

Rankings can be selected directly from the stage of a tournament or with the specific tournament and stage id.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();

    //By Stage
    $tournament = $viewer->getTournament($tournament_id);
    $stage = $tournament->getStage($stage_id);
    //Get all Brackets of this stage with filter
    $rankings = $stage->getAllRankings($filter);
    //Get Brackets of this stage with filter and pagination
    $rankings = $stage->getRankings($filter,$from,$to);
    
    //By Tournament and Stage id
    //Get all Brackets of this stage with filter
    $rankings = $viewer->getAllRankingsOfStageInTournament($tournament_id,$stage_id,$filter);
    //Get Brackets of this stage with filter and pagination
    $rankings = $viewer->getRankingsOfStageInTournament($tournament_id,$stage_id,$filter,$from,$to);
```

#### Matches
> A match is a small structured form of play involving one or more participants. These participants play against each others following a match format and possibly smaller steps of play (such as games or match games). At the end, an outcome is defined by the match format.
Depending on the number of participants involved in the match, the outcome is calculated differently. When a match only involves two participants, it is typed as duel and the result is described by a win, a draw or a loss. When a match involves more than two participants, it is typed as ffa and the result is described by a ranking.
A match contains match opponents. These opponents act like slots that expect to receive a participant at some point in the tournament. A match opponent contains a number and the match-related data of a participant such as his score, his result and other game information.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#ranking)*

Rankings can be selected directly from the stage of a tournament or with the specific tournament and stage id.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();

    //By Tournament
    $tournament = $viewer->getTournament($tournament_id);
    //All Matches with filter
    $matches = $tournament->getAllMatches($filter);
    //Matches with filter and pagination
    $matches = $tournament->getMatches($filter,$from,$to);
    //Match Details for one match of this tournament
    $match = $tournament->getMatch($match_id);

    //By Tournament ID
    //All Matches with filter
    $matches = $viewer->getAllMatchesOfTournament($tournament_id,$filter);
    //Matches with filter and pagination
    $matches = $viewer->getMatchesOfTournament($tournament_id,$filter,$from,$to);
    //Match Details for one match of this tournament
    $match = $viewer->getMatchOfTournament($tournament_id,$match_id);
```

##### Match Games
> A match game is a subset of a match that describes part of a match. It is usually where you find discipline-specific information such as maps or modes.
A match game contains match game opponents. They share the same opponent number as in the match so they do not need to contain a participant. They also contain match-game-related data such as score and result and discipline-specific information such as characters.

*Source: [Toornament](https://developer.toornament.com/v2/core-concepts/overview#match-game)*

Games of matches can only be received by the Match of a tournament.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();

    //By Tournament
    $tournament = $viewer->getTournament($tournament_id);
    $match = $tournament->getMatch($match_id);
    //Get all games
    $games = $match->getGames();
    //Get game number 1
    $game = $match->getGame(1);
```

#### Relations
Based on the structure Toornament has designed, each element can recieve it's parent also.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    $match = $viewer->getMatchOfTournament($tournament_id,$match_id);
    $tournament = $match->getTournament();
```

#### Additional Content
Toornament also provides details about the attached Streams and Videos which are attached to a tournament or a match. They can be selected with either the IDs of the element or directly from the element.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();

    //By IDs
    //Get all Streams of the tournament with filter
    $streams = $viewer->getAllStreamsOfTournament($tournament_id,$filter);
    //Get Streams with filter and pagination
    $streams = $viewer->getStreamsOfTournament($tournament_id,$filter,$from,$to);
    //Get all Videos of a tournament with filter
    $videos = $viewer->getAllVideosOfTournament($tournament_id,$filter);
    //Get Videos of tournament with filter and pagination
    $videos = $viewer->getVideosOfTournament($tournament_id,$filter,$from,$to);
    //Get all Videos of a match in the tournament with filter
    $videos = $viewer->getAllVideosOfMatchInTournament($tournament_id,$match_id,$filter);

    //By element
    $tournament = $viewer->getTournament($tournament_id);
    $match = $tournament->getMatch($match_id);
    //Get all Streams of the tournament with filter
    $streams = $tournament->getAllStreams($filter);
    //Get Streams with filter and pagination
    $streams = $tournament->getStreams($filter,$from,$to);
    //Get all Videos of a tournament with filter
    $videos = $tournament->getAllVideos($filter);
    //Get Videos of tournament with filter and pagination
    $videos = $tournament->getVideos($filter,$from,$to);
    //Get all Videos of a match in the tournament with filter
    $videos = $match->getAllVideos($filter);
```

### Account API
TBD

### Participant API
TBD

### Organizer API
Comming soon

#### Disclaimer
This packages is not related in any way to [Oxent](https://oxent.net) or any other company related to Toornament.

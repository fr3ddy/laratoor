# Laratoor

This package will support you in any development related to the official [Toornament API](https://developer.toornament.com). After realeasing V2 of the API, many things changed. You can find a full documentation on the Toornament Page.

## Installation
TBD

## Usage
Since version two, Toornament does have four different layers in their API.

### Response
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

### Viewer API
The Viewer API helps in accessing data like disciplines, featured tournaments, match information and many more.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    $tournaments = $viewer->getAllFeaturedTournaments();
```

#### Disclaimer
This packages is not related in any way to [Oxent](https://oxent.net) or any other company related to Toornament.

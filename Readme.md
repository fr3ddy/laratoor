# Laratoor

This package will support you in any development related to the official [Toornament API](https://developer.toornament.com). After realeasing V2 of the API, many things changed. You can find a full documentation on the Toornament Page.

## Installation
TBD

## Usage
Since version two, Toornament does have four different layers in their API.

### Viewer API
The Viewer API helps in accessing data like disciplines, featured tournaments, match information and many more.

```php
    use Fr3ddy\Laratoor\ViewerApi;

    $viewer = new ViewerApi();
    $tournaments = $viewer->getAllFeaturedTournaments();
```

#### Disclaimer
This packages is not related in any way to [Oxent](https://oxent.net) or any other company related to Toornament.

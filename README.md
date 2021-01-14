<a href="https://github.com/MunnaAhmed/ShoppingCart/issues"><img src="https://img.shields.io/github/issues/MunnaAhmed/IpLocation"><a/>
<a href="https://github.com/MunnaAhmed/ShoppingCart/network/members"><img src="https://img.shields.io/github/forks/MunnaAhmed/IpLocation"><a/>
<a href="https://github.com/MunnaAhmed/ShoppingCart/stargazers"><img src="https://img.shields.io/github/stars/MunnaAhmed/IpLocation"><a/>
<a href="https://packagist.org/packages/munna/shopping-cart"><img src="https://img.shields.io/github/license/MunnaAhmed/ShoppingCart"><a/>


# Ip Location Tracking
Tracking location info by ip address.

## Installing IpLocaiton

Next, run the Composer command to install the latest stable version:

```bash
composer require munna/iplocation
```

## Create A Class Instance

to create a class instance 
```php

// Use this as namespace
use Munna\IpLocation\IpLocation;

// Set Your Ip Address
$ip = "YOUR_IP_ADDRESS";

//this is optional. Find this api key by visiting https://ipinfodb.com/
$api_key = "API_KEY"; 

//If you have this api_key 
$location = new IpLocation($ip, $api_key);

// If you do not have this api_key pass only ip
$location = new IpLocation($ip);

// Finally init the class
$location->init();
```

After init class instance. You will be get the all of these data.

## Provided Data

```php
// Get Ip Address
$ip = $location->ip;

//full info as an array
$info = $location->info();

// get region name
$region = $location->region;

// get continent
$continent = $location->continent;

// get country name
$countryName = $location->countryName;

// get city name If you set api_key when create instance
$cityName = $location->cityName;

// get zip code If you set api_key when create instance
$zipCode = $location->zipCode;

// get timezone If you set api_key when create instance
$timeZone = $location->timeZone;

// get country code
$countryCode = $location->countryCode;

// get nationality
$nationality = $location->nationality;

// get currency name
$currency = $location->currency;

// get ioc name
$ioc = $location->ioc;

// get flag url
$flag = $location->flag;

// get latitude
$lat = $location->lat;

// get longitude
$long = $location->long;

// get map info by google map
$map = $location->map;

// get more geo info
$geo = $location->geo;

// get main language
$lanugage = $location->lanugage;

// More supported languages
$official_lanugages = $location->official_lanugages;
```

## JSON data sample For All Info

```json
{
    "ip": "99.48.53.132",
    "region": "Americas",
    "continent": "North America",
    "countryName": "United States of America",
    "cityName": "Stone Mountain",
    "zipCode": "30083",
    "timeZone": "-05:00",
    "countryCode": "US",
    "nationality": "American",
    "currency": "USD",
    "ioc": "USA",
    "flag": "https://raw.githubusercontent.com/MunnaAhmed/Flags/main/us.png",
    "lat": 37.09024,
    "long": -95.712891,
    "map": "https://www.google.com/maps/@37.09024,-95.712891,17z",
    "geo": {
        "latitude": 37.09024,
        "latitude_dec": "39.44325637817383",
        "longitude": -95.712891,
        "longitude_dec": "-98.95733642578125",
        "max_latitude": 71.5388001,
        "max_longitude": -66.885417,
        "min_latitude": 18.7763,
        "min_longitude": 170.5957,
        "bounds": {
            "northeast": {
                "lat": 71.5388001,
                "lng": -66.885417
            },
            "southwest": {
                "lat": 18.7763,
                "lng": 170.5957
            }
        }
    },
    "lanugage": "en",
    "official_lanugages": [
        "en"
    ]
}
```

## License
This package is open-sources and licensed under the [MIT license](https://opensource.org/licenses/MIT).

Thank you very much. Please give a star.
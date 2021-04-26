# ikoncept/ico8-portal

This package is used for accessing portal data from Icat Server.

## Installation
Install the package
```bash
composer require ikoncept/ico8-portal
```

Publish the configuration
```bash
php artisan vendor:publish --provider="Ikoncept\Ico8Portal\Ico8PortalServiceProvider"
```

Set the required environement variables
```
ICO8_PORTAL_HOST="http://ico8host.com/v1"
ICO8_PORTAL_API_KEY="API_KEY_HERE"
ICO8_PORTAL_ID="PORTAL_UUID"
ICO8_TENANT_ID='TENANT_UUID'
```

## Usage
Import the `Portal` client with typehinting
```php
/**
 * Display a listing of the resource.
 *
 * @param \Ikoncept\Ico8Portal\Portal $portal
 * @param \Illuminate\Http\Response $request
 * @return \Illuminate\Support\Collection
 *
 */
public function index(Portal $portal, Request $request) : Collection
{
    $response = $portal->fetchPortalMedia(['limit' => 20]);

    return $response;
}
```

### Available methods
**Fetch portal media**
```php
$portal->fetchPortalMedia()
```
_Fetch all related media to the specific portal_

Optional parameters can be passed as below
```php
$portal->fetchPortalMedia([
    'limit' => 15 // Paginate media, showing 15 items per page
])
```

**Fetch portal information**
```php
$portal->fetchPortal()
```
_Fetch portal info, for example the portal name_



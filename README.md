# ikoncept/ico8-api-wrapper

This package is used for accessing portal data from Icat Server.

## Installation
Install the package
```bash
composer require ikoncept/ico8-api-wrapper
```

Publish the configuration
```bash
php artisan vendor:publish --provider="Ikoncept\Ico8\Ico8ServiceProvider"
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
 * @param \Ikoncept\Ico8\Portal $portal
 * @param \Illuminate\Http\Response $request
 * @return \Illuminate\Support\Collection
 *
 */
public function index(Portal $portal, Request $request) : Collection
{
    $response = $portal->fetchPortalIco8(['limit' => 20]);

    return $response;
}
```

### Available methods
**Fetch portal media**
```php
$portal->fetchPortalIco8();
```
_Fetch all related media to the specific portal_

Optional parameters can be passed as below
```php
$portal->fetchPortalIco8([
    'limit' => 15 // Paginate media, showing 15 items per page
]);
```

**Fetch portal information**
```php
$portal->fetchPortal()
```
_Fetch portal info, for example the portal name_

**Search portal media**
```php
$portal->searchPortalIco8('searchQuery', ['limit' => 5]);
```

#### Parameters
To **filter** the result the parameter array can be used.

Available filters for portalized media are:
* `filter[album]` _filters media by album id_

Example:
```php
$response = $portal->fetchPortalIco8([
    'limit' => 5,
    'filter[album]' => 1,
])
```


To **sort** the parameter array is used.

Sortable fields are:
* `resolution`
* `published_at`
* `name`
* `filesize`
* `created_at`

Example:
```php
$response = $portal->fetchPortalIco8([
    'sort' => '-name'
]);
```

_**Note;** only published media will be fetched_

### Password protected portals
Portals can be password protected to restrict access. Only a password is required to authenticate. If the password provided is correct it is up to the portal app to choose strategy to persist the authenticated state

Example:
```php
$response = $portal->validatePassword('password');
```

If the password is incorrect a `401` response will be returned.





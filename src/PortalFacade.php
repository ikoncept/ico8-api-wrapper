<?php

namespace Ikoncept\Ico8Portal;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ikoncept\Ico8Portal\Portal
 */
class PortalFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ico8-portal';
    }
}
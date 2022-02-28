<?php

namespace Ikoncept\Ico8\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ikoncept\Ico8\Portal
 */
class Ico8 extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'ico8-api-wrapper';
    }
}

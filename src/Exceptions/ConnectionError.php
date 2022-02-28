<?php

namespace Ikoncept\Ico8\Exceptions;

use Exception;

class ConnectionError extends Exception
{
    /**
     *
     * @return static
     */
    public static function general()
    {
        return new static('Could not connect to iCatServer, please check credentials.');
    }

    /**
     *
     * @return static
     */
    public static function missing()
    {
        return new static('Resource could not be found.');
    }
}

<?php

namespace Ikoncept\Ico8\Exceptions;

use Exception;

class InvalidConfiguration extends Exception
{
    /**
     *
     * @return static
     */
    public static function apiKeyNotSpecified()
    {
        return new static('The API key was not specified, please update the enviornment file with the required credentials');
    }

    /**
     *
     * @return static
     */
    public static function hostNotSpecified()
    {
        return new static('No host was specified, please update the enviornment file with the required credentials');
    }
}
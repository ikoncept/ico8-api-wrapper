<?php

namespace Ikoncept\Ico8;

class ApiClientFactory
{
    public static function createForConfig(array $icoConfig): ApiClient
    {
        return new ApiClient($icoConfig['host'], $icoConfig['api_key'], $icoConfig['tenant_id']);
    }
}

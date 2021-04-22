<?php

namespace Ikoncept\Ico8Portal;

class PortalClientFactory
{
    public static function createForConfig(array $portalConfig): PortalClient
    {
        return new PortalClient($portalConfig['host'], $portalConfig['api_key'], $portalConfig['portal_id']);
    }
}
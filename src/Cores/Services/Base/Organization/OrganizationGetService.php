<?php

namespace App\Cores\Services\Base\Organization;

use App\Cores\Services\GetService;

class OrganizationGetService extends GetService
{
    protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/organization');
    }
}

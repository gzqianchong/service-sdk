<?php

namespace App\Cores\Services\Base\Organization;

use App\Cores\Services\CreateService;

class OrganizationCreateService extends CreateService
{
    protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/organization');
    }
}

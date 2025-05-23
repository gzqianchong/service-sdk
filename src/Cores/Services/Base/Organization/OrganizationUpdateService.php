<?php

namespace App\Cores\Services\Base\Organization;

use App\Cores\Services\UpdateService;

class OrganizationUpdateService extends UpdateService
{
    protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/organization/' . $this->getRequestId());
    }
}

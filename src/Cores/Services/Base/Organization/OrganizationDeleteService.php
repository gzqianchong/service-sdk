<?php

namespace App\Cores\Services\Base\Organization;

use App\Cores\Services\DeleteService;

class OrganizationDeleteService extends DeleteService
{
    protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/organization/' . $this->getRequestId());
    }
}

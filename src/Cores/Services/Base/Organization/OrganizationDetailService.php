<?php

namespace App\Cores\Services\Base\Organization;

use App\Cores\Services\DetailService;

class OrganizationDetailService extends DetailService
{
     protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/organization/' . $this->getRequestId());
    }
}

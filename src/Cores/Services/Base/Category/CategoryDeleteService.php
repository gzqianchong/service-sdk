<?php

namespace App\Cores\Services\Base\Category;

use App\Cores\Services\DeleteService;

class CategoryDeleteService extends DeleteService
{
    protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/category/' . $this->getRequestId());
    }
}

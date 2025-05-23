<?php

namespace App\Cores\Services\Base\Category;

use App\Cores\Services\UpdateService;

class CategoryUpdateService extends UpdateService
{
    protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/category/' . $this->getRequestId());
    }
}

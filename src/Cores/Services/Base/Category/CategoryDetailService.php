<?php

namespace App\Cores\Services\Base\Category;

use App\Cores\Services\DetailService;

class CategoryDetailService extends DetailService
{
     protected function request()
    {
        parent::request();
        $this->setPath('/service-base/api/category/' . $this->getRequestId());
    }
}

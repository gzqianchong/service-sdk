<?php

namespace App\Cores\Features;

use App\Cores\Core;
use Exception;
use Illuminate\Support\Facades\DB;

abstract class Feature extends Core
{
    public function run()
    {
        DB::beginTransaction();;
        try {
            parent::run();
            DB::commit();
        } catch (Exception $exception) {
            DB::rollBack();
            $this->exception($exception);
        }
        return $this;
    }

    protected function exception(Exception $exception)
    {
        $this->error($exception->getMessage());
    }

    abstract protected function error($message = 'error', $data = []);
}

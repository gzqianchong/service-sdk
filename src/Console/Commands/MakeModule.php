<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;

class MakeModule extends Command
{
    protected $signature = 'make:module {modelName?}';

    protected $description = 'Command description';

    public function handle()
    {
        $this->units();
        $this->features();
        $this->controller();
    }

    protected function units()
    {
        $modelName = $this->argument('modelName');
        if (empty($modelName)) {
            return;
        }
        $modelName = Str::studly($modelName);
        $this->call('core:unit', [
            'name' => $modelName . '/' . $modelName . 'CreateUnit',
            '--type' => 'create',
            '--modelName' => $modelName,
        ]);
        $this->call('core:unit', [
            'name' => $modelName . '/' . $modelName . 'UpdateUnit',
            '--type' => 'update',
            '--modelName' => $modelName,
        ]);
        $this->call('core:unit', [
            'name' => $modelName . '/' . $modelName . 'DeleteUnit',
            '--type' => 'delete',
            '--modelName' => $modelName,
        ]);
    }

    protected function features()
    {
        $modelName = $this->argument('modelName');
        if (empty($modelName)) {
            return;
        }
        $modelName = Str::studly($modelName);
        $this->call('core:feature', [
            'name' => $modelName . '/' . $modelName . 'ListsFeature',
            '--type' => 'lists',
            '--modelName' => $modelName,
        ]);
        $this->call('core:feature', [
            'name' => $modelName . '/' . $modelName . 'CreateFeature',
            '--type' => 'create',
            '--modelName' => $modelName,
        ]);
        $this->call('core:feature', [
            'name' => $modelName . '/' . $modelName . 'UpdateFeature',
            '--type' => 'update',
            '--modelName' => $modelName,
        ]);
        $this->call('core:feature', [
            'name' => $modelName . '/' . $modelName . 'DeleteFeature',
            '--type' => 'delete',
            '--modelName' => $modelName,
        ]);
        $this->call('core:feature', [
            'name' => $modelName . '/' . $modelName . 'DetailFeature',
            '--type' => 'detail',
            '--modelName' => $modelName,
        ]);
    }

    protected function controller()
    {
        $modelName = $this->argument('modelName');
        if (empty($modelName)) {
            return;
        }
        $modelName = Str::studly($modelName);
        $this->call('make:controller', [
            'name' => $modelName . 'Controller',
            '--modelName' => $modelName,
        ]);
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class CoreUnit extends GeneratorCommand
{
    protected $name = 'core:unit';

    protected $description = 'Create a new unit class';

    protected $type = 'Unit';

    protected function getStub()
    {
        if ($this->option('type')) {
            return $this->resolveStubPath('/stubs/core.unit.' . $this->option('type') . '.stub');
        }
        return $this->resolveStubPath('/stubs/core.unit.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Cores\Units';
    }

    protected function getOptions()
    {
        return [
            ['modelName', 'modelName', InputOption::VALUE_OPTIONAL, 'modelName'],
            ['type', 'type', InputOption::VALUE_OPTIONAL, 'type'],
        ];
    }

    public function replaceClass($stub, $name)
    {
        $stub = str_replace(['{{ modelName }}'], $this->option('modelName'), $stub);
        return parent::replaceClass($stub, $name);
    }
}

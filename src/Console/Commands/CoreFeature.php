<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class CoreFeature extends GeneratorCommand
{
    protected $name = 'core:feature';

    protected $description = 'Create a new feature class';

    protected $type = 'Feature';

    protected function getStub()
    {
        if ($this->option('type')) {
            return $this->resolveStubPath('/stubs/core.feature.' . $this->option('type') . '.stub');
        }
        return $this->resolveStubPath('/stubs/core.feature.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Cores\Features';
    }

    protected function getOptions()
    {
        return [
            ['type', 'type', InputOption::VALUE_OPTIONAL, 'type'],
            ['modelName', 'modelName', InputOption::VALUE_OPTIONAL, 'modelName'],
        ];
    }

    public function replaceClass($stub, $name)
    {
        $stub = str_replace(['{{ modelName }}'], $this->option('modelName'), $stub);
        return parent::replaceClass($stub, $name);
    }
}

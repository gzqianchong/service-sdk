<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;

class MakeController extends GeneratorCommand
{
    protected $name = 'make:controller';

    protected $description = 'Create a new controller class';

    protected $type = 'Controller';

    protected function getStub()
    {
        return $this->resolveStubPath('/stubs/controller.stub');
    }

    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
            ? $customPath
            : __DIR__ . $stub;
    }

    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Http\Controllers';
    }

    protected function getOptions()
    {
        return [
            ['modelName', 'modelName', InputOption::VALUE_OPTIONAL, 'modelName'],
        ];
    }

    public function replaceClass($stub, $name)
    {
        $stub = str_replace(['{{ modelName }}'], $this->option('modelName'), $stub);
        return parent::replaceClass($stub, $name);
    }
}

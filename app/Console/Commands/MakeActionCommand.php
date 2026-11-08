<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:action', description: 'Create a new action class')]
class MakeActionCommand extends GeneratorCommand
{
    protected $type = 'Action';

    protected function getStub(): string
    {
        return base_path('stubs/action.stub');
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace.'\Actions';
    }
}

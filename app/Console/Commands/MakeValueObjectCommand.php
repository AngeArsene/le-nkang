<?php

namespace App\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Override;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputOption;

#[AsCommand(name: 'make:value-object', description: 'Create a new value object class')]
class MakeValueObjectCommand extends GeneratorCommand
{
    /**
     * Primitive types a generated value object can wrap.
     *
     * @var list<string>
     */
    private const TYPES = ['string', 'int', 'float'];

    protected $type = 'Value object';

    /**
     * Execute the console command.
     */
    public function handle(): ?bool
    {
        if (! in_array($this->option('type'), self::TYPES, true)) {
            $this->components->error('The type must be one of: '.implode(', ', self::TYPES).'.');

            return false;
        }

        if (parent::handle() === false) {
            return false;
        }

        if ($this->option('cast')) {
            return $this->createCast();
        }

        return null;
    }

    #[Override]
    protected function getStub()
    {
        return base_path('stubs/value-object.stub');
    }

    #[Override]
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace.'\ValueObjects';
    }

    #[Override]
    protected function buildClass($name)
    {
        return str_replace('{{ type }}', $this->option('type'), parent::buildClass($name));
    }

    /**
     * Generate the Eloquent cast for the value object, flat in App\Casts.
     */
    private function createCast(): ?bool
    {
        $valueObject = $this->qualifyClass($this->getNameInput());
        $castClass = trim($this->rootNamespace(), '\\').'\Casts\\'.class_basename($valueObject).'Cast';
        $path = $this->getPath($castClass);

        if (! $this->option('force') && File::exists($path)) {
            $this->components->error('Cast already exists.');

            return false;
        }

        $this->makeDirectory($path);

        $type = $this->option('type');

        File::put($path, str_replace(
            [
                '{{ namespace }}',
                '{{ class }}',
                '{{ valueObject }}',
                '{{ valueObjectClass }}',
                '{{ type }}',
                '{{ typeCheck }}',
            ],
            [
                trim($this->rootNamespace(), '\\').'\Casts',
                class_basename($castClass),
                $valueObject,
                class_basename($valueObject),
                $type,
                $type === 'float' ? 'is_int($value) || is_float($value)' : "is_{$type}(\$value)",
            ],
            File::get(base_path('stubs/value-object.cast.stub')),
        ));

        $this->components->info(sprintf('Cast [%s] created successfully.', Str::after($path, base_path().DIRECTORY_SEPARATOR)));

        return null;
    }

    /**
     * @return array<int, array<int, mixed>>
     */
    #[Override]
    protected function getOptions()
    {
        return [
            ['cast', 'c', InputOption::VALUE_NONE, 'Also create an Eloquent cast for the value object'],
            ['type', 't', InputOption::VALUE_REQUIRED, 'Primitive wrapped by the value object (string, int or float)', 'string'],
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if it already exists'],
        ];
    }
}

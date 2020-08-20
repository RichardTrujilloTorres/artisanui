<?php

namespace Desemax\ArtisanUI;

use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Command\Command;

class ArtisanUI
{
    public function commands()
    {
        return array_values(array_filter(Artisan::all(), function ($command) {
            return ! in_array($this->getNamespace($command), $this->ignoredNamespaces());
        }));
    }

    public function names()
    {
        return array_keys($this->commands());
    }

    public function namespaces()
    {
        return array_values(array_unique(array_map(function ($command) {
            return $this->getNamespace($command);
        }, $this->commands())));
    }

    public function getNamespace(Command $command)
    {
        return explode(':', $command->getName())[0];
    }

    public function ignoredNamespaces()
    {
        return array_merge(
            config('artisanui.commands.namespaces.excluded.default'),
            config('artisanui.commands.namespaces.excluded.custom')
        );
    }
}

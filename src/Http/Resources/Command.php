<?php

namespace Desemax\ArtisanUI\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class Command extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'name' => $this->getName(),
            'help' => $this->getHelp(),
            'description' => $this->getDescription(),
            'arguments' => $this->getArguments(),
            'options' => $this->getOptions(),
        ];
    }

    protected function getArguments()
    {
        return array_map(function (InputArgument $inputArgument) {
            return [
                'name' => $inputArgument->getName(),
                'description' => $inputArgument->getDescription(),
                'default' => $inputArgument->getDefault(),
                'required' => $inputArgument->isRequired(),
            ];
        }, $this->getDefinition()->getArguments());
    }

    protected function getOptions()
    {
        return array_map(function (InputOption $inputOption) {
            return [
                'name' => $inputOption->getName(),
                'description' => $inputOption->getDescription(),
                'shortcut' => $inputOption->getShortcut(),
                'default' => $inputOption->getDefault(),
            ];
        }, $this->getDefinition()->getOptions());
    }
}

<?php

namespace Desemax\ArtisanUI\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Desemax\ArtisanUI\ArtisanUI;
use Desemax\ArtisanUI\Http\Requests\RunCommandRequest;
use Desemax\ArtisanUI\Http\Resources\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class CommandsController extends Controller
{
    /**
     * @var ArtisanUI
     */
    protected $artisanUI;

    public function __construct(ArtisanUI $artisanUI)
    {
        $this->artisanUI = $artisanUI;
    }

    public function index()
    {
        $commands = Command::collection($this->artisanUI->commands());

        return response()->json(compact('commands'));
    }

    protected function getArguments(Request $request)
    {
        return array_merge($request->get('arguments', []), $this->getOptions($request));
    }

    protected function getOptions(Request $request)
    {
        $result = [];
        foreach ($request->get('options', []) as $option) {
            $result['--'.$option] = true;
        }

        return $result;
    }

    public function run(RunCommandRequest $request)
    {
        $arguments = $this->getArguments($request);

        try {
            $status = ! empty($arguments) ?
                Artisan::call($request->get('name'), $arguments) :
                Artisan::call($request->get('name'));
        } catch (\Exception $exception) {
            return response()->json([
                'status' => 1,
                'message' => $exception->getMessage(),
            ], 422);
        }


        return response()->json([
            'status' => $status,
            'output' => Artisan::output(),
        ], 201);
    }
}

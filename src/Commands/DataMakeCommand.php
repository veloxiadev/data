<?php

namespace Veloxia\Data\Commands;

use Illuminate\Console\Command;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Veloxia\Data\Exceptions\DependencyException;

class DataMakeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vd:make {graph : Name of the graph to use}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a VD Graph Model.';

    private $templates;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $graph = $this->argument('graph');
        $className = ucfirst(substr($graph, 0, strlen($graph) - 1));

        $first = app('data')->fetch($graph)[0];

        // check if Twig environment is installed
        if (!class_exists(Environment::class)) {
            throw new DependencyException(Environment::class . ' is required to execute this command.');
        }
        // check if Twig FS loader is installed
        if (!class_exists(FilesystemLoader::class)) {
            throw new DependencyException(Environment::class . ' is required to execute this command.');
        }

        $fs = new FilesystemLoader(__DIR__ . '/templates/');
        $twig = new Environment($fs);

        $directory = config('data.graph_path', __DIR__ . '/../../build');
        $targetPath = $directory . '/' . $className . '.php';

        $methods = array_keys($first);
        sort($methods);

        $methods = array_map(function ($item) {
            return [
                'annotations'  => [
                    "Get the value of ${item}.",
                ],
                'name' => lcfirst(
                    # example_attribute => exampleAttribute
                    preg_replace_callback('/([^\_]+)_?/i', function ($match) {
                        return ucfirst($match[1]);
                    }, $item)
                ),
            ];
        }, $methods);

        $php = $twig->render('graph.twig', [
            'name' => $className,
            'methods' => $methods,
        ]);

        dd($targetPath);

        dd($php);
    }
}

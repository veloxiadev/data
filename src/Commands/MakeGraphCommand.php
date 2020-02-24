<?php

namespace Veloxia\Data\Commands;

use Illuminate\Console\Command;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;
use Veloxia\Data\Exceptions\DependencyException;

class MakeGraphCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vd:make:graph {graph : Name of the graph to create}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download a VD Graph Model.';

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

        # Grab the first row and use for column information
        $first = app('data')->fetch($graph)[0];

        # check if Twig environment is installed
        if (!class_exists(Environment::class)) {
            throw new DependencyException(Environment::class . ' is required to execute this command.');
        }
        # check if Twig FS loader is installed
        if (!class_exists(FilesystemLoader::class)) {
            throw new DependencyException(Environment::class . ' is required to execute this command.');
        }

        $fs = new FilesystemLoader(__DIR__ . '/templates/');
        $twig = new Environment($fs);

        $directory = __DIR__ . '/../../graph';
        $targetPath = $directory . '/' . $className . '.php';

        $methods = array_keys($first);
        sort($methods);

        # All attributes should have their own method in the output class.
        $methods = array_map(function ($item) {
            return [
                'annotations'  => [
                    "Get the value of ${item}.",
                ],
                'name' => lcfirst(
                    preg_replace_callback('/([^\_]+)_?/i', function ($match) {
                        return ucfirst($match[1]);
                    }, $item)
                ),
                'logic' => [
                    'return $this->get(\'' . $item . '\');',
                ],
            ];
        }, $methods);

        # Parse the .twig and get the PHP file
        $php = $twig->render('graph.twig', [
            'namespace' => 'Veloxia\\Data\\Graph',
            'name' => $className,
            'graph' => $graph,
            'methods' => $methods,
        ]);

        # Save file
        touch($targetPath);
        file_put_contents($targetPath, $php);

        $this->info($className . ' was successfully saved.');
    }
}

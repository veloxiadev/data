<?php

namespace Veloxia\Data\Commands;

use Twig\Environment;
use Veloxia\Data\Facades\VD;
use Illuminate\Console\Command;
use Twig\Loader\FilesystemLoader;
use Illuminate\Support\Facades\Storage;
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

        # Fetch schema from the API
        $attributes = VD::makeApiRequest($graph, 'graph');

        # check if Twig environment is installed
        if (!class_exists(Environment::class)) {
            throw new DependencyException(Environment::class . ' is required to execute this command.');
        }
        # check if Twig FS loader is installed
        if (!class_exists(FilesystemLoader::class)) {
            throw new DependencyException(FilesystemLoader::class . ' is required to execute this command.');
        }

        # Instanciate Twig stuff.
        $fs = new FilesystemLoader(__DIR__ . '/templates/');
        $twig = new Environment($fs);

        $directory = __DIR__ . '/../../graph';
        $targetPath = $directory . '/' . $className . '.php';

        ksort($attributes);

        $classMap = [];

        # All attributes should have their own method in the output class.
        # This allows easy autocompletion etc. when developing.
        $methods = array_map(function ($item) use ($attributes, &$classMap) {
            $cast = $this->mapSchemaType($attributes[$item]);
            $classMap[] = "'${item}' => ['" . camel($item) . "', ${cast}::class],";
            return [
                'annotations'  => [
                    "Get the value of ${item} (" . $attributes[$item] . ").",
                    "",
                    "@return " . $cast,
                ],
                'name' => camel($item),
                'cast' => $cast,
                'logic' => [
                    'return $this->get(\'' . $item . '\');',
                ],
            ];
        }, array_keys($attributes));

        # Parse the .twig and get the PHP file
        $php = $twig->render('graph.twig', [
            'namespace' => 'Veloxia\\Data\\Graph',
            'name' => $className,
            'graph' => $graph,
            'methods' => $methods,
            'classMap' => $classMap,
        ]);

        # Save file
        touch($targetPath);
        file_put_contents($targetPath, $php);
        $this->info("\\Veloxia\\Data\\Graph\\" . $className . " has been saved.");
    }

    /**
     * Convert basic types (like `int` or `string`) into the proper local form.
     *
     * @param   string  $type
     *
     * @return  string
     */
    protected function mapSchemaType(string $type)
    {

        $cast = null;

        switch ($type) {
            case "float":
                $cast = '\\Veloxia\\Data\\Casts\\Basic\\FloatType';
                break;
            case "integer":
                $cast = '\\Veloxia\\Data\\Casts\\Basic\\IntegerType';
                break;
            case "datetime":
                $cast = '\\Veloxia\\Data\\Casts\\Basic\\DateTimeType';
                break;
            case "date":
                $cast = '\\Veloxia\\Data\\Casts\\Basic\\DateTimeType';
                break;
            case "text":
                $cast = '\\Veloxia\\Data\\Casts\\Basic\\TextType';
                break;
            case "string":
                $cast = '\\Veloxia\\Data\\Casts\\Basic\\StringType';
                break;
            case "boolean":
                $cast = '\\Veloxia\\Data\\Casts\\Basic\\BooleanType';
                break;
        }

        return "${cast}";
    }
}

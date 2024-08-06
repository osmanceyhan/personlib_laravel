<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class CustomResourceCommand extends Command
{
    protected $signature = 'make:custom-resource {model} {resource?}';

    protected $description = 'Create a custom resource for the given model.';

    public function handle()
    {
        $model = $this->argument('model');
        $resource = $this->argument('resource');

        if (!$resource) {
            $resource = $model;
        }


        // Dizin yapısını oluşturuyoruz
        $resourcePath = app_path("Http/Resources/" . dirname(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $resource)));

        if (!File::exists($resourcePath)) {
            File::makeDirectory($resourcePath, 0755, true);
        }

        // Dosya adını düzeltilmiş haline getiriyoruz
        $resourceFileName = Str::studly(basename(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $resource)));

        $resourceFile = "{$resourcePath}/{$resourceFileName}.php";
        if (File::exists($resourceFile)) {
            $this->error('Resource file already exists!');
            return;
        }

        $fillableAttributes = $this->getFillableAttributes($model);

        // Dosya adını düzeltilmiş haline getiriyoruz
        $nameSpaceFileName = basename(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $resource));
        $nameSpaceFilePath = "{$resourcePath}/{$resourceFileName}.php";
        $nameSpace = preg_replace('#' . preg_quote($resourceFileName, '#') . '$#', '', $resourceFile) . $resourceFileName . ".php";

        $content = "<?php

namespace App\Http\Resources\\" . str_replace(DIRECTORY_SEPARATOR, '\\', dirname($resource)) . ";
use Illuminate\Http\Resources\Json\JsonResource;" . ($this->shouldUseEnum($fillableAttributes) ? "\nuse App\Enumerations\BasicEnum;" : "") . "

class {$resourceFileName} extends JsonResource
{
    public function toArray(\$request)
    {
        return [
            // Customize the resource array based on your requirements
" . $this->generateFillablesArray($fillableAttributes) . "
        ];
    }
}
";

        File::put($resourceFile, $content);

        $this->info('Resource created successfully.');
    }

    protected function shouldUseEnum($fillableAttributes)
    {
        return in_array('status', $fillableAttributes);
    }


    protected function getFillableAttributes($model)
    {
        $class = "App\\Models\\{$model}";

        if (!class_exists($class)) {
            $this->error("Model class {$class} not found!");
            exit;
        }

        $modelInstance = new $class;

        return $modelInstance->getFillable() ?: $this->getDatabaseColumns($modelInstance->getTable());
    }
    protected function getDatabaseColumns($table)
    {
        return DB::getSchemaBuilder()->getColumnListing($table);
    }

    protected function generateFillablesArray($fillableAttributes)
    {
        if (!empty($fillableAttributes)) {
            foreach ($fillableAttributes as $attribute) {
                $arrayLines[] = "            '{$attribute}' => " . ($attribute === 'status' ? "BasicEnum::getDetail(\$this->{$attribute})," : "\$this->{$attribute},");
            }
        }

        return implode("\n", $arrayLines ?? []);
    }
}

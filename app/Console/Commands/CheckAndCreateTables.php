<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use File;

class CheckAndCreateTables extends Command
{
    protected $signature = 'tables:check-and-create';

    protected $description = 'Check and create missing tables for models';

    public function handle()
    {
        // Get all models in the Models directory
        $models = collect(File::allFiles(app_path('Models')))
            ->map(function ($item) {
                return 'App\\Models\\' . pathinfo($item->getFilename(), PATHINFO_FILENAME);
            })
            ->filter(function ($class) {
                return class_exists($class) && is_subclass_of($class, 'Illuminate\Database\Eloquent\Model');
            });

        // Iterate through each model and check if the corresponding table exists
        foreach ($models as $model) {
            $instance = new $model;

            $table = $instance->getTable();

            if (!Schema::hasTable($table)) {
                // If the table does not exist, create it
                $this->info("Creating table for model: {$model}");
                $this->createTable($instance);
            }
        }

        $this->info('Tables checked and created if missing.');
    }

    private function createTable($instance)
    {
        $tableName = $instance->getTable();
        $fillable = array_unique(array_diff($instance->getFillable(), ['id', 'created_at', 'updated_at', 'deleted_at']));

        // If the table does not exist yet
        if (!Schema::hasTable($tableName)) {
            Schema::create($tableName, function ($table) use ($fillable) {
                // Add columns
                $table->bigIncrements('id');
                foreach ($fillable as $fillableColumn) {
                    $table->string($fillableColumn)->nullable();
                }
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }
}

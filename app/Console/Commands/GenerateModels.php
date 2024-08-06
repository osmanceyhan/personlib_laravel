<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class GenerateModels extends Command
{
    protected $signature = 'generate:models';

    protected $description = 'Generate migration and model files for existing tables';

    public function handle()
    {
        $tables = DB::connection()->getDoctrineSchemaManager()->listTableNames();

        foreach ($tables as $table) {
            $modelClassName = Str::studly($table);
            $migrationClassName = "Create{$modelClassName}Table";

            $modelFilePath = app_path("Models/{$modelClassName}.php");
            $migrationFilePath = database_path("migrations/" . date('Y_m_d_His') . "_create_{$table}_table.php");

            if (!file_exists($modelFilePath)) {
                Artisan::call('make:model', ['name' => "{$modelClassName}"]); // Yeni hali
                $this->info("Model 'Models\\{$modelClassName}' created successfully.");
            } else {
                $this->info("Model 'Models\\{$modelClassName}' already exists, skipping.");
            }

            if (!file_exists($migrationFilePath)) {
                // Migration oluşturmadan önce try-catch bloğunu kullan
                try {
                    Artisan::call('make:migration', ['name' => "create_{$table}_table"]);
                    $this->info("Migration 'create_{$table}_table' created successfully.");
                } catch (\Exception $e) {
                    $this->warn("Migration 'create_{$table}_table' already exists, skipping.");
                }
                $this->info("Migration 'create_{$table}_table' created successfully.");
            } else {
                $this->info("Migration 'create_{$table}_table' already exists, skipping.");
            }

            $this->updateModelFile($modelFilePath, $table);
        }

        $this->info('Models and migrations generated successfully.');
    }

    protected function updateModelFile($modelFilePath, $table)
    {
        if (!file_exists($modelFilePath)) {
            $this->error("Model file not found: $modelFilePath");
            return;
        }

        // Dosyayı oku
        $modelContent = file_get_contents($modelFilePath);

        // Dosya okunamazsa hata ver
        if ($modelContent === false) {
            $this->error("Failed to read model file: $modelFilePath");
            return;
        }

        // Check if the $table variable already exists in the model file
        if (strpos($modelContent, '$table') === false) {
            // If not, add it to the model file
            $modelContent = str_replace(
                'use HasFactory;',
                "use HasFactory;\n\n    protected \$table = '{$table}';",
                $modelContent
            );
        }

        // Check if the $fillable variable already exists in the model file
        if (strpos($modelContent, '$fillable') === false) {
            // If not, add it to the model file with all columns
            $columns = $this->getTableColumns($table);
            $fillableString = count($columns) > 0 ? "'" . implode("', '", $columns) . "'" : "''";

            $modelContent = str_replace(
                'use HasFactory;',
                "use HasFactory;\n\n    protected \$fillable = [{$fillableString}];",
                $modelContent
            );
        }

        // Save the updated content back to the model file
        file_put_contents($modelFilePath, $modelContent);

        $this->info("Model 'Models\\" . basename($modelFilePath, '.php') . "' updated successfully.");

        // Update migration file to add columns
        $this->updateMigrationFile($table, $columns);
    }

    protected function updateMigrationFile($table, $columns)
    {
        $migrationFileName = "create_{$table}_table";
        $migrationFilePath = database_path("migrations/");

        // Find the migration file
        $migrationFiles = glob($migrationFilePath . '*' . $migrationFileName . '.php');
        if (count($migrationFiles) == 1) {
            $migrationFile = $migrationFiles[0];
            $migrationContent = file_get_contents($migrationFile);

            // Find the 'up' method body
            preg_match("/public function up\(\).*\{(.|\n)*?\}/s", $migrationContent, $matches);
            $upMethodBody = trim($matches[0]);

            // Find the position of $table->timestamps();
            $timestampsPosition = strpos($upMethodBody, '$table->timestamps();');

            // Add column definitions right after $table->timestamps();
            $upMethodBody = substr_replace($upMethodBody, $this->getColumnDefinitions($columns), $timestampsPosition + strlen('$table->timestamps();'), 0);

            // Replace the 'up' method body in the migration file
            $migrationContent = str_replace($matches[0], $upMethodBody, $migrationContent);

            // Save the updated content back to the migration file
            file_put_contents($migrationFile, $migrationContent);

            $this->info("Migration '{$migrationFileName}' updated successfully.");
        } else {
            $this->warn("Migration file not found for '{$migrationFileName}'.");
        }
    }

    protected function getColumnDefinitions($columns)
    {
        $definitions = '';
        foreach ($columns as $column) {
            $definitions .= "\n\t\t\t{$this->getSchemaString($column)}";
        }
        return $definitions;
    }


    protected function getSchemaString($columnType)
    {
        // Example: 'INT' for an integer column
        // You can expand this method to support more types as needed

        // Assume all columns are VARCHAR by default
        $schemaString = "\$table->string('{$columnType}')";

        // Check specific column types
        if (strpos($columnType, 'email') !== false) {
            $schemaString = "\$table->string('{$columnType}')";
        } elseif (strpos($columnType, 'password') !== false) {
            $schemaString = "\$table->string('{$columnType}')";
        } elseif (strpos($columnType, 'date') !== false) {
            $schemaString = "\$table->date('{$columnType}')";
        } elseif (strpos($columnType, 'timestamp') !== false) {
            $schemaString = "\$table->timestamp('{$columnType}')";
        } elseif (strpos($columnType, 'is_') === 0 && strpos($columnType, '_flag') !== false) {
            // Example: 'TINYINT(1)' for a boolean flag
            $schemaString = "\$table->boolean('{$columnType}')";
        } elseif (strpos($columnType, '_id') !== false) {
            // Example: 'INT' for a foreign key
            $schemaString = "\$table->foreignId('{$columnType}')->constrained()";
        } elseif (strpos($columnType, '_at') !== false) {
            // Example: 'TIMESTAMP' for a timestamp
            $schemaString = "\$table->timestamp('{$columnType}')";
        }

        return $schemaString . ";";
    }

    protected function getTableColumns($table)
    {
        $columns = [];

        // Veritabanındaki tablo sütunlarını al
        $columnsInfo = Schema::getColumnListing($table);

        foreach ($columnsInfo as $column) {
            $columns[] = $column;
        }

        return $columns;
    }

}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeModuleCommand extends Command
{
    protected $signature = 'make:module {name}';
    protected $description = 'Generate repository interface, implementation, and service class for a module';

    public function handle()
    {
        $name = Str::studly($this->argument('name'));

        $repositoryInterface = app_path("Repositories/Interfaces/{$name}RepositoryInterface.php");
        $repositoryClass = app_path("Repositories/{$name}Repository.php");

        $serviceClass = app_path("Services/{$name}Service.php");

        // Create directories if not exist
        File::ensureDirectoryExists(dirname($repositoryInterface));
        File::ensureDirectoryExists(dirname($serviceClass));

        // Generate Repository Interface
        if (!File::exists($repositoryInterface)) {
            File::put($repositoryInterface, $this->getRepositoryInterfaceContent($name));
            $this->info("Created: {$repositoryInterface}");
        }

        // Generate Repository Implementation
        if (!File::exists($repositoryClass)) {
            File::put($repositoryClass, $this->getRepositoryContent($name));
            $this->info("Created: {$repositoryClass}");
        }

        // Generate Service Implementation
        if (!File::exists($serviceClass)) {
            File::put($serviceClass, $this->getServiceContent($name));
            $this->info("Created: {$serviceClass}");
        }

        // Generate Controller
        $controllerName = "{$name}Controller";
        Artisan::call('make:controller', [
            'name' => $controllerName,
        ]);

        $this->info("Created controller: {$controllerName}");


        return Command::SUCCESS;
    }

    private function getRepositoryInterfaceContent($name)
    {
        return <<<PHP
<?php

namespace App\Repositories\Interfaces;

interface {$name}RepositoryInterface
{
    // Define your methods here
}
PHP;
    }

    private function getRepositoryContent($name)
    {
        return <<<PHP
<?php

namespace App\Repositories;

use App\Repositories\Interfaces\\{$name}RepositoryInterface;

class {$name}Repository implements {$name}RepositoryInterface
{
    // Implement your methods here
}
PHP;
    }

    private function getServiceContent($name)
    {
        return <<<PHP
<?php

namespace App\Services;

class {$name}Service
{
    // Implement your service logic here
}
PHP;
    }
}

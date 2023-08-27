<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Create a new service class with four functions';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $name = $this->argument('name');
        $path = app_path("Servicio/{$name}.php");

        if (File::exists($path)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        File::put($path, $this->serviceStub($name));
        $this->info("Service {$name} created successfully.");
    }

    protected function serviceStub($name)
    {


        $functionsTemplate = '
        public function Create($data)
        {
            //
        }

        public function Update($data)
        {
            //
        }

        public function Delete($data)
        {
            //
        }

        public function Consultar($data)
        {
            //
        }


        ';
        

        return "<?php

namespace App\Servicio;

class {$name}Servicio
{
    {$functionsTemplate}
}
";
    }
}


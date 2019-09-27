<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\Generate\GenerateFiles;

/**
 * Class GenerateFileCommand
 * @package App\Command
 * @author samark chaisanguan <samarkchsngn@gmail.com>
 */
class GenerateFileCommand extends Command
{
    /**
     * The name and signature of the console command.
     * @var string
     */
    protected $signature = 'maxca:genfile';

    /**
     * The console command description.
     * @var string
     */
    protected $description = 'Generate API Resource file.';

    /**
     * generate list
     * @var collection
     */
    protected $generate;

    /**
     * Create a new command instance.
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }

    /**
     * Execute the console command.
     * @return mixed
     */
    public function handle()
    {
        $namespace      = $this->ask('What is your namespace ?');
        $this->generate = app(GenerateFiles::class, ['namespace' => $namespace]);
        $this->generate->setTemplatePath('/');
        $this->generate->setPath(base_path());
        $this->generate->execute();

        $this->generate->makeMigration();
        dump(sprintf("\r\ngenerate module %s success !", $namespace));
    }
}
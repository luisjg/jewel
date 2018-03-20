<?php

namespace App\Console\Commands;

use App\Classes\DataHandler;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateCenterCache extends Command
{
    /**
     * Name of the command
     * @var string
     */
    protected $signature = 'update:centers {entity_id}';

    /**
     * Description of the command
     * @var string
     */
    protected $description = 'Updates the Department Cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $entity_id = $this->argument('entity_id');
        if (File::exists(storage_path('centers/'.$entity_id.'.txt'))) {
            $deptList = DataHandler::getCenterData($entity_id);
            File::put(storage_path('centers/'.$entity_id.'.txt'), $deptList);
            $this->info('The \'centers\' data has been added to the cache.');
        } else {
            $deptList = DataHandler::getCenterData($entity_id);
            File::makeDirectory(storage_path('centers'));
            File::put(storage_path('centers/'.$entity_id.'.txt'), $deptList);
            $this->info('The \'centers\' data has been added to the cache.');
        }
    }
}
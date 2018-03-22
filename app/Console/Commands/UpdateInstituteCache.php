<?php

namespace App\Console\Commands;

use App\Classes\DataHandler;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateInstituteCache extends Command
{
    /**
     * Name of the command
     * @var string
     */
    protected $signature = 'update:institutes {entity_id}';

    /**
     * Description of the command
     * @var string
     */
    protected $description = 'Updates the Institute Cache';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $entity_id = $this->argument('entity_id');
        if (File::exists(storage_path('institutes/'.$entity_id.'.txt'))) {
            $deptList = DataHandler::getInstituteData($entity_id);
            File::put(storage_path('institutes/'.$entity_id.'.txt'), $deptList);
            $this->info('The \'institutes\' data has been added to the cache.');
        } else {
            if (!File::exists(storage_path('institutes'))) {
                File::makeDirectory(storage_path('institutes'));
            }
            $deptList = DataHandler::getInstituteData($entity_id);
            File::put(storage_path('institutes/'.$entity_id.'.txt'), $deptList);
            $this->info('The \'institutes\' data has been added to the cache.');
        }
    }
}
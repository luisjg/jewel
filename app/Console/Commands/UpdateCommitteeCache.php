<?php

namespace App\Console\Commands;

use App\Classes\DataHandler;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class UpdateCommitteeCache extends Command
{
    /**
     * Name of the command
     * @var string
     */
    protected $signature = 'update:committees {entity_id}';

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
        if (File::exists(storage_path('committees/'.$entity_id.'.txt'))) {
            $deptList = DataHandler::getCommitteeData($entity_id);
            File::put(storage_path('committees/'.$entity_id.'.txt'), $deptList);
            $this->info('The \'committees\' data has been added to the cache.');
        } else {
            if (!File::exists(storage_path('committees'))) {
                File::makeDirectory(storage_path('committees'));
            }
            $deptList = DataHandler::getCommitteeData($entity_id);
            File::put(storage_path('committees/'.$entity_id.'.txt'), $deptList);
            $this->info('The \'committees\' data has been added to the cache.');
        }
    }
}
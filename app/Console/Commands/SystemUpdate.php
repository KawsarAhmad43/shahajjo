<?php

namespace App\Console\Commands;

use App\Http\Controllers\Admin\System\RoleController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class SystemUpdate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update the role based authorization';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $bool = (new RoleController )->systemsRoleUpdate();

        if ($bool) {
            Artisan::call('optimize:clear');
            $this->info('System role updated successfully.');

            return 0;
        }

        $this->warning('Something, is broken!');
    }
}

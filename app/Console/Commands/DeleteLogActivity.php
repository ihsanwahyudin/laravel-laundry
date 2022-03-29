<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DeleteLogActivity extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:deleteLog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Every Monthly, Data Log Activity will be deleted';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return 0;
    }
}

<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CopyJsonTranslation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:copy-json-translation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $base = file_get_contents(base_path('base.json'));
        $base = json_decode($base, true);
        $tmp = [];
        foreach ($base as $key => $value) {
            $tmp[$key] = $key;
        }
        echo json_encode($tmp, JSON_PRETTY_PRINT);
    }
}

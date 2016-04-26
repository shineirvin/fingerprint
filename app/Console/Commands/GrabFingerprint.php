<?php

namespace App\Console\Commands;

// Model
use App\Kelasmk;
use App\Dami;
use App\Hari;
use App\Ipfingerprint;
use App\Ruang;

use Carbon\Carbon;

use Illuminate\Console\Command;

class GrabFingerprint extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fingerprint:grab';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Grab data from fingerprint machine';

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
     * @return mixed
     */
    public function handle()
    {
        $ips = Ipfingerprint::select('ip_address')->get();
        foreach ($ips as $ip) {
                app('App\Http\Controllers\FingerprintController')->cobaupdatedata();       
        }
    }
}

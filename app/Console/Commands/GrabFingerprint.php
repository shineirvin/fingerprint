<?php

namespace App\Console\Commands;

// Model
use App\Kelasmk;
use App\Dami;
use App\Hari;
use App\Ipfingerprint;
use App\Ruang;
use App\Kelaspengganti;

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
        $datetime = Carbon::now();

        $ips = \DB::table('jadwal_kelas')
                  ->join('ipfingerprint', 'jadwal_kelas.ruang_id', '=', 'ipfingerprint.ruang_id')
                  ->select('ipfingerprint.ip_address')
                  ->where('semester', $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2'))
                  ->get();

        foreach ($ips as $ip) {
            $ipdata[] = $ip;
        }

        $ipDirty = collect($ipdata);
        $ipfingerprints = $ipDirty->unique();
        foreach ($ipfingerprints as $ip) {
            app('App\Http\Controllers\FingerprintController')->labfingerprint($ip->ip_address);    
            \Log::info(app('App\Http\Controllers\FingerprintController')->labfingerprint($ip->ip_address));
            \Log::info('=================================================================================');
        }
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dami;
use App\Dpmk;
use App\User;
use App\Kelasmk;
use App\Ruang;
use App\Presensikelas;
use App\Ipfingerprint;
use App\Jadwalkelas;
use App\Detailkelas;
use App\Asistenkelas;
use App\Presensidosenlab;
use App\Kelaspengganti;
use App\KelaspenggantiLab;

use Carbon\Carbon;

use App\Http\Controllers\Controller;

class FingerprintController extends Controller
{
    public function cobatarikdata()
    {
		$newBuffer = $this->connection();
		$for_limit = count($this->connection());
		for($a=1;$a<$for_limit-1;$a++) {
			$data = $this->Parse_Data($newBuffer[$a],"<Row>","</Row>");
	        $data_row = [
	            "identity" => $this->Parse_Data($data,"<PIN>","</PIN>"),
	            "datetime" => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
	        ];
	        $x = new Dami($data_row);
	        $x->save();
		}
		return redirect('compare');

	}

	/**
	 * Grab data from the fingerprint machine from the last time with additional filter
	 * @param  String $ip_address
	 * @return String             Save filtered data to local database
	 */
	public function cobaupdatedata($ip_address = '192.168.1.201')
	{
		$newBuffer = $this->connection($ip_address);
		$for_limit = count($this->connection($ip_address));
        $hari = $this->datefilter();
		$datetime = Carbon::now();
        $semester = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');

        $ruang = Ipfingerprint::select('ruang_id')
        		->where('ip_address', $ip_address)
        		->first();



        $kelaspengganti = \DB::table('kelaspengganti') 
        				  ->join('kelasmk', 'kelaspengganti.kelasmk_id', '=', 'kelasmk.id')
        				  ->select('kelaspengganti.id', 'kelaspengganti.kelasmk_id', 'kelaspengganti.waktu', 'kelaspengganti.hari_id', 'kelaspengganti.status', 'kelasmk.dosen_id')
        				  ->where('kelaspengganti.waktu', '<=', Carbon::now())
        				  ->where('kelaspengganti.ruang_id', $ruang->ruang_id)
        				  ->where('kelaspengganti.hari_id', $hari)
        				  ->where('kelaspengganti.status', '1')
        				  ->first();

        if ($kelaspengganti) {
			$dosen_id = $kelaspengganti->dosen_id;
			$kelasmk_id = $kelaspengganti->kelasmk_id;
			$kelaspengganti_id = $kelaspengganti->id;
			$time = $kelaspengganti->waktu;
			$nim = array();
			$datetime = array();

			$dpmk = Dpmk::select('nim')->where('kelasmk_id', $kelasmk_id)->get();
			foreach ($dpmk as $peserta) {
				$listPeserta[] = $peserta->nim;
			}

			$listPeserta[] = $kelaspengganti->dosen_id;
			$array_search = array_flip($listPeserta);

			for($a=1; $a < $for_limit-1; $a++) {
				$data = $this->Parse_Data($newBuffer[$a],"<Row>","</Row>");
				$data_row = [
			        "identity" => $this->Parse_Data($data,"<PIN>","</PIN>"),
			        "datetime" => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
			    ];
			    $x = new Dami($data_row);
			    $x->save();
				$search_array = array_flip($nim);
				if (!array_key_exists($this->Parse_Data($data,"<PIN>","</PIN>"), $search_array)) {	
					if (array_key_exists($this->Parse_Data($data,"<PIN>","</PIN>"), $array_search)) {
						if ($this->Parse_Data($data,"<DateTime>","</DateTime>") >= Carbon::parse($time)->subMinutes(15) && $this->Parse_Data($data,"<DateTime>","</DateTime>") <= Carbon::parse($time)->addMinutes(15)) {
							array_push($nim, $this->Parse_Data($data,"<PIN>","</PIN>"));
					    	array_push($datetime, $this->Parse_Data($data,"<DateTime>","</DateTime>"));
					   	}
					}
				}
			}

			$absensi = [];
			$absensiDosen = [];
			$tidakhadir = [];
			$tidakhadirDosen = [];

			$lastPertemuan = Presensikelas::select('pertemuan')
											->where('kelasmk_id', $kelasmk_id)
											->orderBy('pertemuan', 'desc')
											->first();

			foreach ( array_diff($listPeserta, $nim) as $notAttendUser) {
				if ( $notAttendUser == $dosen_id ) {
					/*$this->cleardata($ip_address);*/
					return 'OPERATION ABORTED';
				}
			}
			foreach ( array_diff($listPeserta, $nim) as $notAttendUser) {
				if( $lastPertemuan ) {
					if ( $notAttendUser != $dosen_id ) {
					    $tidakhadir[] = [
					        'nim'  			=> $notAttendUser,
					        'waktu'			=> '',
					        'keterangan'    => '4',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> $lastPertemuan->pertemuan + 1,
					    ];
					}
				}
				if( !$lastPertemuan ) {
					if ( $notAttendUser != $dosen_id ) {
					    $tidakhadir[] = [
					        'nim'  			=> $notAttendUser,
					        'waktu'			=> '',
					        'keterangan'    => '4',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> '1',
					    ];
					}
				}
			}
			\DB::table('presensikelas')->insert($tidakhadir);
			\DB::table('presensidosen')->insert($tidakhadirDosen);

			foreach ($nim as $key => $attendedUser) {
				if( $lastPertemuan ) {
					if ( $attendedUser == $dosen_id ) {
					    $absensiDosen[] = [
					        'nik'  			=> $attendedUser,
					        'waktu'			=> $datetime[$key],
					        'keterangan'    => '1',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> $lastPertemuan->pertemuan + 1,
					    ];
			        }
					if ( $attendedUser != $dosen_id ) {
					    $absensi[] = [
					        'nim'  			=> $attendedUser,
					        'waktu'			=> $datetime[$key],
					        'keterangan'    => '1',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> $lastPertemuan->pertemuan + 1,
					    ];
			        }	
				}
				if( !$lastPertemuan ) {
					if ( $attendedUser == $dosen_id ) {
					    $absensiDosen[] = [
					        'nik'  			=> $attendedUser,
					        'waktu'			=> $datetime[$key],
					        'keterangan'    => '1',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> '1',
					    ];
			        }	
					if ( $attendedUser != $dosen_id ) {
					    $absensi[] = [
					        'nim'  			=> $attendedUser,
					        'waktu'			=> $datetime[$key],
					        'keterangan'    => '1',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> '1',
					    ];
			        }	
				}
			}
			\DB::table('presensikelas')->insert($absensi);
			\DB::table('presensidosen')->insert($absensiDosen);


			$updateStatusKP = Kelaspengganti::find($kelaspengganti_id);
			$updateStatusKP->status = '0';
			$updateStatusKP->save();			



			/*$this->cleardata($ip_address);*/
			return 'BERHASIL';
        } else {
	        $data = Kelasmk::select('id', 'waktu', 'ruang_id', 'dosen_id', 'semester')
	        		->where('waktu', '<=', Carbon::now())
	        		->where('hari_id', $hari)
	        		->where('ruang_id', $ruang->ruang_id)
	        		->where('semester', $semester)
	        		->orderBy('waktu', 'desc')
	        		->first();

			$dosen_id = $data->dosen_id;
			$kelasmk_id = $data->id;
			$time = $data->waktu;
			$nim = array();
			$datetime = array();

			$dpmk = Dpmk::select('nim')->where('kelasmk_id', $data->id)->get();
			foreach ($dpmk as $peserta) {
				$listPeserta[] = $peserta->nim;
			}

			$listPeserta[] = $data->dosen_id;
			$array_search = array_flip($listPeserta);

			for($a=1; $a < $for_limit-1; $a++) {
				$data = $this->Parse_Data($newBuffer[$a],"<Row>","</Row>");
				$data_row = [
			        "identity" => $this->Parse_Data($data,"<PIN>","</PIN>"),
			        "datetime" => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
			    ];
			    $x = new Dami($data_row);
			    $x->save();
				$search_array = array_flip($nim);
				if (!array_key_exists($this->Parse_Data($data,"<PIN>","</PIN>"), $search_array)) {	
					if (array_key_exists($this->Parse_Data($data,"<PIN>","</PIN>"), $array_search)) {
						if ($this->Parse_Data($data,"<DateTime>","</DateTime>") >= Carbon::parse($time)->subMinutes(15) && $this->Parse_Data($data,"<DateTime>","</DateTime>") <= Carbon::parse($time)->addMinutes(15)) {
							array_push($nim, $this->Parse_Data($data,"<PIN>","</PIN>"));
					    	array_push($datetime, $this->Parse_Data($data,"<DateTime>","</DateTime>"));
					   	}
					}
				}
			}

			$absensi = [];
			$absensiDosen = [];
			$tidakhadir = [];
			$tidakhadirDosen = [];

			$lastPertemuan = Presensikelas::select('pertemuan')
											->where('kelasmk_id', $kelasmk_id)
											->orderBy('pertemuan', 'desc')
											->first();

			foreach ( array_diff($listPeserta, $nim) as $notAttendUser) {
				if ( $notAttendUser == $dosen_id ) {
					$this->cleardata($ip_address);
					return 'OPERATION ABORTED';
				}
			}
			foreach ( array_diff($listPeserta, $nim) as $notAttendUser) {
				if( $lastPertemuan ) {
					if ( $notAttendUser != $dosen_id ) {
					    $tidakhadir[] = [
					        'nim'  			=> $notAttendUser,
					        'waktu'			=> '',
					        'keterangan'    => '4',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> $lastPertemuan->pertemuan + 1,
					    ];
					}
				}
				if( !$lastPertemuan ) {
					if ( $notAttendUser != $dosen_id ) {
					    $tidakhadir[] = [
					        'nim'  			=> $notAttendUser,
					        'waktu'			=> '',
					        'keterangan'    => '4',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> '1',
					    ];
					}
				}
			}
			\DB::table('presensikelas')->insert($tidakhadir);
			\DB::table('presensidosen')->insert($tidakhadirDosen);

			foreach ($nim as $key => $attendedUser) {
				if( $lastPertemuan ) {
					if ( $attendedUser == $dosen_id ) {
					    $absensiDosen[] = [
					        'nik'  			=> $attendedUser,
					        'waktu'			=> $datetime[$key],
					        'keterangan'    => '1',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> $lastPertemuan->pertemuan + 1,
					    ];
			        }
					if ( $attendedUser != $dosen_id ) {
					    $absensi[] = [
					        'nim'  			=> $attendedUser,
					        'waktu'			=> $datetime[$key],
					        'keterangan'    => '1',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> $lastPertemuan->pertemuan + 1,
					    ];
			        }	
				}
				if( !$lastPertemuan ) {
					if ( $attendedUser == $dosen_id ) {
					    $absensiDosen[] = [
					        'nik'  			=> $attendedUser,
					        'waktu'			=> $datetime[$key],
					        'keterangan'    => '1',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> '1',
					    ];
			        }	
					if ( $attendedUser != $dosen_id ) {
					    $absensi[] = [
					        'nim'  			=> $attendedUser,
					        'waktu'			=> $datetime[$key],
					        'keterangan'    => '1',
					        'kelasmk_id'    => $kelasmk_id,
					        'pertemuan'    	=> '1',
					    ];
			        }	
				}
			}
			\DB::table('presensikelas')->insert($absensi);
			\DB::table('presensidosen')->insert($absensiDosen);


			$this->cleardata($ip_address);
			return 'BERHASIL';
        }


        
	}











	/**
	 * Grab data from the fingerprint machine from the last time with additional filter
	 * @param  String $ip_address
	 * @return String             Save filtered data to local database
	 */
	public function labfingerprint($ip_address = '192.168.1.201')
	{
		$newBuffer = $this->connection($ip_address);
		$for_limit = count($this->connection($ip_address));
        $hari = $this->datefilter();
		$datetime = Carbon::now();
        $semester = $datetime->format('Y') . ($datetime->month > 6 ? '1' : '2');

        $ruang = Ipfingerprint::select('ruang_id')
        		->where('ip_address', $ip_address)
        		->first();

        $kelaspengganti = \DB::table('kelaspenggantilab')
        				  ->join('jadwal_kelas', 'kelaspenggantilab.jadwalkelas_id', '=', 'jadwal_kelas.id_kelas')
        				  ->select('kelaspenggantilab.id', 'kelaspenggantilab.jadwalkelas_id', 'kelaspenggantilab.waktu', 'kelaspenggantilab.hari_id', 'kelaspenggantilab.status', 'jadwal_kelas.dosen_id')
        				  ->where('kelaspenggantilab.waktu', '<=', Carbon::now())
        				  ->where('kelaspenggantilab.ruang_id', $ruang->ruang_id)
        				  ->where('kelaspenggantilab.hari_id', $hari)
        				  ->where('kelaspenggantilab.status', '1')
        				  ->first();

        if ($kelaspengganti) {

	    	$timeStart = $kelaspengganti->waktu;
			$nim = array();
			$datetime = array();
	 		$jadwal_kelas_id = $kelaspengganti->jadwalkelas_id;
	 		$kelaspenggantilab_id = $kelaspengganti->id;
	 		$dosen_id = $kelaspengganti->dosen_id;

			$dpmk = Detailkelas::select('nim')->where('id_jadwal_kelas', $jadwal_kelas_id)->get();
			foreach ($dpmk as $peserta) {
				$listPeserta[] = $peserta->nim;
			}
			$asdos = Asistenkelas::select('nim')->where('id_kelas', $jadwal_kelas_id)->get();
			foreach ($asdos as $peserta) {
				$listPeserta[] = $peserta->nim;
				$listAsdos[] = $peserta->nim;
			}
			$listPeserta[] = $kelaspengganti->dosen_id;
			$array_search = array_flip($listPeserta);
	        $lastTime = Dami::orderBy('datetime', 'desc')->first();
	        for($a=1; $a < $for_limit-1; $a++) {
	        	$data = $this->Parse_Data($newBuffer[$a],"<Row>","</Row>");
				$data_row = [
		            "identity" => $this->Parse_Data($data,"<PIN>","</PIN>"),
		            "datetime" => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
		        ];
		        $x = new Dami($data_row);
		        $x->save();
				$search_array = array_flip($nim);
				if (!array_key_exists($this->Parse_Data($data,"<PIN>","</PIN>"), $search_array)) {
					if (array_key_exists($this->Parse_Data($data,"<PIN>","</PIN>"), $array_search)) {
						if ($this->Parse_Data($data,"<DateTime>","</DateTime>") >= Carbon::parse($timeStart)->subMinutes(15) && $this->Parse_Data($data,"<DateTime>","</DateTime>") <= Carbon::parse($timeStart)->addMinutes(15)) {
							array_push($nim, $this->Parse_Data($data,"<PIN>","</PIN>"));
					    	array_push($datetime, $this->Parse_Data($data,"<DateTime>","</DateTime>"));
					   	}
					}
				}
	        }
			$absensi = [];
			$absensiDosen = [];
			$absensiAsdos = [];
			$tidakhadir = [];
			$tidakhadirDosen = [];
			$tidakhadirAsdos = [];


			$lastPertemuan = Presensidosenlab::select('pertemuan')
											   ->where('jadwal_kelas_id', $jadwal_kelas_id)
											   ->orderBy('pertemuan', 'desc')
											   ->first();

			foreach ( array_diff($listPeserta, $nim) as $notAttendUser) {
				if ( $notAttendUser == $dosen_id ) {
					$this->cleardata($ip_address);
					return 'OPERATION ABORTED';
				}
			}

			foreach ( array_diff($listPeserta, $nim) as $notAttendUser) {
				if( !$lastPertemuan ) {
					if ( $notAttendUser != $dosen_id && !in_array($notAttendUser, $listAsdos)) {
					    $tidakhadir[] = [
					        'nim'  			  => $notAttendUser,
					        'waktu'			  => '',
					        'keterangan'      => '4',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
					}
					if ( in_array($notAttendUser, $listAsdos)) {
					    $tidakhadir[] = [
					        'nim'  			  => $notAttendUser,
					        'waktu'			  => '',
					        'keterangan'      => '4',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
					}
				}
				if( $lastPertemuan ) {
					if ( $notAttendUser != $dosen_id && !in_array($notAttendUser, $listAsdos)) {
					    $tidakhadir[] = [
					        'nim'  			  => $notAttendUser,
					        'waktu'			  => '',
					        'keterangan'      => '4',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => $lastPertemuan->pertemuan + 1,
					    ];
					}
					if ( in_array($notAttendUser, $listAsdos ) ) { 
					    $tidakhadirAsdos[] = [
					        'nim'  			  => $notAttendUser,
					        'waktu'			  => '',
					        'keterangan'      => '4',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => $lastPertemuan->pertemuan + 1,
					    ];
					}
				}
	    	}
	    	\DB::table('presensilab')->insert($tidakhadir);
	    	\DB::table('presensiasdos')->insert($tidakhadirAsdos);

			foreach ($nim as $key => $attendedUser) {
				if (!$lastPertemuan) {
					if ( (int)$attendedUser == $dosen_id ) {
					    $absensiDosen[] = [
					        'nik'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
			        }
					if ( $attendedUser != $dosen_id && !in_array($attendedUser, $listAsdos) ) {
					    $absensi[] = [
					        'nim'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
			        }
			        if(in_array($attendedUser, $listAsdos)) {
					    $absensiAsdos[] = [
					        'nim'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
			        }
			    }
				if ($lastPertemuan) {
					if ( (int)$attendedUser == $dosen_id ) {
					    $absensiDosen[] = [
					        'nik'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => $lastPertemuan->pertemuan + 1,
					    ];
			        }
					if ( $attendedUser != $dosen_id && !in_array($attendedUser, $listAsdos) ) {
					    $absensi[] = [
					        'nim'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan' 	  => $lastPertemuan->pertemuan + 1,
					    ];
			        }
			        if(in_array($attendedUser, $listAsdos)) {
					    $absensiAsdos[] = [
					        'nim'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan' 	  => $lastPertemuan->pertemuan + 1,
					    ];
			        }
			    }
		    }
		    \DB::table('presensilab')->insert($absensi);
		    \DB::table('presensiasdos')->insert($absensiAsdos);
			\DB::table('presensidosenlab')->insert($absensiDosen);

			$updateStatusKP = Kelaspenggantilab::find($kelaspenggantilab_id);
			$updateStatusKP->status = '0';
			$updateStatusKP->save();

			$this->cleardata($ip_address);

			return 'BERHASIL';
        } else {
			$data = Jadwalkelas::select('id_kelas', 'time_start', 'time_end', 'ruang_id', 'dosen_id')
	        		->where('time_start', '<=', Carbon::now())
	        		->where('hari_id', $hari)
	        		->where('ruang_id', $ruang->ruang_id)
	        		->orderBy('time_start', 'desc')
	        		->where('semester', $semester)
	        		->first();
	    	$timeStart = $data->time_start;
	       	$time = $data->waktu;
			$nim = array();
			$datetime = array();
	 		$jadwal_kelas_id = $data->id_kelas;
	 		$dosen_id = $data->dosen_id;

			$dpmk = Detailkelas::select('nim')->where('id_jadwal_kelas', $data->id_kelas)->get();
			foreach ($dpmk as $peserta) {
				$listPeserta[] = $peserta->nim;
			}
			$asdos = Asistenkelas::select('nim')->where('id_kelas', $data->id_kelas)->get();
			foreach ($asdos as $peserta) {
				$listPeserta[] = $peserta->nim;
				$listAsdos[] = $peserta->nim;
			}
			$listPeserta[] = $data->dosen_id;
			$array_search = array_flip($listPeserta);
	        $lastTime = Dami::orderBy('datetime', 'desc')->first();
	        for($a=1; $a < $for_limit-1; $a++) {
	        	$data = $this->Parse_Data($newBuffer[$a],"<Row>","</Row>");
				$data_row = [
		            "identity" => $this->Parse_Data($data,"<PIN>","</PIN>"),
		            "datetime" => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
		        ];
		        $x = new Dami($data_row);
		        $x->save();
				$search_array = array_flip($nim);
				if (!array_key_exists($this->Parse_Data($data,"<PIN>","</PIN>"), $search_array)) {
					if (array_key_exists($this->Parse_Data($data,"<PIN>","</PIN>"), $array_search)) {
						if ($this->Parse_Data($data,"<DateTime>","</DateTime>") >= Carbon::parse($timeStart)->subMinutes(15) && $this->Parse_Data($data,"<DateTime>","</DateTime>") <= Carbon::parse($timeStart)->addMinutes(15)) {
							array_push($nim, $this->Parse_Data($data,"<PIN>","</PIN>"));
					    	array_push($datetime, $this->Parse_Data($data,"<DateTime>","</DateTime>"));
					   	}
					}
				}
	        }
			$absensi = [];
			$absensiDosen = [];
			$absensiAsdos = [];
			$tidakhadir = [];
			$tidakhadirDosen = [];
			$tidakhadirAsdos = [];


			$lastPertemuan = Presensidosenlab::select('pertemuan')
											   ->where('jadwal_kelas_id', $jadwal_kelas_id)
											   ->orderBy('pertemuan', 'desc')
											   ->first();

			foreach ( array_diff($listPeserta, $nim) as $notAttendUser) {
				if ( $notAttendUser == $dosen_id ) {
					$this->cleardata($ip_address);
					return 'OPERATION ABORTED';
				}
			}

			foreach ( array_diff($listPeserta, $nim) as $notAttendUser) {
				if( !$lastPertemuan ) {
					if ( $notAttendUser != $dosen_id && !in_array($notAttendUser, $listAsdos)) {
					    $tidakhadir[] = [
					        'nim'  			  => $notAttendUser,
					        'waktu'			  => '',
					        'keterangan'      => '4',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
					}
					if ( in_array($notAttendUser, $listAsdos)) {
					    $tidakhadir[] = [
					        'nim'  			  => $notAttendUser,
					        'waktu'			  => '',
					        'keterangan'      => '4',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
					}
				}
				if( $lastPertemuan ) {
					if ( $notAttendUser != $dosen_id && !in_array($notAttendUser, $listAsdos)) {
					    $tidakhadir[] = [
					        'nim'  			  => $notAttendUser,
					        'waktu'			  => '',
					        'keterangan'      => '4',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => $lastPertemuan->pertemuan + 1,
					    ];
					}
					if ( in_array($notAttendUser, $listAsdos ) ) { 
					    $tidakhadirAsdos[] = [
					        'nim'  			  => $notAttendUser,
					        'waktu'			  => '',
					        'keterangan'      => '4',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => $lastPertemuan->pertemuan + 1,
					    ];
					}
				}
	    	}
	    	\DB::table('presensilab')->insert($tidakhadir);
	    	\DB::table('presensiasdos')->insert($tidakhadirAsdos);

			foreach ($nim as $key => $attendedUser) {
				if (!$lastPertemuan) {
					if ( (int)$attendedUser == $dosen_id ) {
					    $absensiDosen[] = [
					        'nik'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
			        }
					if ( $attendedUser != $dosen_id && !in_array($attendedUser, $listAsdos) ) {
					    $absensi[] = [
					        'nim'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
			        }
			        if(in_array($attendedUser, $listAsdos)) {
					    $absensiAsdos[] = [
					        'nim'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => '1',
					    ];
			        }
			    }
				if ($lastPertemuan) {
					if ( (int)$attendedUser == $dosen_id ) {
					    $absensiDosen[] = [
					        'nik'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan'    	  => $lastPertemuan->pertemuan + 1,
					    ];
			        }
					if ( $attendedUser != $dosen_id && !in_array($attendedUser, $listAsdos) ) {
					    $absensi[] = [
					        'nim'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan' 	  => $lastPertemuan->pertemuan + 1,
					    ];
			        }
			        if(in_array($attendedUser, $listAsdos)) {
					    $absensiAsdos[] = [
					        'nim'  			  => $attendedUser,
					        'waktu'			  => $datetime[$key],
					        'keterangan'      => '1',
					        'jadwal_kelas_id' => $jadwal_kelas_id,
					        'pertemuan' 	  => $lastPertemuan->pertemuan + 1,
					    ];
			        }
			    }
		    }
		    \DB::table('presensilab')->insert($absensi);
		    \DB::table('presensiasdos')->insert($absensiAsdos);
			\DB::table('presensidosenlab')->insert($absensiDosen);


			$this->cleardata($ip_address);

			return 'BERHASIL';
        }

        
	}	

	public function Parse_Data($data,$p1,$p2) {
		$data = " ".$data;
		$hasil = "";
		$awal = strpos($data,$p1);
		if($awal != ""){
			$akhir = strpos(strstr($data, $p1), $p2);
			if($akhir != "") {
				$hasil = substr($data, $awal + strlen($p1), $akhir - strlen($p1));
			}
		}
		return $hasil;	
	}

	public function connection($ip_address)
	{
    	ini_set('max_execution_time', 10000);
		$Connect = fsockopen($ip_address, "80", $errno, $errstr, 1);
		if($Connect) {
			$soap_request = "<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".'0'."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
			$newLine="\r\n";
			fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
			fputs($Connect, "Content-Type: text/xml" . $newLine);
			fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine . $newLine);
			fputs($Connect, $soap_request . $newLine);
			$buffer = "";
			while($Response = fgets($Connect, 1024)) {
				$buffer = $buffer . $Response;
			}
		}

		$buffer = $this->Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
		$buffer = explode("\r\n", $buffer);
		return $buffer;
	}

	public function cleardata($ip_address)
	{
		ini_set('max_execution_time', 10000);
		$Connect = fsockopen($ip_address, "80", $errno, $errstr, 1);
		if($Connect){
			$soap_request="<ClearData><ArgComKey xsi:type=\"xsd:integer\">" . '0' . "</ArgComKey><Arg><Value xsi:type=\"xsd:integer\">3</Value></Arg></ClearData>";
			$newLine="\r\n";
			fputs($Connect, "POST /iWsService HTTP/1.0" . $newLine);
		    fputs($Connect, "Content-Type: text/xml" . $newLine);
		    fputs($Connect, "Content-Length: " . strlen($soap_request) . $newLine.$newLine);
		    fputs($Connect, $soap_request . $newLine);
			$buffer = "";
			while($Response = fgets($Connect, 1024)){
				$buffer = $buffer . $Response;
			}
		}
		$buffer = $this->Parse_Data($buffer, "<GetAttLogResponse>", "</GetAttLogResponse>");
		return $buffer;
	}

	public function datefilter()
	{
		$datetime = Carbon::now();
        if ($datetime->format('l') === 'Monday') {
            return $hari = '1';
        } else if ($datetime->format('l') === 'Tuesday') {
            return $hari = '2';
        } else if ($datetime->format('l') === 'Wednesday') {
            return $hari = '3';
        } else if ($datetime->format('l') === 'Thursday') {
            return $hari = '4';
        } else if ($datetime->format('l') === 'Friday') {
            return $hari = '5';
        } else if ($datetime->format('l') === 'Saturday') {
            return $hari = '6';
        } else if ($datetime->format('l') === 'Sunday') {
            return $hari = '7';
        }
	}


}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Dami;
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
	            "id" => $this->Parse_Data($data,"<PIN>","</PIN>"),
	            "datetime" => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
	            "verified" => $this->Parse_Data($data,"<Verified>","</Verified>"),
	            "status" => $this->Parse_Data($data,"<Status>","</Status>")
	        ];
	        $x = new Dami($data_row);
	        $x->save();
		}
		return redirect('compare');

	}

	public function cobaupdatedata()
	{
		$newBuffer = $this->connection();
		$for_limit = count($this->connection());
		for($a=1;$a<$for_limit-1;$a++) {
        	$data = $this->Parse_Data($newBuffer[$a],"<Row>","</Row>");
        	$lastTime = Dami::orderBy('datetime', 'desc')->first();
			if( strtotime( $this->Parse_Data($data,"<DateTime>","</DateTime>")) > strtotime($lastTime->datetime)) {
		        $data_row = [
		            "id" => $this->Parse_Data($data,"<PIN>","</PIN>"),
		            "datetime" => $this->Parse_Data($data,"<DateTime>","</DateTime>"),
		            "verified" => $this->Parse_Data($data,"<Verified>","</Verified>"),
		            "status" => $this->Parse_Data($data,"<Status>","</Status>")
		        ];
		        $x = new Dami($data_row);
		        $x->save();
    		}
		}
    	return redirect('presensi');
	}


	public function Parse_Data($data,$p1,$p2) {
		$data=" ".$data;
		$hasil="";
		$awal=strpos($data,$p1);
		if($awal!=""){
			$akhir=strpos(strstr($data,$p1),$p2);
			if($akhir!=""){
				$hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
			}
		}
		return $hasil;	
	}

	public function connection()
	{
    	ini_set('max_execution_time', 1000);
		$Connect = fsockopen('192.168.1.201', "80", $errno, $errstr, 1);
		if($Connect) {
			$soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".'0'."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
			$newLine="\r\n";
			fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
			fputs($Connect, "Content-Type: text/xml".$newLine);
			fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
			fputs($Connect, $soap_request.$newLine);
			$buffer="";
			while($Response=fgets($Connect, 1024)){
				$buffer=$buffer.$Response;
			}
		}

		$buffer= $this->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
		$buffer= explode("\r\n",$buffer);
		return $buffer;
	}


}
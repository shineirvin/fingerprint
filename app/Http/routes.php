<?php

Route::get('fingerindex', function () {
    return view('fingerprint.index');
});

Route::get('fingerprint', function () {
    return view('fingerprint.coba');
});

Route::get('cobatarikdata', 'FingerprintController@cobatarikdata');
Route::get('cobaupdatedata', 'FingerprintController@cobaupdatedata');

Route::get('tarikdata', function () {
    return view('fingerprint.tarik-data');
});

Route::get('cleardata', function () {
    return view('fingerprint.clear-data');
});

Route::get('uploadnama', function () {
    return view('fingerprint.upload-nama');
});

Route::group(['middleware' => 'web'], function () {
	Route::auth();

	Route::get('/', ['middleware' => 'guest', function() {
	    return view('auth.login');
	}]);

	Route::get('register', function () {
	    return view('auth.register');
	});


	Route::get('presensi', 'PresensiController@index');
	Route::get('getDataJadwalDosen', 'PresensiController@getDataJadwalDosen');
	Route::get('presensi/{id}', 'PresensiController@validasi');
	Route::get('getDataPresensiMahasiswa/{id}', 'PresensiController@getDataPresensiMahasiswa');


//-------------------------------------------------MASTERTABLE----------------------------------------------------//
	Route::get('matakuliahDataView', 'MasterController@index_matakuliah');
	Route::get('getDatamatakuliah', 'MasterController@getDataMatakuliah');
	Route::get('matakuliahData', 'MasterController@registermatakuliah');
	Route::post('matakuliahData', 'MasterController@store_matakuliah');
	Route::get('matakuliahData/{id}/edit', 'MasterController@edit_matakuliah');
	Route::patch('matakuliahData/{id}', 'MasterController@update_matakuliah');
	Route::get('matakuliahDataDelete/{id}', 'MasterController@destroy_matakuliah');

	Route::get('ruangDataView', 'MasterController@index_ruang');
	Route::get('getDataruang', 'MasterController@getDataruang');
	Route::get('ruangData', 'MasterController@registerruang');
	Route::post('ruangData', 'MasterController@store_ruang');
	Route::get('ruangData/{id}/edit', 'MasterController@edit_ruang');
	Route::patch('ruangData/{id}', 'MasterController@update_ruang');
	Route::get('ruangDataDelete/{id}', 'MasterController@destroy_ruang');

	Route::get('jenisruangDataView', 'MasterController@index_jenisruang');
	Route::get('getDatajenisruang', 'MasterController@getDatajenisruang');
	Route::get('jenisruangData', 'MasterController@registerjenisruang');
	Route::post('jenisruangData', 'MasterController@store_jenisruang');
	Route::get('jenisruangData/{id}/edit', 'MasterController@edit_jenisruang');
	Route::patch('jenisruangData/{id}', 'MasterController@update_jenisruang');
	Route::get('jenisruangDataDelete/{id}', 'MasterController@destroy_jenisruang');


//----------------------------------------------ENDOFMASTERTABLE---------------------------------------------------//


	Route::get('compare', function () {
		$jmk = App\Kelasmk::select('waktu', 'matakuliah_id')->orderBy('id', 'desc')->first();
		$collections = $jmk->matakuliah;
		foreach($collections as $collection) {
			$matakuliah = $collection->sks;
		}

	    $start = Carbon\Carbon::parse($jmk->waktu);
	    $end = $start->addHours($matakuliah);
	    $end = Carbon\Carbon::parse('21:00:00'); // test only

        $result = App\Dami::select('datetime','id')->where('datetime', '>=', $start->toDateTimeString())->where('datetime', '<=', $end->toDateTimeString())->get();
        return $result;

	});



	Route::get('practice', function () {
	    return view('practice.xmltojson')->with('tests', '');
	});
	Route::post('practice', 'ArticlesController@practice');

	Route::controller('datatables', 'TestController', [
	    'anyData'  => 'datatables.data',
	    'getIndex' => 'datatables',
	]);

	Route::get('index', 'TestController@testo');

    Route::get('/home', 'HomeController@index');

    Route::resource('articles', 'ArticlesController');

    Route::get('tags/{tag}', 'TagsController@show');



Route::get('test', function(){

session_start();

$fb = new Facebook\Facebook([
  'app_id' => '1684736991757958',
  'app_secret' => 'bcb72c777c2255cbf88c2d55c7347523',
  'default_graph_version' => 'v2.5',
  'default_access_token' => 'APP-ID|APP-SECRET'
  ]);
$helper = $fb->getRedirectLoginHelper();
$permissions = ['email']; // optional
	
try {
	if (isset($_SESSION['facebook_access_token'])) {
		$accessToken = $_SESSION['facebook_access_token'];
	} else {
  		$accessToken = $helper->getAccessToken();
	}
} catch(Facebook\Exceptions\FacebookResponseException $e) {
 	// When Graph returns an error
 	echo 'Graph returned an error: ' . $e->getMessage();
  	exit;
} catch(Facebook\Exceptions\FacebookSDKException $e) {
 	// When validation fails or other local issues
	echo 'Facebook SDK returned an error: ' . $e->getMessage();
  	exit;
 }
if (isset($accessToken)) {
	if (isset($_SESSION['facebook_access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	} else {
		// getting short-lived access token
		$_SESSION['facebook_access_token'] = (string) $accessToken;
	  	// OAuth 2.0 client handler
		$oAuth2Client = $fb->getOAuth2Client();
		// Exchanges a short-lived access token for a long-lived one
		$longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
		$_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
		// setting default access token to be used in script
		$fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
	}
	// redirect the user back to the same page if it has "code" GET variable
	if (isset($_GET['code'])) {
		header('Location: ./');
	}
	// getting basic info about user
	try {
		$profile_request = $fb->get('/me?fields=name,first_name,last_name,email');
		$profile = $profile_request->getGraphNode()->asArray();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		session_destroy();
		// redirecting user back to app login page
		header("Location: ./");
		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
	}
	
	// printing $profile array on the screen which holds the basic info about user
	print_r($profile);
  	// Now you can redirect to another page and use the access token from $_SESSION['facebook_access_token']
} else {
	// replace your website URL same as added in the developers.facebook.com/apps e.g. if you used http instead of https and you used non-www version or www version of your website then you must add the same here
	$loginUrl = $helper->getLoginUrl('http://localhost:8000/material', $permissions);
	return view('auth.login')->with('loginurl', $loginUrl);
	echo '<a href="' . $loginUrl . '">Log in with Facebook!</a>';
}


});



});

Route::get('material', function(){
$fb = new Facebook\Facebook([
  'app_id' => '1684736991757958',
  'app_secret' => 'bcb72c777c2255cbf88c2d55c7347523',
  'default_graph_version' => 'v2.4',
  ]);

$helper = $fb->getRedirectLoginHelper();
try {
  $accessToken = $helper->getAccessToken();
} catch(Facebook\Exceptions\FacebookResponseException $e) {
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
}  catch(Facebook\Exceptions\FacebookSDKException $e) {
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (isset($accessToken)) {
  // Logged in!
  $_SESSION['facebook_access_token'] = (string) $accessToken;

  // Now you can redirect to another page and use the
  // access token from $_SESSION['facebook_access_token']
}

	return view('materialadmin.formlayout');
});


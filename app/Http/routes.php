<?php

Route::group(['middleware' => 'web'], function () {
	Route::auth();

	Route::get('/', ['middleware' => 'guest', function() {
		return view('auth.login');
	}]);

	Route::get('labfingerprint', 'FingerprintController@labfingerprint');
	
	Route::get('register', function () {
	    return view('auth.register');
	});
	Route::get('registeradmin', 'AdminController@registeradmin');
	Route::get('registerdosen', 'AdminController@registerdosen');
	Route::get('registermahasiswa', 'AdminController@registermahasiswa');


	Route::post('studentvalidate', 'PresensiController@studentvalidate');


	Route::get('presensi', 'PresensiController@index');
	Route::get('getDataJadwalDosen', 'PresensiController@getDataJadwalDosen');
	Route::get('presensi/{id}/{encounter}', 'PresensiController@validasi');
	Route::get('getDataPresensiMahasiswa/{id}/{encounter}', 'PresensiController@getDataPresensiMahasiswa');

	Route::get('presensilab', 'PresensiLabController@index');
	Route::get('getDataJadwalDosenLab', 'PresensiLabController@getDataJadwalDosen');
	Route::get('presensilab/{id}/{encounter}', 'PresensiLabController@validasi');
	Route::get('getDataPresensiMahasiswaLab/{id}/{encounter}', 'PresensiLabController@getDataPresensiMahasiswa');

	Route::get('reportDosen', 'ReportController@indexDosen');
	Route::get('reportDosenData', 'ReportController@reportDosenData');

	Route::get('reportMahasiswa', 'ReportController@indexMahasiswa');
	Route::get('reportMahasiswaData', 'ReportController@reportMahasiswaData');

	Route::get('reportAdmin/{semester}', 'ReportController@indexAdmin');
	Route::get('reportAdminData/{semester}', 'ReportController@reportAdminData');

	Route::get('reportMhsAdmin/{semester}', 'ReportController@indexMhsAdmin');
	Route::get('reportMhsAdminData/{semester}', 'ReportController@reportMhsAdminData');





	Route::get('reportDosenLab', 'ReportLabController@indexDosen');
	Route::get('reportDosenLabData', 'ReportLabController@reportDosenData');

	Route::get('reportMahasiswaLab', 'ReportLabController@indexMahasiswa');
	Route::get('reportMahasiswaLabData', 'ReportLabController@reportMahasiswaData');

	Route::get('reportMahasiswaLab', 'ReportLabController@indexMahasiswa');
	Route::get('reportMahasiswaLabData', 'ReportLabController@reportMahasiswaData');

	Route::get('reportAsdos', 'ReportLabController@indexAsdos');
	Route::get('reportAsdosData', 'ReportLabController@reportAsdosData');

	Route::get('reportAdminLab/{semester}', 'ReportLabController@indexAdminLab');
	Route::get('reportAdminLabData/{semester}', 'ReportLabController@reportAdminLabData');

	Route::get('reportMhsLabAdmin/{semester}', 'ReportLabController@indexMhsLabAdmin');
	Route::get('reportMhsLabAdminData/{semester}', 'ReportLabController@reportMhsLabAdminData');




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

    Route::get('profile', 'HomeController@profile');
    Route::post('profile/picture', 'HomeController@profilepicture');
    Route::put('profile/changepassword', 'HomeController@changepassword');



    Route::get('changepassdosen', 'AdminController@changepassdosen_index');
    Route::get('changepassdosenData', 'AdminController@changepassdosenData');
    Route::get('getDosenData/{dosen_id}', 'AdminController@getDosenData');
    Route::post('newpassdosen', 'AdminController@newpassdosen');

    Route::get('changepassmahasiswa', 'AdminController@changepassmahasiswa_index');
    Route::get('changepassmahasiswaData', 'AdminController@changepassmahasiswaData');
    Route::get('getMahasiswaData/{mahasiswa_id}', 'AdminController@getMahasiswaData');
    Route::post('newpassmahasiswa', 'AdminController@newpassmahasiswa');

    Route::get('changepassadmin', 'AdminController@changepassadmin_index');
    Route::get('changepassadminData', 'AdminController@changepassadminData');
    Route::get('getAdminData/{admin_id}', 'AdminController@getAdminData');
    Route::post('newpassadmin', 'AdminController@newpassadmin');

    Route::get('adminvalidation/{semester}', 'AdminController@validate_index');
	Route::get('getDataJadwalDosenAll/{semester}', 'AdminController@getDataJadwalDosenAll');


	Route::get('kelaspenggantiDataView', 'AdminController@kelaspengganti_index');
	Route::get('getDataKelasPengganti', 'AdminController@getDataKelasPengganti');
	Route::get('kelaspenggantiData/{id}', 'AdminController@registerkelaspengganti');
	Route::post('kelaspenggantiData', 'AdminController@store_kelaspengganti');
	Route::get('kelaspenggantiData/{id}/edit', 'AdminController@edit_kelaspengganti');
	Route::patch('kelaspenggantiData/{id}', 'AdminController@update_kelaspengganti');
	Route::get('kelaspenggantiDataDelete/{id}', 'AdminController@destroy_kelaspengganti');
	Route::get('listkelasmk', 'AdminController@listkelasmk');
	Route::get('getDataListKelasmk', 'AdminController@getDataListKelasmk');


	Route::get('reportBulanan', 'AdminController@reportBulanan_index');
	Route::get('reportBulanan/{dateS}/{dateE}', 'AdminController@reportBulananDetail_index');
	Route::get('getDataReportBulanan/{dateS}/{dateE}', 'AdminController@getDataReportBulanan');

	Route::get('monthlyreportexcel/{dateS}/{dateE}', 'AdminController@monthlyreportexcel');







	Route::get('index', 'HomeController@index');





});
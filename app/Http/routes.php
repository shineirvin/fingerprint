<?php

Route::group(['middleware' => 'web'], function () {
	Route::auth();

	Route::get('/', ['middleware' => 'guest', function() {
		return view('auth.login');
	}]);

	Route::get('cobaupdatedata', 'FingerprintController@cobaupdatedata');

	Route::get('labfingerprint', 'FingerprintController@labfingerprint');
	
	Route::get('registeradmin', 'AdminController@registeradmin');
	Route::get('registerdosen', 'AdminController@registerdosen');
	Route::get('registermahasiswa', 'AdminController@registermahasiswa');

	Route::post('register', 'AdminController@store');


	Route::post('studentvalidate', 'PresensiController@studentvalidate');


	Route::get('presensi/{semester}', 'PresensiController@index');
	Route::get('getDataJadwalDosen/{semester}', 'PresensiController@getDataJadwalDosen');
	Route::get('presensi/{id}/{encounter}', 'PresensiController@validasi');
	Route::get('getDataPresensiMahasiswa/{id}/{encounter}', 'PresensiController@getDataPresensiMahasiswa');

	Route::get('presensilab/{semester}', 'PresensiLabController@index');
	Route::get('getDataJadwalDosenLab/{semester}', 'PresensiLabController@getDataJadwalDosen');
	Route::get('presensilab/{id}/{encounter}', 'PresensiLabController@validasi');
	Route::get('getDataPresensiMahasiswaLab/{id}/{encounter}', 'PresensiLabController@getDataPresensiMahasiswa');



	/**
	 * All report kelas
	 */
	Route::get('reportDosen/{semester}', 'ReportController@indexDosen');
	Route::get('reportDosenData/{semester}', 'ReportController@reportDosenData');

	Route::get('reportMahasiswa/{semester}', 'ReportController@indexMahasiswa');
	Route::get('reportMahasiswaData/{semester}', 'ReportController@reportMahasiswaData');

	Route::get('reportAdmin/{semester}', 'ReportController@indexAdmin');
	Route::get('reportAdminData/{semester}', 'ReportController@reportAdminData');

	Route::get('reportMhsAdmin/{semester}', 'ReportController@indexMhsAdmin');
	Route::get('reportMhsAdminData/{semester}', 'ReportController@reportMhsAdminData');

	Route::get('reportMhsAdmin/{semester}', 'ReportController@indexMhsAdmin');
	Route::get('reportMhsAdminData/{semester}', 'ReportController@reportMhsAdminData');






	/** 
	 * REPORT DETAIL UNTUK DOSEN ( KELAS DAN LAB )
	 */
	Route::get('reportDosenDetail/{semester}/{matakuliah}/{kelas}', 'ReportController@reportDosenDetail');
	Route::get('reportDosenDetailData/{semester}/{matakuliah}/{kelas}', 'ReportController@reportDosenDetailData');

	Route::get('reportDosenDetailLab/{semester}/{matakuliah}/{kelas}', 'ReportLabController@reportDosenDetailLab');
	Route::get('reportDosenDetailLabData/{semester}/{matakuliah}/{kelas}', 'ReportLabController@reportDosenDetailLabData');


	/** 
	 * REPORT DETAIL UNTUK ADMIN ( KELAS DAN LAB )
	 */
	Route::get('reportAdminDosenDetail/{semester}/{dosen}/{matakuliah}/{kelas}', 'ReportController@reportAdminDosenDetail');
	Route::get('reportAdminDosenDetailData/{semester}/{dosen}/{matakuliah}/{kelas}', 'ReportController@reportAdminDosenDetailData');

	Route::get('reportAdminDosenDetailLab/{semester}/{dosen}/{matakuliah}/{kelas}', 'ReportLabController@reportAdminDosenDetailLab');
	Route::get('reportAdminDosenDetailLabData/{semester}/{dosen}/{matakuliah}/{kelas}', 'ReportLabController@reportAdminDosenDetailLabData');







	/**
	 * All report lab
	 */
	Route::get('reportDosenLab/{semester}', 'ReportLabController@indexDosen');
	Route::get('reportDosenLabData/{semester}', 'ReportLabController@reportDosenData');

	Route::get('reportMahasiswaLab/{semester}', 'ReportLabController@indexMahasiswa');
	Route::get('reportMahasiswaLabData/{semester}', 'ReportLabController@reportMahasiswaData');

	Route::get('reportAsdos/{semester}', 'ReportLabController@indexAsdos');
	Route::get('reportAsdosData/{semester}', 'ReportLabController@reportAsdosData');

	Route::get('reportAdminLab/{semester}', 'ReportLabController@indexAdminLab');
	Route::get('reportAdminLabData/{semester}', 'ReportLabController@reportAdminLabData');

	Route::get('reportMhsLabAdmin/{semester}', 'ReportLabController@indexMhsLabAdmin');
	Route::get('reportMhsLabAdminData/{semester}', 'ReportLabController@reportMhsLabAdminData');

	Route::get('reportAllAsdos/{semester}', 'ReportLabController@indexAllAsdos');
	Route::get('reportAllAsdosData/{semester}', 'ReportLabController@reportAllAsdosData');




	/**
	 * Master Table
	 */
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

    Route::get('adminvalidationLab/{semester}', 'AdminController@validateLab_index');
	Route::get('getDataJadwalDosenLabAll/{semester}', 'AdminController@getDataJadwalDosenLabAll');




	Route::get('kelaspenggantiDataView', 'AdminController@kelaspengganti_index');
	Route::get('getDataKelasPengganti', 'AdminController@getDataKelasPengganti');
	Route::get('kelaspenggantiData/{id}', 'AdminController@registerkelaspengganti');
	Route::post('kelaspenggantiData', 'AdminController@store_kelaspengganti');
	Route::get('kelaspenggantiData/{id}/edit', 'AdminController@edit_kelaspengganti');
	Route::patch('kelaspenggantiData/{id}', 'AdminController@update_kelaspengganti');
	Route::get('kelaspenggantiDataDelete/{id}', 'AdminController@destroy_kelaspengganti');
	Route::get('listkelasmk', 'AdminController@listkelasmk');
	Route::get('getDataListKelasmk', 'AdminController@getDataListKelasmk');

	Route::get('kelaspenggantiLabDataView', 'AdminController@kelaspenggantiLab_index');
	Route::get('getDataKelasPenggantiLab', 'AdminController@getDataKelasPenggantiLab');
	Route::get('kelaspenggantiLabData/{id}', 'AdminController@registerkelaspenggantiLab');
	Route::post('kelaspenggantiLabData', 'AdminController@store_kelaspenggantiLab');
	Route::get('kelaspenggantiLabData/{id}/edit', 'AdminController@edit_kelaspenggantiLab');
	Route::patch('kelaspenggantiLabData/{id}', 'AdminController@update_kelaspenggantiLab');
	Route::get('kelaspenggantiLabDataDelete/{id}', 'AdminController@destroy_kelaspenggantiLab');
	Route::get('listjadwalkelas', 'AdminController@listjadwalkelas');
	Route::get('getDataListJadwalkelas', 'AdminController@getDataListJadwalkelas');



	Route::get('reportBulanan', 'AdminController@reportBulanan_index');
	Route::get('reportBulanan/{dateS}/{dateE}', 'AdminController@reportBulananDetail_index');
	Route::get('getDataReportBulanan/{dateS}/{dateE}', 'AdminController@getDataReportBulanan');






	/** excel report */
	Route::get('monthlyreportexcel/{dateS}/{dateE}', 'AdminController@monthlyreportexcel');


	Route::get('reportDosenExcel/{semester}', 'ReportController@reportDosenExcel');
	Route::get('reportMahasiswaExcel/{semester}', 'ReportController@reportMahasiswaExcel');


	
	Route::get('reportDosenDetailExcel/{semester}/{matakuliah}/{kelas}', 'ReportController@reportDosenDetailExcel');
	Route::get('reportDosenDetailLabExcel/{semester}/{matakuliah}/{kelas}', 'ReportLabController@reportDosenDetailLabExcel');


	Route::get('reportAdminDosenDetailExcel/{semester}/{dosen}/{matakuliah}/{kelas}', 'ReportController@reportAdminDosenDetailExcel');
	Route::get('reportAdminDosenDetailLabExcel/{semester}/{dosen}/{matakuliah}/{kelas}', 'ReportLabController@reportAdminDosenDetailLabExcel');



	Route::get('reportDosenLabExcel/{semester}', 'ReportLabController@reportDosenLabExcel');
	Route::get('reportMahasiswaLabExcel/{semester}', 'ReportLabController@reportMahasiswaLabExcel');
	Route::get('reportAsdosExcel/{semester}', 'ReportLabController@reportAsdosExcel');
	


	Route::get('reportAllDosenExcel/{semester}', 'ReportController@reportAllDosenExcel');
	Route::get('reportAllMahasiswaExcel/{semester}', 'ReportController@reportAllMahasiswaExcel');

	Route::get('reportAllDosenLabExcel/{semester}', 'ReportLabController@reportAllDosenLabExcel');
	Route::get('reportAllMahasiswaLabExcel/{semester}', 'ReportLabController@reportAllMahasiswaLabExcel');
	Route::get('reportAllAsdosLabExcel/{semester}', 'ReportLabController@reportAllAsdosLabExcel');










	Route::get('index', 'HomeController@index');





});
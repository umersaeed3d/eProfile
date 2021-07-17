<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//

// Route::get('/file/{id}/archive', 'FilesController@archive');
Route::get('/file_archive', 'FilesController@archive');
Route::get('/file_archive_dir', 'FilesController@archivefromDir');
Route::get('/file_back', 'FilesController@archiveBack');
Route::get('/file_back_dir', 'FilesController@archiveBackDir');
Route::get('/file_delete', 'FilesController@delete');
Route::get('/file_delete_dir', 'FilesController@deleteDir');
Route::get('/download/{d}','FilesController@getdownload');
Route::get('/mergedownload/{d}','FilesController@getmergedownload');
Route::get('/file/new', 'FilesController@newForm');
Route::get('/getfiles', 'FilesController@filesAjax');
Route::get('/getdirectories', 'FilesController@directoriesAjax');
Route::get('/getsubfiles', 'FilesController@subFilesAjax');
Route::get('/getsubfilesall', 'FilesController@subFilesAjaxAll');
Route::get('/getsubfilesarchive', 'FilesController@subFilesAjaxArchive');
Route::get('/getdirectoriesdir', 'FilesController@directoriesAjaxArchive');
Route::get('/getdirectoriesdirall', 'FilesController@directoriesAjaxAll');
Route::get('/getsubdir', 'FilesController@GetSubDirectories');
Route::get('/allfiles', 'FilesController@allFiles');
Route::get('/getarchivefiles', 'FilesController@archivefilesAjax');
Route::get('/getfilesforupdate', 'FilesController@filesUpdateAjax');
Route::post('/file/new', 'FilesController@newSubmit');
Route::get('/file/directories', 'FilesController@allShow');
Route::get('/file', 'FilesController@allShowFiles');
Route::get('/file/update', 'FilesController@updateShow');
Route::post('/file/update', 'FilesController@updateFile');
Route::get('/file/{d}', 'FilesController@byFile');
Route::get('/archive', 'FilesController@byArchive');
Route::post('/files/merge', 'FilesController@mergeFiles');
Route::get('/title', 'FilesController@showTitle');
Route::post('/title', 'FilesController@updateTitle');
Route::get('/merged_files', 'FilesController@mergedFilesShow');
Route::get('/archived_merged_files', 'FilesController@mergedFilesShowArchive');
Route::get('/merged_archive', 'FilesController@mergedFileArchive');
Route::get('/merged_archive_back', 'FilesController@mergedFileArchiveBack');
Route::get('/merged/delete/{d}', 'FilesController@mergedFileDelete');
Route::get('/mail', 'FilesController@sendMail');
Route::get('/filecheck','FilesController@fileCheck');
Route::post('/copy_file','FilesController@CopyFileForm');
Route::post('/move_file','FilesController@MoveFileForm');


Route::get('/directory/new','DirectoryController@newForm');
Route::post('/directory/new','DirectoryController@newSubmit');
Route::get('/directory/all','DirectoryController@allShow');
Route::get('/directory/edit/{id}','DirectoryController@updateForm');
Route::post('/directory/update','DirectoryController@updateSubmit');
Route::get('/directory_delete','DirectoryController@destroy');

Route::get('/subdirectory/new','subDirectoryController@newForm');
Route::post('/subdirectory/new','subDirectoryController@newSubmit');
Route::get('/subdirectory/all','subDirectoryController@allShow');
Route::get('/subdirectory/edit/{id}','subDirectoryController@updateForm');
Route::post('/subdirectory/update','subDirectoryController@updateSubmit');
Route::get('/subdirectory_delete','subDirectoryController@destroy');
// Route::post('/main_dir_sequence','subdirectoryController@ChangeSequence');
Route::post('/main_dir_sequence','DirectoryController@ChangeSequence');


Route::get('/workstation/new','WorkstationController@showCreatePage');
Route::post('/workstation/new','WorkstationController@submitCreatePage');
Route::get('/workstation/all','WorkstationController@showAllPage');
Route::get('/workstation/edit/{id}','WorkstationController@EditPage');
Route::post('/workstation/update','WorkstationController@submitUpdatePage');
Route::get('/workstation/delete/{id}','WorkstationController@destroy');

Route::get('/user/new','userController@showCreatePage');
Route::post('/user/new','userController@submitCreatePage');
Route::get('/user/all','userController@showAllPage');
Route::get('/user/edit/{id}','userController@EditPage');
Route::post('/user/update','userController@submitUpdatePage');
Route::get('/user/delete/{id}','userController@destroy');


Route::get('/dashboard.{d}',function($d){
	return view('sub_dashboard')->with('name',$d);
});

// Route::get('/workstation/setting/{id}',function (){return view('workstation_setting');});
// Route::post('/workstation/setting','WorkstationController@setting');

Route::get('/login', function () {
    return view('login');
});
Route::post('/login','LoginController@login');
Route::get('/logout','LoginController@logout');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/dashboard/{id}/{name}', 'HomeController@showDashboard');

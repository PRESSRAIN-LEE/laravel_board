<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\BoardController;

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


//계층형게시판
//Route::resource('/board','BoardController');
//Route::resource('board', BoarsController::class);

Route::get('/board', [BoardController::class, 'index']);
Route::get('/board/search', [BoardController::class, 'search'])->name('board.index');	//검색

Route::get('/board/create', [BoardController::class, 'create']);		//글쓰기
Route::post('/board/store', [BoardController::class, 'store']);			//글 쓰기 저장

Route::get('/board/{id}/reply', [BoardController::class, 'reply']);				//답변
Route::post('/board/{id}/replyStore', [BoardController::class, 'replyStore']);	//답변 저장

Route::get('/board/{id}/show', [BoardController::class, 'show']);		//상세
Route::get('/board/{id}/viewCnt', [BoardController::class, 'viewCnt']);	//상세 - 조횟수 증가

Route::get('/board/{id}/edit', [BoardController::class, 'edit']);		//수정
Route::put('/board/{id}/update', [BoardController::class, 'update']);	//수정 저장

//Route::get('/board/{file_name}/download', [BoardController::class, 'download']);//->name('purchased.download');
Route::get('/board/{id}/{idx}/download', [BoardController::class, 'download']);
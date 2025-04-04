<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\Aws\S3Service;

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

Route::get('/', fn () => response()->json(['locale' => app()->getLocale(), 'environment' => app()->environment()]));
Route::get('/health-check', fn () => response()->make('OK'))->name('healthCheck');
# Route check IP access client

Route::get('/ip', function (Request $request) {
    $ip = $request->ip();
    # test connection rds postgres db dont need select data
    $results = DB::select('select 1');
    # create presigned url for s3 bucket
    $s3Service = new S3Service();
    $temporarySignedUrl = $s3Service->putObjectWithPresignedRequest('test.txt');
    return response()->json(['ip' => $ip, 'results_db' => $results, 'temporary_signed_url' => $temporarySignedUrl]);
});

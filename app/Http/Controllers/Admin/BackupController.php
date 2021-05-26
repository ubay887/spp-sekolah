<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

// use Illuminate\Support\Facades\Response;


class BackupController extends Controller
{
    public function index()
    {
        return view('setting.backup');
    }


    public function proses()
    {
        $getAllFiles = Storage::disk('public')->files('Laravel');
        $deleteAllFiles = Storage::disk('public')->delete($getAllFiles);

        $runBackup = Artisan::call('backup:run --only-db');

        $newBackupFile = Storage::disk('public')->files('Laravel');
        $getNewBackupFilename = explode('/', $newBackupFile[0]);
        
        $file = storage_path('app/public/Laravel/'.$getNewBackupFilename[1]);
        
        $headers = [
            'Content-Type' => 'application/zip',
        ];
        
        return response()->download($file, 'backup_db_'.$getNewBackupFilename[1], $headers);
    }
}

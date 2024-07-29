<?php

namespace Core\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    /**
     * Generate File Backup
     */
    public function fileBackupGenerate()
    {
        try {
            Artisan::call('backup:project');
            toastNotification('success', 'Backup generate successfully');
            return to_route('core.backup.files.list');
        } catch (\Exception $e) {
            toastNotification('error', 'Backup generate failed');
            return redirect()->back();
        }
    }
    /**
     * Will return file backups list
     */
    public function filesBackup()
    {
        return view('core::base.system.backup.file.list');
    }
    /**
     * Will download file backup
     */
    public function fileBackupDownload($filename)
    {
        $filePath = storage_path("app/backups/files/$filename");
        $headers = [
            'Content-Type' => 'application/zip',
        ];

        return response()->download($filePath, $filename, $headers);
    }
    /**
     * Will delete file backup
     */
    public function fileBackupDelete(Request $request)
    {

        try {
            $filePath = storage_path("app/backups/files/" . $request['filename']);
            if (File::exists($filePath)) {
                unlink($filePath);
            };
            toastNotification('success', 'Backup deleted  successfully');
            return to_route('core.backup.files.list');
        } catch (\Exception $e) {
            toastNotification('error', 'Backup delete failed');
            return redirect()->back();
        }
    }
    /**
     * Will return database backups list
     */
    public function databaseBackup()
    {
        return view('core::base.system.backup.database.list');
    }
    /**
     * Will generate database backup 
     */
    public function databaseBackupGenerate()
    {
        try {
            $returnValue = Artisan::call('backup:database');
            if ($returnValue !== 0) {
                toastNotification('error', 'Backup create failed');
                return redirect()->back();
            } else {
                toastNotification('success', 'Database backup file created successfully');
                return to_route('core.backup.database.list');
            }
        } catch (\Exception $e) {
            toastNotification('error', 'Backup create failed');
            return redirect()->back();
        } catch (\Error $e) {
            toastNotification('error', 'Backup create failed');
            return redirect()->back();
        }
    }
    /**
     * Will download file backup
     */
    public function databaseBackupDownload($filename)
    {
        $filePath = storage_path("app/backups/database/$filename");
        $headers = [
            'Content-Type' => 'application/zip',
        ];

        return response()->download($filePath, $filename, $headers);
    }
    /**
     * Will delete database backup
     */
    public function databaseBackupDelete(Request $request)
    {

        try {
            $filePath = storage_path("app/backups/database/" . $request['filename']);
            if (File::exists($filePath)) {
                unlink($filePath);
            };
            toastNotification('success', 'Backup deleted  successfully');
            return to_route('core.backup.database.list');
        } catch (\Exception $e) {
            toastNotification('error', 'Backup delete failed');
            return redirect()->back();
        }
    }
}

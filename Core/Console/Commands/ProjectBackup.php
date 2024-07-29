<?php

namespace Core\Console\Commands;

use ZipArchive;
use RecursiveIteratorIterator;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\File;

class ProjectBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:project';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'command for project backup';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $projectPath = base_path();
        $backupPath = storage_path('app/backups/files');

        $timestamp = now()->format('Y_m_d_H_i_s');
        $backupFilename = config('themelooks.item') . "_$timestamp.zip";

        if (!File::exists($backupPath)) {
            File::makeDirectory($backupPath, 0777, true);
        }

        $zip = new ZipArchive;
        $backupZipFilePath = $backupPath . '/' . $backupFilename;
        if ($zip->open($backupZipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE)) {
            $files = new RecursiveIteratorIterator(
                new RecursiveDirectoryIterator($projectPath),
                RecursiveIteratorIterator::LEAVES_ONLY
            );
            foreach ($files as $name => $file) {
                if (!$file->isDir()) {
                    $filePath = $file->getRealPath();
                    $relativePath = substr($filePath, strlen($projectPath) + 1);
                    $zip->addFile($filePath, $relativePath);
                }
            }
            $zip->close();
        }
    }
}

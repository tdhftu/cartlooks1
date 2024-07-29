<?php

namespace Core\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class DatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate database backup sql file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $databaseName = config('database.connections.mysql.database');
        $backupPath = storage_path('app/backups/database');
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0777, true);
        }

        $timestamp = now()->format('Y_m_d_H_i_s');
        $backupFilename = config('themelooks.item') . "_$timestamp.sql";

        $command = "mysqldump -u " . config('database.connections.mysql.username') .
            " -p" . config('database.connections.mysql.password') .
            " --databases $databaseName > $backupPath/$backupFilename";


        $returnValue = NULL;
        $output  = NULL;
        exec($command, $output, $returnValue);

        if ($returnValue !== 0) {
            $file_path = $backupPath . '/' . $backupFilename;
            if (File::exists($file_path)) {
                unlink($file_path);
            };
        }
        return $returnValue;
    }
}

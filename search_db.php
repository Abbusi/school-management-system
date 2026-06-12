<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$search = 'sos@cloudschoolbd.com';
$tables = DB::select("SELECT name FROM sqlite_master WHERE type='table'");
foreach ($tables as $table) {
    $tableName = $table->name;
    try {
        $columns = DB::getSchemaBuilder()->getColumnListing($tableName);
        foreach ($columns as $column) {
            $results = DB::table($tableName)->where($column, 'like', "%{$search}%")->get();
            if ($results->count() > 0) {
                echo "Found in Table: {$tableName}, Column: {$column}\n";
                print_r($results);
            }
        }
    } catch (\Exception $e) {
        // Skip
    }
}

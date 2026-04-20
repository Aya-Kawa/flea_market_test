<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();
\Illuminate\Support\Facades\DB::connection()->enableQueryLog();
$p = App\Models\Purchase::latest()->take(10)->get()->toArray();
echo "PURCHASES:\n";
print_r($p);

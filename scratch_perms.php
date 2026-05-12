<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Spatie\Permission\Models\Role;

$role = Role::where('name', 'admin')->first();
if ($role) {
    echo "Role: {$role->name}\n";
    echo "Permissions: " . implode(', ', $role->permissions->pluck('name')->toArray()) . "\n";
} else {
    echo "Role 'admin' not found.\n";
}

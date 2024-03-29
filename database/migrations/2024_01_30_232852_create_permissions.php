<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Artisan;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Artisan::call('app:permissions:create');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Permission::query()->delete();
        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
};

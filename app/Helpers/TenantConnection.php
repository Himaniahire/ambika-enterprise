<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class TenantConnection
{
    public static function setConnection($dbName)
    {
        config(['database.connections.tenant.database' => $dbName]);

        DB::purge('tenant');
        DB::reconnect('tenant');
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\TenantConnection;
use Illuminate\Support\Facades\DB;

class TenantController extends Controller
{
    public function fetchTenantData()
    {
        // Step 1: Set the tenant connection
        TenantConnection::setConnection('ambika');

        // Step 2: Fetch data using that connection
        $data = DB::connection('tenant')->table('users')->get();

        // Step 3: Return or use the data
        return view('yourview', compact('data'));
    }
}

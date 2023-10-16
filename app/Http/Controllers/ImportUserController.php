<?php

namespace App\Http\Controllers;

use App\Models\ImportUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ImportUserController extends Controller
{
    public function index()
    {
        return view('import-users', ['total' => ImportUser::query()->count()]);
    }

    public function store()
    {
        $apiUrl = 'https://randomuser.me/api/?results=5000&inc=name,email,dob&noinfo';

        $response = Http::get($apiUrl);
        $json = $response->json();
        $json = $json['results'];

        $apiRowsCount = count($json);

        $rows = [];
        $names = [];

        foreach ($json as $row) {
            $rows []= [
                'first_name' => $row['name']['first'],
                'last_name' => $row['name']['last'],
                'email' => $row['email'],
                'age' => $row['dob']['age'],
            ];

            $names []= [
                ['first_name', '=', $row['name']['first']],
                ['last_name', '=', $row['name']['last']],
            ];
        }

        $updated = DB::table('import_users');
        foreach ($names as $name) {
            $updated->orWhere($name);
        }
        $updated = $updated->count();

        DB::table('import_users')
            ->upsert(
                $rows,
                ['first_name', 'last_name'],
                ['email', 'age']
            );

        return [
            'total' => ImportUser::query()->count(),
            'updated' => $updated,
            'created' => $apiRowsCount - $updated,
        ];
    }
}

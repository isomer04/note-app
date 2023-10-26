<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WelcomeController extends Controller
{
    public function index(){
        // return view("welcome");

        // 1. Using raw SQL queries
        // $users =  DB::select('select * from users');
        // dd($users);

        // 2. Query Builder
        // $users = DB::table('users')->select(['name', 'email'])->whereNotNull('email')->orderBy('name')->get();

        // dd($users);

        // 3. Eloquent ORM
        // $students = Student::all();
        // dd($students);

        $student = new Student();
        $student->name = "New";
        $student->email = "email@gmail.com";
        $student->save();



    }
}

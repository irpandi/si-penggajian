<?php

namespace App\Http\Controllers;

class KaryawanController extends Controller
{
    public function index()
    {
        $data = array(
            'title'       => 'Data Karyawan',
            'breadcrumbs' => '<li class="breadcrumb-item">Data Karyawan</li>',
        );

        return view('karyawan.index', compact('data'));
    }
}

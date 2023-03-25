<?php

namespace App\Http\Controllers;

class PeriodeController extends Controller
{
    public function index()
    {
        $data = array(
            'title'       => 'Data Periode',
            'breadcrumbs' => '<li class="breadcrumb-item">Data Periode</li>',
        );

        return view('periode.index', compact('data'));
    }
}

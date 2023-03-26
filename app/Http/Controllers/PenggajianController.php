<?php

namespace App\Http\Controllers;

class PenggajianController extends Controller
{
    public function index()
    {
        $data = array(
            'title'       => 'Data Penggajian',
            'breadcrumbs' => '<li class="breadcrumb-item">Data Penggajian</li>',
        );

        return view('penggajian.index', compact('data'));
    }
}

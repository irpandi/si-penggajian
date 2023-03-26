<?php

namespace App\Http\Controllers;

class BarangController extends Controller
{
    public function index()
    {
        $data = array(
            'title'       => 'Data Barang',
            'breadcrumbs' => '<li class="breadcrumb-item">Data Barang</li>',
        );

        return view('barang.index', compact('data'));
    }
}

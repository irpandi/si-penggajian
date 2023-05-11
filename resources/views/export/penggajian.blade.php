<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            .biodata {
                float: left;
            }
            
            .logo {
                margin-left: 55%;
            }

            .tableGaji {
                border: 1px solid #aaa;
                margin-top: 50px;
                text-align: center;
            }

            .tableGaji tr td {
                border: 1px solid #aaa;
                padding: 10px 10px;
            }
            
            .tableGaji th {
                padding: 10px 10px;
                border: 1px solid #aaa;
            }

            .sign {
                margin-top: 50px;
                margin-right: 80px;
                text-align: center;
                float: right;
            }

            .mengetahui {
                margin-bottom: 80px;
            }
        </style>
    </head>
    
    @php
        use App\Http\Service\General;
    @endphp
    
    <body>
        <div class="biodata">
            <table>
                <tr>
                    <td>Nama</td>
                    <td>:</td>
                    <td>{{ $karyawan->nama }}</td>
                </tr>
    
                <tr>
                    <td>Periode</td>
                    <td>:</td>
                    <td>{{ General::manageDate('Y-m-d', $karyawan->totalGaji->periode->tgl_periode, 'd/m/Y') }}</td>
                </tr>
            </table>
        </div>

        <div class="logo">
            <h2>HD Collection</h2>
        </div>
        
        
        <table class="tableGaji" align="center">
            <thead>
                {{-- Data Gaji --}}
                <tr>
                    <td colspan="6">Data Gaji</td>
                </tr>

                <tr>
                    <th>No</th>
                    <th>Barang</th>
                    <th>Item</th>
                    <th>Pengerjaan</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $no = 1;
                @endphp

                @foreach($karyawan->dataGaji as $value)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $value->subItem->item->barang->nama .' | '. $value->subItem->item->barang->merk}}</td>
                    <td>{{ $value->subItem->item->nama }}</td>
                    <td>{{ $value->subItem->total_pengerjaan_item }}</td>
                    <td>{{ $value->subItem->item->harga }}</td>
                    <td>
                        @php
                            $jumlah = $value->subItem->total_pengerjaan_item * $value->subItem->item->harga;
                        @endphp
        
                        {{ General::formaterNumber($jumlah, 0) }}
                    </td>
                </tr>
                @endforeach

                {{-- Data Tunjangan --}}
                <tr>
                    <td colspan="6">Data Tunjangan</td>
                </tr>

                <thead>
                    <tr>
                        <th>-</th>
                        <th colspan="4">Nama Tunjangan</th>
                        <th>-</th>
                    </tr>
                </thead>

                @foreach($karyawan->totalGaji->tunjangan as $value)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td colspan="4">{{ $value->nama }}</td>
                    <td>{{ General::formaterNumber($value->jumlah, 0) }}</td>
                </tr>
                @endforeach

                <tr>
                    <td colspan="5">Total</td>
                    <td>{{ General::formaterNumber($karyawan->totalGaji->total, 0) }}</td>
                </tr>
            </tbody>
        </table>

        <div class="sign">
            <div class="mengetahui">
                Mengetahui,
            </div>

            <div class="owner">
                Owner
            </div>
        </div>
    </body>
</html>
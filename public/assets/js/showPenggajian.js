$(function () {
    $('#tblGaji').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: routeTblGaji + '?periodeId=' + periodeId + '&karyawanId=' + karyawanId
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama_barang', name: 'nama_barang' },
            { data: 'nama_item', name: 'nama_item' },
            { data: 'harga_item', name: 'harga_item' },
            { data: 'total_pengerjaan_item', name: 'total_pengerjaan_item' },
            { data: 'action', name: 'action' }
        ]
    });

    $('#tblTunjangan').DataTable();

    // * For show modal tambah tunjangan
    $('#btnTambahTunjangan').click(function () {
        let data = {
            'nama': null,
            'jumlah': null
        }

        $('#titleModal').text('Tambah Tunjangan');
    });
});

// * for fill data tunjangan in modal
function fillTunjangan(res) {
    $('#namaTunjangan').val(res.nama);
    $('#jumlahTunjangan').val(res.jumlah);
}
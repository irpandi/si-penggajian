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

    // * For show delete subItem
    $(this).on('click', '.btnDeleteSubItem', function () {
        let id = $(this).data('id'),
            dataAjax = {};

        routeDestroyGaji = routeDestroyGaji.replace(':id', id);

        dataAjax = {
            route: routeDestroyGaji,
            method: 'DELETE',
            dataTableId: '#tblGaji'
        };

        customSweetAlertConfirm('Apakah Anda Yakin ?', 'Ya', 'Tidak', dataAjax, refreshTotalGaji());
        routeDestroyGaji = routeDestroyGaji.replace(id, ':id');
    });
});

// * for fill data tunjangan in modal
function fillTunjangan(res) {
    $('#namaTunjangan').val(res.nama);
    $('#jumlahTunjangan').val(res.jumlah);
}

// * Refresh Total Gaji function
function refreshTotalGaji() {
    return `let totalGajiId = $('#totalGajiId').val();

    routeRefreshTotalGaji = routeRefreshTotalGaji.replace(':id', totalGajiId);

    $.ajax({
        url: routeRefreshTotalGaji,
        method: 'GET',
        success: function (res) {
            let gaji = formatterNumber(res.total);

            $('#totalGaji').text('Rp. ' + gaji);
        }, error: function (err) {
            console.log(err);
        }
    });

    routeRefreshTotalGaji = routeRefreshTotalGaji.replace(totalGajiId, ':id')`;
}
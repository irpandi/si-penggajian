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

    $('#tblTunjangan').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: routeListTunjangan + '?totalGajiId=' + totalGajiId
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama', name: 'nama' },
            { data: 'jumlah', name: 'jumlah' },
            { data: 'action', name: 'action' }
        ]
    });

    $('#btnSaveTunjangan').click(function () {
        $('#formTemplateTunjangan').submit();
    });

    // * For show modal tambah tunjangan
    $('#btnTambahTunjangan').click(function () {
        let data = {
            'nama': null,
            'jumlah': null
        }

        $('#titleModal').text('Tambah Tunjangan');
        $('#formTemplateTunjangan').attr('action', routeAddTunjangan);
        $('#formTemplateTunjangan').attr('method', 'post');
        $('#method').val('');

        // * Clear data tunjangan
        fillTunjangan(data);
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

    // * For show modal edit tunjangan
    $(this).on('click', '.btnEditTunjangan', function () {
        let id = $(this).data('id');
        routeShowTunjangan = routeShowTunjangan.replace(':id', id);

        $.ajax({
            url: routeShowTunjangan,
            type: 'GET',
            success: function (res) {
                fillTunjangan(res);
            }, error: function (err) {
                console.log(err);
            }
        });

        routeShowTunjangan = routeShowTunjangan.replace(id, ':id');
        routeUpdateTunjangan = routeUpdateTunjangan.replace(':id', id);

        $('#titleModal').text('Edit Tunjangan');
        $('#formTemplateTunjangan').attr('action', routeUpdateTunjangan);
        $('#formTemplateTunjangan').attr('method', 'post');
        $('#method').val('put');

        routeUpdateTunjangan = routeUpdateTunjangan.replace(id, ':id');
    });

    // * For delete tunjangan
    $(this).on('click', '.btnDestroyTunjangan', function () {
        let id = $(this).data('id'),
            dataAjax = {};

        routeDestroyTunjangan = routeDestroyTunjangan.replace(':id', id);

        dataAjax = {
            route: routeDestroyTunjangan,
            method: 'DELETE',
            dataTableId: '#tblTunjangan',
        };

        customSweetAlertConfirm('Apakah anda yakin ?', 'Ya', 'Tidak', dataAjax, refreshTotalGaji());
        routeDestroyTunjangan = routeDestroyTunjangan.replace(id, ':id');
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
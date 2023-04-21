$(function () {
    $('#index').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: routeList
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex' },
            { data: 'nama', name: 'nama' },
            { data: 'merk', name: 'merk' },
            { data: 'total', name: 'total' },
            { data: 'action', name: 'action' }
        ]
    });

    // * Action for show modal view barang
    $(this).on('click', '.btnView', function () {
        let id = $(this).data('id');
        routeShow = routeShow.replace(':id', id);

        $.ajax({
            url: routeShow,
            type: 'GET',
            success: function (res) {
                fillBarang(res, true);
            }, error: function (err) {
                console.log(err);
            }
        });

        $('#titleModal').text('Lihat Barang');
        $('#formTemplate').attr('action', '');
        $('#formTemplate').attr('method', '');
        $('#method').val('');

        // * Setup table for show item
        $('#tableItem').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            destroy: true,
            ajax: {
                url: routeShow,
                data: {
                    dataTables: true
                }
            },
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'nama', name: 'nama' },
                { data: 'harga', name: 'harga' },
            ]
        });

        routeShow = routeShow.replace(id, ':id');
    });
});

// * For fill data barang in modal
function fillBarang(res, disable) {
    let nama = $('#nama'),
        merk = $('#merk'),
        total = $('#total');

    if (disable == undefined) {
        disable = false;
    }

    nama.val(res.nama);
    merk.val(res.merk);
    total.val(res.total);

    nama.prop('disabled', disable);
    merk.prop('disabled', disable);
    total.prop('disabled', disable);
}
$(function () {
    $('#index').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: routeList
        },
        columns: [
            { data: "DT_RowIndex", name: "DT_RowIndex" },
            { data: "tgl_periode", name: "tgl_periode" },
            { data: "action", name: "action" }
        ]
    });

    $('#periodeDate').datetimepicker({
        format: "D/M/Y",
    });

    $('#periodeSave').click(function () {
        $('#formPeriodeTemplate').submit();
    });

    // * Action for on click button modal periode add
    $('#btnTambahPeriode').click(function () {
        $('#titleModal').text('Tambah Periode');
        $('#formPeriodeTemplate').attr('action', routeAdd);
        $('#formPeriodeTemplate').attr('method', 'post');
        $('#method').val("");
        $('#inputPeriodeDate').val("");
    });

    // * Action for on click button modal periode edit
    $(this).on('click', '.btnEditPeriode', function () {
        var id = $(this).data('id');
        routeView = routeView.replace(':id', id);

        $.ajax({
            url: routeView,
            type: 'GET',
            success: function (res) {
                let dmy = changeToDMY(res.tgl_periode);

                $('#inputPeriodeDate').val(dmy);
            }, error: function (err) {
                console.log(err);
            }
        });

        routeView = routeView.replace(id, ':id');
        routeUpdate = routeUpdate.replace(':id', id);

        $('#titleModal').text('Edit Periode');
        $('#formPeriodeTemplate').attr('action', routeUpdate);
        $('#formPeriodeTemplate').attr('method', 'post');
        $('#method').val("put");

        routeUpdate = routeUpdate.replace(id, ':id');
    });
});
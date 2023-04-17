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
            { data: "nama", name: "nama" },
            { data: "status", name: "status" },
            { data: "action", name: "action" }
        ]
    });

    $('#tglLahir').datetimepicker({
        format: 'D/M/Y',
    });

    $('#btnSave').click(function () {
        $('#formTemplate').submit();
    });

    // * Action for modal add data karyawan
    $('#btnTambah').click(function () {
        $('#titleModal').text('Tambah Karyawan');
        $('#formTemplate').attr('action', routeAdd);
        $('#formTemplate').attr('method', 'post');
        $('#method').val("");
        $('#tglLahir').val("");
    });
});
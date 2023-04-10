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
        $('#formPeriodeAdd').submit();
    });
});
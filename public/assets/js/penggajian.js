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
            { data: 'tgl_periode', name: 'tgl_periode' },
            { data: 'total', name: 'total' },
            { data: 'action', name: 'action' }
        ]
    });
});
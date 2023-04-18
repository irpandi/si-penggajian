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
        readOnlyInput: true
    });

    $('#btnSave').click(function () {
        $('#formTemplate').submit();
    });

    // * Action for modal add data karyawan
    $('#btnTambah').click(function () {
        let data = {
            "nik": null,
            "nama": null,
            "tempat_lahir": null,
            "tgl_lahir": null,
            "no_hp": null,
            "status": 1,
            "alamat": null,
        }

        $('#titleModal').text('Tambah Karyawan');
        $('#formTemplate').attr('action', routeAdd);
        $('#formTemplate').attr('method', 'post');
        $('#method').val("");

        // * Clear view karyawan
        fillKaryawan(data);
    });

    // * Action for on click button modal karyawan edit
    $(this).on('click', '.btnEdit', function () {
        let id = $(this).data('id');
        routeView = routeView.replace(':id', id);

        $.ajax({
            url: routeView,
            type: 'GET',
            success: function (res) {
                res.tgl_lahir = changeToDMY(res.tgl_lahir);

                // * Data view karyawan for edit
                fillKaryawan(res);
            }, error: function (err) {
                console.log(err);
            }
        });

        routeView = routeView.replace(id, ':id');
        routeUpdate = routeUpdate.replace(':id', id);

        $('#titleModal').text('Edit Karyawan');
        $('#formTemplate').attr('action', routeUpdate);
        $('#formTemplate').attr('method', 'post');
        $('#method').val('put');

        routeUpdate = routeUpdate.replace(id, ':id');
    });

    // * Action for on click button delete karyawan
    $(this).on('click', '.btnDelete', function () {
        let id = $(this).data('id');

        routeDestroy = routeDestroy.replace(':id', id);

        let dataAjax = {
            route: routeDestroy,
            method: 'DELETE',
            dataTableId: '#index'
        };

        customSweetAlertConfirm('Apakah anda yakin ?', 'Ya', 'Tidak', dataAjax);
        routeDestroy = routeDestroy.replace(id, ':id');
    });

    // * Action for on click button status karyawan
    $(this).on('click', '.btnStatus', function () {
        let id = $(this).data('id'),
            status = $(this).data('status');

        routeStatusKaryawan = routeStatusKaryawan.replace(':id', id);

        let dataAjax = {
            route: routeStatusKaryawan,
            method: 'PUT',
            dataTableId: '#index',
            dataSend: {
                status: status
            }
        };

        customSweetAlertConfirm('Apakah anda yakin ?', 'Ya', 'Tidak', dataAjax);
        routeStatusKaryawan = routeStatusKaryawan.replace(id, ':id');
    });
});

// * For fill data karyawan in modal
function fillKaryawan(res) {
    $('#nik').val(res.nik);
    $('#nameKaryawan').val(res.nama);
    $('#tmptLahir').val(res.tempat_lahir);
    $('#tglLahir').val(res.tgl_lahir);
    $('#noHp').val(res.no_hp);
    $('#alamat').val(res.alamat);
    $('#status').val(res.status).trigger('change');
}
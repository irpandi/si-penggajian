$(function () {
    // * AddItem Action
    $('#addItem').click(function () {
        let formItem = '';

        formItem = `
            <div id="inputFormItem">
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">
                            Item
                        </div>

                        <div class="card-tools">
                            <button type="button" id="deleteItem" class="close" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Nama Item" id="namaItem" name="namaItem[]">
                            <div class="input-group-text">
                                <i class="fas fa-table"></i>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="number" class="form-control" placeholder="Harga Item" id="hargaItem" name="hargaItem[]">
                            <div class="input-group-text">
                                <i class="fas fa-cog"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;

        $('#newItem').append(formItem);
    });

    // * DeleteItem Action
    $(this).on('click', '#deleteItem', function () {
        $(this).closest('#inputFormItem').remove();
    });

    // * DeleteItem Permanently action
    $(this).on('click', '#deleteItemPermanently', function () {
        let id = $(this).data('id'),
            funcThis = $(this);

        Swal.fire({
            title: 'Apakah anda yakin ?',
            showCancelButton: true,
            confirmButtonText: 'Ya',
            denyButtonText: 'Tidak'
        }).then((result) => {
            if (result.isConfirmed) {
                routeDestroyItem = routeDestroyItem.replace(':id', id);

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-Token': csrfToken
                    }
                });

                $.ajax({
                    url: routeDestroyItem,
                    type: 'DELETE',
                    contentType: 'application/json',
                    success: function (res) {
                        funcThis.closest('#inputFormItem').remove();
                        Swal.fire(res.message, '', res.iconStatus);
                    }, err: function (err) {
                        console.log(err);
                    }, complete: function (http, status) {
                        Swal.fire(http.responseJSON.message, '', http.responseJSON.iconStatus);
                    }
                });

                routeDestroyItem = routeDestroyItem.replace(id, ':id');
            }
        });
    });

    $('#tglPeriode').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Periode',
        allowClear: true,
        disabled: true,
        ajax: {
            url: routeOptPenggajian,
            dataType: 'json',
            type: 'GET',
            data: function () {
                let query = {
                    type: 'periode'
                }

                return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: changeToDMY(item.tgl_periode),
                            id: item.id
                        }
                    })
                }
            }
        }
    });

    $("#tglPeriode").select2("trigger", "select", {
        data: { id: dataPeriode.id, text: changeToDMY(dataPeriode.tgl_periode) }
    });
});
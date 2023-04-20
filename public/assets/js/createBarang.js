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
});
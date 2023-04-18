$(function () {
    $(".errorAlert").fadeTo(8000, 500).slideUp(500, function () {
        $(".errorAlert").slideUp(8000);
    });

    $('.select2Default').select2({
        theme: 'bootstrap4'
    });
});

// * Function change date to DMY
function changeToDMY(date) {
    var dateData = new Date(date.split("/").reverse().join("-")),
        dd = dateData.getDate(),
        mm = dateData.getMonth() + 1,
        yy = dateData.getFullYear();

    return dd + "/" + mm + "/" + yy;
}

// * Function manage SweetAlert
function customSweetAlert(icon, title, msg) {
    Swal.fire({
        icon: icon,
        title: title,
        text: msg,
    });
}

// * Function manage SweetAlert Confirmation
function customSweetAlertConfirm(title, confirmText, denyButtonText, dataAjax) {
    Swal.fire({
        title: title,
        showCancelButton: true,
        confirmButtonText: confirmText,
        denyButtonText: denyButtonText
    }).then((result) => {
        let route = dataAjax.route,
            method = dataAjax.method,
            dataTableId = dataAjax.dataTableId,
            dataSend = dataAjax.dataSend ?? {};

        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                }
            });

            $.ajax({
                url: route,
                type: method,
                data: dataSend,
                success: function (res) {
                    Swal.fire(res.message, '', res.iconStatus);

                    if (dataTableId) {
                        $(dataTableId).DataTable().ajax.reload();
                    }
                }, error: function (err) {
                    console.log(err);
                }
            });
        }
    });
}

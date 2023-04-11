$(function () {
    $(".errorAlert").fadeTo(8000, 500).slideUp(500, function () {
        $(".errorAlert").slideUp(8000);
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

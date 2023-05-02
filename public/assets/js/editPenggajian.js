$(function () {
    $('#tglPeriode').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Periode',
        allowClear: true,
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

    $('#karyawan').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Karyawan',
        allowClear: true,
        ajax: {
            url: routeOptPenggajian,
            dataType: 'json',
            type: 'GET',
            data: function () {
                let query = {
                    type: 'karyawan'
                }

                return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
                            id: item.id
                        }
                    })
                }
            }
        }
    });

    $('#barang').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Barang',
        allowClear: true,
        ajax: {
            url: routeOptPenggajian,
            dataType: 'json',
            type: 'GET',
            data: function () {
                let query = {
                    type: 'barang'
                }

                return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama + " - " + item.merk,
                            id: item.id
                        }
                    })
                }
            }
        }
    });

    $('#item').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Item',
        allowClear: true,
        ajax: {
            url: routeOptPenggajian,
            dataType: 'json',
            type: 'GET',
            data: function () {
                let query = {
                    type: 'item',
                    barangId: $('#barang').val()
                }

                return query;
            },
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.nama,
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

    $("#karyawan").select2("trigger", "select", {
        data: { id: dataKaryawan.id, text: dataKaryawan.nama }
    });

    $("#barang").select2("trigger", "select", {
        data: { id: dataBarang.id, text: dataBarang.nama }
    });

    $("#item").select2("trigger", "select", {
        data: { id: dataItem.id, text: dataItem.nama }
    });
});
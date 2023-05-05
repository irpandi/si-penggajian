$(function () {
    $('#tglPeriode').select2({
        theme: 'bootstrap4',
        placeholder: 'Pilih Periode',
        allowClear: true,
        ajax: {
            url: routeOptPenggajian,
            dataType: 'json',
            type: 'GET',
            data: function (params) {
                let query = {
                    type: 'periode',
                    q: params.term
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
            data: function (params) {
                let query = {
                    type: 'karyawan',
                    q: params.term
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
            data: function (params) {
                let query = {
                    type: 'barang',
                    periodeId: $('#tglPeriode').val(),
                    q: params.term
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
            data: function (params) {
                let query = {
                    type: 'item',
                    barangId: $('#barang').val(),
                    q: params.term
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
});
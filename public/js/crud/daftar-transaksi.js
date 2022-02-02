import { formatNumber } from "../utility.js"

$(function() {
    let transaksiData = []
    let selectedTransaksiData = []
    const selectedTransaksiTable = $('#selected-transaksi-table').DataTable()
    const pembayaranTable = $('#pembayaran-table').DataTable()
    const paketTable = $('#daftar-transaksi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                url: "/api/transaksi",
                dataSrc: function ( json ) {
                    transaksiData = json.data
                    return json.data
                }
            },
        columns: [
            { data: 'id' },
            { data: 'kode_invoice' },
            { data: 'member.nama' },
            { data: 'tgl_bayar' },
            { data: 'batas_waktu' },
            {
                data: function(data, type, row) {
                    if(type === 'display') {
                        switch (data.metode_pembayaran) {
                            case "cash":
                                return '<span class="badge bg-light-primary">cash</span>'
                            case "dp":
                                return '<span class="badge bg-light-info">dp</span>'
                            case "bayar nanti":
                                return '<span class="badge bg-light-warning">bayar nanti</span>'
                        }
                    } else {
                        return ''
                    }
                }
            },
            {
                data: function(data, type, row) {
                    if(type === 'display') {
                        switch (data.status_transaksi) {
                            case "baru":
                                return '<span class="badge bg-light-primary">baru</span>'
                            case "proses":
                                return '<span class="badge bg-light-info">proses</span>'
                            case "selesai":
                                return '<span class="badge bg-light-warning">selesai</span>'
                            case "diambil":
                                return '<span class="badge bg-light-success">diambil</span>'
                        }
                    } else {
                        return ''
                    }
                }
            },
            {
                data: function(data, type, row) {
                    if(type === 'display') {
                        switch (data.status_pembayaran) {
                            case "lunas":
                                return '<span class="badge bg-light-success">lunas</span>'
                            case "belum lunas":
                                return '<span class="badge bg-light-danger">belum lunas</span>'
                        }
                    } else {
                        return ''
                    }
                }
            },
            {
                render: function(data, type, row, meta) {
                    if(type === 'display') {
                        return `<div class="d-flex justify-content-center">
                                    <button class="d-flex align-items-center btn btn-outline-primary rounded-pill fs-6 p-2 select-btn" data-id="${row.id}">
                                        <i class="bi bi-check2"></i>
                                    </button>
                                </div>`
                    } else {
                        return ''
                    }
                },
                orderable: false,
                searchable: false
            }
        ]
    })

    $('#daftar-transaksi-table').on('click', '.select-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        searchDataById(id)
        $('#select-data-modal').modal('toggle')
        displayTransaksiData()
        drawTransaksiTable()
        drawPembayaranTable()
    })

    const searchDataById = (id) => {
        const selected = transaksiData.find(x => x.id == id)
        if(typeof selected !== 'undefined') {
            selectedTransaksiData = selected
        } else {
            showAlert('Ups..', 'warning', 'Maaf data yang kamu cari tidak ada')
        }
    }

    const displayTransaksiData = () => {
        for (const key in selectedTransaksiData) {
            if(typeof key !== 'object') {
                $(`[name="${key}"]`).val(selectedTransaksiData[key])
            }
        }
        for (const key in selectedTransaksiData.member) {
            $(`[name="${key}"]`).val(selectedTransaksiData.member[key])
        }
        // for (const key in selectedTransaksiTable.pembayaran) {
        //     $(`[name="${key}"]`).val(selectedTransaksiData.pembayaran[key])
        // }
        let totalPembayaran = 0
        for(let i = 0; i < selectedTransaksiData.pembayaran.length; i++) {
            totalPembayaran += parseInt(selectedTransaksiData.pembayaran[i].total_pembayaran)
        }
        $(`[name="total_pembayaran"]`).html(formatNumber(totalPembayaran))
    }

    const drawTransaksiTable = () => {
        selectedTransaksiTable.clear().draw()
        selectedTransaksiData.detail_transaksi.map((item, index) => {
            selectedTransaksiTable.row.add([
                index + 1,
                item.paket.nama_paket,
                item.paket.jenis,
                formatNumber(item.paket.harga),
                `<input type="number" name="qty[]" class="form-control mx-auto text-center" style="width: 100px" value="${item.qty}" data-id="${item.id}" readonly>`,
            ]).draw()
        })
    }

    const drawPembayaranTable = () => {
        pembayaranTable.clear().draw()
        let subtotalBayar = 0
        selectedTransaksiData.pembayaran.map((item, index) => {
            subtotalBayar += parseInt(item.total_bayar)
            pembayaranTable.row.add([
                index + 1,
                moment(item.created_at).format('DD MMMM YYYY'),
                `Rp ${formatNumber(item.biaya_tambahan)}`,
                `${formatNumber(item.diskon)}%`,
                `${formatNumber(item.pajak)}%`,
                `Rp ${formatNumber(item.total_pembayaran)}`,
                `Rp ${formatNumber(item.total_bayar)}`,
            ]).draw()
        })

        $('[name="subtotal_bayar"]').html(`Rp ${formatNumber(subtotalBayar)}`)
    }
})

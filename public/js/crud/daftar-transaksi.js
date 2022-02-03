import { formatNumber } from "../utility.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"
import clientRequest from "../api.js"

$(function() {
    let transaksiData = []
    let selectedTransaksiData = []
    let totalPembayaran = 0
    let sisaPembayaran = 0
    const selectedTransaksiTable = $('#selected-transaksi-table').DataTable()
    const pembayaranTable = $('#pembayaran-table').DataTable()
    const daftarTransaksiTable = $('#daftar-transaksi-table').DataTable({
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
        $('#status-section').removeClass('d-none')
        displayTransaksiData()
        drawTransaksiTable()
        drawPembayaranTable()
        renderStatusPembayaran()
        renderStatusTransaksi()
        renderInputFormTransaksi()
    })

    $('#update-transaksi').on('submit', function(e) {
        e.preventDefault()
        if(validation()) {
            showConfirmAlert('Peringatan !', 'warning', `Apakah anda ingin mengubah status transaksi ${selectedTransaksiData.kode_invoice} ini ?`, 'Yes', (result) => {
                if(result) {
                    const data = {
                        transaksi: {
                            id: selectedTransaksiData.id,
                            status_transaksi: $('[name="status_transaksi"]').val(),
                            status_pembayaran: selectedTransaksiData.status_pembayaran,
                        },
                        pembayaran: {
                            transaksi_id: selectedTransaksiData.id,
                            biaya_tambahan: 0,
                            diskon: 0,
                            pajak: 0,
                            total_pembayaran: 0,
                            total_bayar: $('[name="total_bayar"]').val(),
                        }
                    }
                    clientRequest('/api/transaksi/update', 'POST', data, (status, res) => {
                        if(status) {
                            showToast('success', 'success', 'Berhasil mengubah data transaksi')
                            clearForm()
                            daftarTransaksiTable.ajax.reload()
                        } else {
                            if(res.status === 422) {
                                showToast('failed', 'warning', 'Harap periksa kembali data transaksi anda')
                            } else {
                                showToast('failed', 'error', 'Terjadi kesalahan, Internal Server Error')
                            }
                        }
                    })
                }
            })
        }
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

    const renderStatusPembayaran = () => {
        let alert = ''
        switch (selectedTransaksiData.status_pembayaran) {
            case 'lunas':
                alert = `<div class="alert alert-success text-center py-2" role="alert"><strong>Lunas</strong></div>`
                break;
                case 'belum lunas':
                alert = `<div class="alert alert-danger text-center py-2" role="alert"><strong>Belum Lunas</strong></div>`
                break;
        }
        $('#alert-status-pembayaran').html(alert)
        totalPembayaran = 0
        sisaPembayaran = 0
        if(selectedTransaksiData.status_pembayaran === 'belum lunas') {
            selectedTransaksiData.pembayaran.map((item, index) => {
                totalPembayaran += item.total_pembayaran
                sisaPembayaran += item.total_pembayaran - item.total_bayar
            })
        }
        $('#status-pembayaran-form [name="total_pembayaran"]').val(totalPembayaran)
        $('#status-pembayaran-form [name="sisa_pembayaran"]').val(sisaPembayaran)
    }

    const renderStatusTransaksi = () => {
        let alert = ''
        switch (selectedTransaksiData.status_transaksi) {
            case 'baru':
                alert = `<div class="alert alert-primary text-center py-2" role="alert"><strong>Baru</strong></div>`
                break;
            case 'proses':
                alert = `<div class="alert alert-info text-center py-2" role="alert"><strong>Proses</strong></div>`
                break;
            case 'selesai':
                alert = `<div class="alert alert-warning text-center py-2" role="alert"><strong>Selesai</strong></div>`
                break;
            case 'diambil':
                alert = `<div class="alert alert-success text-center py-2" role="alert"><strong>Diambil</strong></div>`
                break;
        }
        $('#alert-status-transaksi').html(alert)
    }

    const renderInputFormTransaksi = () => {
        if(selectedTransaksiData.status_pembayaran === 'lunas') {
            $('#form-transaksi-belum-lunas').addClass('d-none')
            $('#form-transaksi-lunas').removeClass('d-none')
        } else {
            $('#form-transaksi-belum-lunas').removeClass('d-none')
            $('#form-transaksi-lunas').addClass('d-none')
        }
    }

    const clearForm = () => {
        $('input.form-control').val('')
        selectedTransaksiTable.clear().draw()
        pembayaranTable.clear().draw()
        $('#status-section').addClass('d-none')
        $('[name="total_pembayaran"]').text('0')
        $('[name="subtotal_bayar"]').text('Rp 0')
        selectedTransaksiData = []
    }

    const validation = () => {
        if(selectedTransaksiData.length === 0) {
            showAlert('Ups...', 'warning', 'Pilih data yang akan diubah')
            return false
        } else {
            if(selectedTransaksiData.status_pembayaran === 'belum lunas') {
                const totalBayar = $('[name="total_bayar"]').val()
                if(totalBayar === '') {
                    showAlert('Ups...', 'warning', 'Total bayar tidak boleh kosong')
                    return false
                } else if(parseInt(totalBayar) < sisaPembayaran) {
                    showAlert('Ups...', 'warning', 'Total bayar tidak boleh kurang dari sisa pembayaran')
                    return false
                } else {
                    return true
                }
            } else {
                return true
            }
        }
    }
})

import { formatNumber } from "../utility.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"
import clientRequest from "../api.js"

$(function() {
    let transaksiData = []
    let selectedTransaksiData = []
    let defaultData = {
        biaya_tambahan: 0,
        diskon: 0,
        pajak: 10,
        total_pembayaran: 0,
        sisa_pembayaran: 0,
        total_bayar: {
            pertama: 0,
            kedua: 0,
        }
    }

    $('#daftar-transaksi-table').on('click', '.select-btn', function(e) {
        e.preventDefault()
        clearForm()
        const id = $(this).data('id')
        searchDataById(id)
        $('#select-data-modal').modal('toggle')
        $('#status-section').removeClass('d-none')
        renderDataPembayaran()
        displayTransaksiData()
        drawPaketTable()
    })

    $('#update-transaksi').on('submit', function(e) {
        e.preventDefault()
        if(validation()) {
            showConfirmAlert('Peringatan !', 'warning', `Apakah anda ingin mengubah status transaksi ${selectedTransaksiData.kode_invoice} ini ?`, 'Yes', (result) => {
                if(result) {
                    updateTransactionDataToServer()
                }
            })
        }
    })

    $('[name="biaya_tambahan"]').on('keyup', function(e) {
        if(selectedTransaksiData.metode_pembayaran === 'bayar nanti') {
            const value = parseInt($(this).val() === '' ? 0 : $(this).val())
            defaultData.biaya_tambahan = value
            calculate()
        }
    })

    $('[name="diskon"]').on('keyup', function(e) {
        if(selectedTransaksiData.metode_pembayaran === 'bayar nanti') {
            const value = parseInt($(this).val() === '' ? 0 : $(this).val())
            defaultData.diskon = value
            calculate()
        }
    })

    $('[name="total_bayar"]').on('keyup', function(e) {
        const value = parseInt($(this).val() === '' ? 0 : $(this).val())
        defaultData.total_bayar.kedua = value
        calculate()
    })

    const updateTransactionDataToServer = () => {
        let pembayaran
        if(selectedTransaksiData.metode_pembayaran === 'dp') {
            pembayaran = {
                transaksi_id: selectedTransaksiData.id,
                ...defaultData,
                total_bayar: defaultData.total_bayar.kedua,
            }
        } else {
            pembayaran = {
                transaksi_id: selectedTransaksiData.id,
                ...defaultData,
                total_bayar: defaultData.total_bayar.kedua,
            }
        }
        const data = {
            transaksi: {
                id: selectedTransaksiData.id,
                status_pembayaran: 'lunas',
            },
            pembayaran
        }

        console.log(data)

        clientRequest('/api/transaksi/update', 'POST', data, (status, res) => {
            if(status) {
                showToast('success', 'success', 'Berhasil mengubah data transaksi')
                window.open('/api/transaksi/cetak-faktur/' + selectedTransaksiData.kode_invoice, '_blank')
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
        calculate()
    }

    const drawPaketTable = () => {
        selectedPaketTable.clear().draw()
        selectedTransaksiData.detail_transaksi.map((item, index) => {
            selectedPaketTable.row.add([
                index + 1,
                item.paket.nama_paket,
                item.paket.jenis,
                formatNumber(item.paket.harga),
                `${item.qty}x`,
                formatNumber(item.paket.harga * item.qty),
                item.keterangan === null ? '-' : item.keterangan
            ]).draw()
        })
    }

    const renderDataPembayaran = () => {
        for (const key in selectedTransaksiData.pembayaran) {
            $(`[name="${key}"]`).val(selectedTransaksiData.pembayaran[key])
        }
        for (const key in defaultData) {
            if(selectedTransaksiData.pembayaran[key]) {
                defaultData[key] = selectedTransaksiData.pembayaran[key]
            }
        }
        let totalBayar = selectedTransaksiData.pembayaran.detail_pembayaran.map(item => item.total_bayar).reduce((a, b) => a + b, 0)
        defaultData.total_bayar.pertama = totalBayar
        defaultData.sisa_pembayaran = selectedTransaksiData.pembayaran.total_pembayaran - totalBayar
        if(selectedTransaksiData.metode_pembayaran === 'dp') {
            $('[name="biaya_tambahan"]').attr('readonly', '')
            $('[name="diskon"]').attr('readonly', '')
        } else {
            $('[name="biaya_tambahan"]').removeAttr('readonly')
            $('[name="diskon"]').removeAttr('readonly')
        }
        const metode = $('[name="metode_pembayaran"]')
        selectedTransaksiData.metode_pembayaran === 'dp' ? metode.addClass('alert-info') && metode.removeClass('alert-warning') : metode.removeClass('alert-info') && metode.addClass('alert-warning')
        metode.html(`<strong>${selectedTransaksiData.metode_pembayaran}</strong>`)
    }

    const calculate = () => {
        let { total_pembayaran, sisa_pembayaran } = defaultData
        total_pembayaran = 0
        sisa_pembayaran = 0
        selectedTransaksiData.detail_transaksi.map(item => {
            total_pembayaran += (parseInt(item.harga) * parseInt(item.qty))
        })
        total_pembayaran += defaultData.biaya_tambahan
        const diskon = Math.round((total_pembayaran * defaultData.diskon) / 100)
        total_pembayaran -= diskon
        const pajak = Math.round((total_pembayaran * defaultData.pajak) / 100)
        total_pembayaran += pajak
        sisa_pembayaran = total_pembayaran - defaultData.total_bayar.pertama - defaultData.total_bayar.kedua
        sisa_pembayaran = sisa_pembayaran < 0 ? 0 : sisa_pembayaran

        defaultData.total_pembayaran = total_pembayaran
        defaultData.sisa_pembayaran = sisa_pembayaran
        $(`[name="total_pembayaran"]`).html(formatNumber(total_pembayaran))
        $(`[name="total_pembayaran"]`).val(total_pembayaran)
        $(`[name="sisa_pembayaran"]`).val(sisa_pembayaran)
    }

    const clearForm = () => {
        $('input.form-control').val('')
        selectedPaketTable.clear().draw()
        pembayaranTable.clear().draw()
        $('#status-section').addClass('d-none')
        $('[name="total_pembayaran"]').text('0')
        $('[name="subtotal_bayar"]').text('Rp 0')
        selectedTransaksiData = []
        defaultData = {
            biaya_tambahan: 0,
            diskon: 0,
            pajak: 10,
            total_pembayaran: 0,
            sisa_pembayaran: 0,
            total_bayar: {
                pertama: 0,
                kedua: 0,
            }
        }
    }

    const validation = () => {
        if(selectedTransaksiData.length === 0) {
            showAlert('Ups...', 'warning', 'Pilih data yang akan diubah')
            return false
        } else {
            const { total_bayar, total_pembayaran } = defaultData
            console.info(total_bayar, total_pembayaran)
            if(total_bayar === '') {
                showAlert('Ups...', 'warning', 'Total bayar tidak boleh kosong')
                return false
            } else if(total_bayar < total_pembayaran) {
                showAlert('Ups...', 'warning', 'Total bayar tidak boleh kurang dari sisa pembayaran')
                return false
            } else {
                return true
            }
        }
    }

    const selectedPaketTable = $('#selected-paket-table').DataTable({
        searching: false,
        paging: false,
        ordering: false,
        info: false,
    })
    const pembayaranTable = $('#pembayaran-table').DataTable()
    const daftarTransaksiTable = $('#daftar-transaksi-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                url: "/api/transaksi/non-cash",
                dataSrc: function ( json ) {
                    transaksiData = json.data
                    return json.data
                }
            },
        columns: [
            { data: 'DT_RowIndex' },
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
})

import clientRequest from '../api.js'
import { formatNumber } from "../utility.js"
import { showToast } from '../sweetalert.js'

$(function() {
    let laporanData = []
    let selectedLaporan = []

    $('#export-txt').click(function() {
        let dataText = ''
        laporanData.map((item, index) => {
            dataText += `${index + 1}.\tNo Invoice\t\t: ${item.kode_invoice}\n\tNama Member\t\t: ${item.member.nama}\n\tTanggal Bayar\t\t: ${item.tgl_bayar}\n\tBatas Waktu\t\t: ${item.batas_waktu}\n\tMetode Pembayaran\t: ${item.metode_pembayaran}\n\tStatus Transaksi\t: ${item.status_transaksi}\n\tStatus Pembayaran\t: ${item.status_pembayaran}\n\n`
        })
        download(dataText, 'laporan-transaksi.txt', 'text/plain')
    })

    $('#laporan-table').on('click', '.detail-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        searchLaporanById(id)
        drawDetailLaporan()
    })

    $('#filter-data-form').on('submit', function(e) {
        e.preventDefault()
        const data = new FormData(this)
        const startDate = data.get('start_date')
        const endDate = data.get('end_date')
        if(startDate !== '' && endDate !== '') {
            filterDataBetweenDate(startDate, endDate)
        } else {
            showToast('Ups..', 'warning', 'Pilih tanggal terlebih dahulu')
        }
    })

    const getTransaksiData = () => {
        clientRequest('/api/laporan/transaksi', 'GET', '', (status, res) => {
            if(status) {
                laporanData = res.data
                drawLaporanTable()
            }
        })
    }

    const searchLaporanById = (id) => {
        const selected = laporanData.find(item => item.id == id)
        if(typeof selected !== 'undefined') {
            selectedLaporan = selected
        }
    }

    const filterDataBetweenDate = (startDate, endDate) => {
        clientRequest(`/api/laporan/transaksi/between/${startDate}/${endDate}`, 'GET', '', (status, res) => {
            if(status) {
                laporanData = res.data
                drawLaporanTable()
            } else {
                console.info(res)
            }
        })
    }

    const drawDetailLaporan = () => {
        for (const key in selectedLaporan) {
            if(typeof selectedLaporan[key] !== 'object') {
                if(key == 'status_transaksi') {
                    switch (selectedLaporan[key]) {
                        case "baru":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-primary">baru</span>`)
                            break;
                        case "proses":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-info">proses</span>`)
                            break;
                        case "selesai":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-warning">selesai</span>`)
                            break;
                        case "diambil":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-success">diambil</span>`)
                            break;
                    }
                } else if(key == 'status_pembayaran') {
                    switch (selectedLaporan[key]) {
                        case "lunas":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-success">lunas</span>`)
                            break;
                        case "belum lunas":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-danger">belum lunas</span>`)
                            break;
                    }
                } else if(key == 'metode_pembayaran') {
                    switch (selectedLaporan[key]) {
                        case "cash":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-primary">cash</span>`)
                            break;
                        case "dp":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-info">dp</span>`)
                            break;
                        case "bayar nanti":
                            $(`#detail-transaksi-modal [name="${key}"]`).html(`<span class="badge bg-light-warning">bayar nanti</span>`)
                            break;
                    }
                } else {
                    $(`#detail-transaksi-modal [name="${key}"]`).text(selectedLaporan[key])
                }
            } else {
                switch (key) {
                    case 'member':
                        for (const memberKey in selectedLaporan[key]) {
                            $(`#detail-transaksi-modal [name="${memberKey}"]`).text(selectedLaporan[key][memberKey])
                        }
                        break;
                    case 'detail_transaksi':
                        let detailPaket = ''
                        let total = 0
                        selectedLaporan[key].map((item, index) => {
                            total += parseInt(item.paket.harga) * parseInt(item.qty)
                            detailPaket += `<tr>
                                <td>${index + 1}</td>
                                <td>${item.paket.nama_paket}</td>
                                <td>${item.paket.jenis}</td>
                                <td>Rp ${formatNumber(item.paket.harga)}</td>
                                <td>${item.qty}x</td>
                                <td>Rp ${formatNumber(item.paket.harga * item.qty)}</td>
                            </tr>`
                        })
                        $('#paket-table tbody').html(detailPaket)
                        $('[name="total_pembayaran"]').text(`Rp ${formatNumber(total)}`)
                        break;
                    case 'pembayaran':
                        let detailPembayaran = ''
                        let totalPembayaranBersih = 0
                        let totalBayar = 0
                        selectedLaporan[key].map((item, index) => {
                            totalPembayaranBersih += item.total_pembayaran
                            totalBayar += item.total_bayar
                            detailPembayaran += `<tr>
                                <td>${index + 1}</td>
                                <td>${item.created_at.substring(0, 10)}</td>
                                <td>Rp ${formatNumber(item.biaya_tambahan)}</td>
                                <td>${item.diskon}%</td>
                                <td>${item.pajak}%</td>
                                <td>Rp ${formatNumber(item.total_pembayaran)}</td>
                                <td>Rp ${formatNumber(item.total_bayar)}</td>
                            </tr>`
                        })
                        $('#pembayaran-table tbody').html(detailPembayaran)
                        $('[name="total_pembayaran_bersih"]').text(`Rp ${formatNumber(totalPembayaranBersih)}`)
                        $('[name="total_bayar"]').text(`Rp ${formatNumber(totalBayar)}`)
                        break;
                }
            }
        }
    }

    const drawLaporanTable = () => {
        $('#laporan-table').DataTable().destroy()
        $('#laporan-table').DataTable({
            data: laporanData,
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
                                case 'lunas':
                                    return `<span class="badge bg-light-success">${data.status_pembayaran}</span>`
                                case 'belum lunas':
                                    return `<span class="badge bg-light-danger">${data.status_pembayaran}</span>`
                            }
                        } else {
                            return ''
                        }
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        if(type === 'display') {
                            return `<div class="d-flex justify-content-center"><button class="d-flex align-items-center btn btn-outline-primary rounded-pill fs-6 p-2 detail-btn" data-bs-toggle="modal" data-bs-target="#detail-transaksi-modal" data-id="${row.id}"><i class="bi bi-info-circle"></i></button></div>`
                        } else {
                            return ''
                        }
                    },
                    orderable: false,
                }
            ]
        })

        $('#laporan-table').DataTable().on( 'order.dt search.dt', function () {
            $('#laporan-table').DataTable().column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    }

    getTransaksiData()

    const download = (content, fileName, contentType) => {
        var a = document.createElement("a");
        var file = new Blob([content], {type: contentType});
        a.href = URL.createObjectURL(file);
        a.download = fileName;
        a.click();
    }
})

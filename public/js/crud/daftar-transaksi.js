import clientRequest from "../api.js"
import { formatNumber } from "../utility.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    let dataTransaksi = []
    let selectedTransaksi = []
    const statusTransaksi = ['baru', 'proses', 'selesai', 'diambil']

    $('#daftar-transaksi-table').on('click', '.update-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        searchTransaksiById(id)
        displayDetailTransaksiData()
    })

    $('#update-status-transaksi').on('click', function(e) {
        e.preventDefault()
        if(validation() && selectedTransaksi.status_transaksi !== 'diambil') {
            const currentStatus = statusTransaksi.findIndex(x => x == selectedTransaksi.status_transaksi)
            if(currentStatus < 2 || selectedTransaksi.status_pembayaran === 'lunas') {
                showConfirmAlert('Pemberitahuan !', 'warning', `Apakah anda ingin mengubah status transaksi "${statusTransaksi[currentStatus]}" > "${statusTransaksi[currentStatus + 1]}" ?`, 'Yes', (result) => {
                    if(result) {
                        const data = {
                            transaksi: {
                                id: selectedTransaksi.id,
                                status_transaksi: statusTransaksi[currentStatus + 1]
                            },
                        }
                        clientRequest('/api/transaksi/update/status-transaksi', 'POST', data, (status, res) => {
                            if(status) {
                                showToast('Success', 'success', 'Status Transaksi telah diperbarui')
                                const getTransaksiData = async () => {
                                    let promise = new Promise((resolve, reject) => {
                                        clientRequest('/api/laporan/transaksi', 'GET', '', (status, res) => {
                                            if(status) {
                                                resolve(res.data)
                                            }
                                        })
                                    })
                                    dataTransaksi = await promise
                                    drawDaftarTransaksiTable()
                                    searchTransaksiById(data.transaksi.id)
                                    displayDetailTransaksiData()
                                }
                                getTransaksiData()
                            } else {
                                showToast('Failed', 'error', 'Internal Server Error')
                            }
                        })
                    }
                })
            } else {
                showAlert('Peringatan !', 'warning', 'Data ini belum melunasi Pembayaran, Segera Lakukan Pembayaran untuk melanjutkan status transaksi !')
            }
        }
    })

    const searchTransaksiById = (id) => {
        const selected = dataTransaksi.find(x => x.id == id)
        if(typeof selected !== 'undefined') {
            selectedTransaksi = selected
        } else {
            showAlert('Ups..', 'warning', 'Data Transaksi Tidak Tersedia')
        }
    }

    const displayDetailTransaksiData = () => {
        $.each($('.horizontal-progressbar .progressbar-list'), (index, item) => {
            if(index <= statusTransaksi.findIndex(x => x == selectedTransaksi.status_transaksi)) {
                item.classList.add('active')
            } else {
                item.classList.remove('active')
            }
        })

        for (const key in selectedTransaksi) {
            switch (key) {
                case 'status_transaksi':
                    const statusTransaksi = selectedTransaksi[key]
                    $(`#update-data-modal [name="${key}"]`).html(`<span class="badge bg-light-${statusTransaksi === 'baru' ? 'primary' : statusTransaksi === 'proses' ? 'info' : statusTransaksi === 'selesai' ? 'warning' : 'success'}">${statusTransaksi}</span>`)
                    break;
                case 'status_pembayaran':
                    const statusPembayaran = selectedTransaksi[key]
                    $(`#update-data-modal [name="${key}"]`).html(`<span class="badge bg-light-${statusPembayaran === 'lunas' ? 'success' : 'danger'}">${statusPembayaran}</span> ${statusPembayaran !== 'lunas' ? '(<a href="/transaksi/pembayaran">lakukan pembayaran</a>)' : ''}`)
                    break;
                case 'metode_pembayaran':
                    const metode = selectedTransaksi[key]
                    $(`#update-data-modal [name="${key}"]`).html(`<span class="badge bg-light-${ metode === 'cash' ? 'primary' : metode === 'dp' ? 'info' : 'warning'}">${metode}</span>`)
                    break;
                case 'member':
                    for (const memberKey in selectedTransaksi[key]) {
                        $(`#update-data-modal [name="${memberKey}"]`).html(selectedTransaksi[key][memberKey])
                    }
                    break;
                case 'detail_transaksi':
                    drawDetailPaketTable()
                    break;
                case 'pembayaran':
                    if(selectedTransaksi.status_pembayaran === 'lunas') {
                        for (const pembayaranKey in selectedTransaksi[key]) {
                            $(`#update-data-modal [name="${pembayaranKey}"]`).text(formatNumber(selectedTransaksi[key][pembayaranKey]))
                        }
                        const kembalian = selectedTransaksi[key]['total_pembayaran'] - selectedTransaksi[key]['total_bayar']
                        $(`#update-data-modal [name="kembalian"]`).text(formatNumber(Math.abs(kembalian)))
                        $('#lunas').removeClass('d-none')
                        $('#belum-lunas').addClass('d-none')
                    } else {
                        $('#belum-lunas').removeClass('d-none')
                        $('#lunas').addClass('d-none')
                    }
                    break;
                default:
                    $(`#update-data-modal [name="${key}"]`).html(selectedTransaksi[key])
                    break;
            }
        }

        if(selectedTransaksi.status_transaksi === 'diambil') {
            $('#update-status-transaksi').removeClass('btn-outline-primary')
            $('#update-status-transaksi').addClass('btn-outline-secondary')
        } else {
            $('#update-status-transaksi').addClass('btn-outline-primary')
            $('#update-status-transaksi').removeClass('btn-outline-secondary')

        }
    }

    const drawDetailPaketTable = () => {
        $(`#paket-table`).DataTable().destroy()
        $(`#paket-table`).DataTable({
            searching: false,
            paging: false,
            ordering: false,
            info: false,
            data: selectedTransaksi.detail_transaksi,
            columns: [
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            let index = selectedTransaksi.detail_transaksi.findIndex(x => x.id == data.id)
                            return index + 1
                        } else {
                            return ''
                        }
                    }
                },
                { data: 'paket.nama_paket' },
                { data: 'paket.jenis' },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            return `Rp ${formatNumber(data.harga)}`
                        } else {
                            return ''
                        }
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            return `${data.qty}x`
                        } else {
                            return ''
                        }
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            return `Rp ${formatNumber(data.harga * data.qty)}`
                        } else {
                            return ''
                        }
                    }
                }
            ]
        })
    }

    const getTransaksiData = () => {
        clientRequest('/api/laporan/transaksi', 'GET', '', (status, res) => {
            if(status) {
                dataTransaksi = res.data
                drawDaftarTransaksiTable()
            }
        })
    }

    const drawDaftarTransaksiTable = () => {
        $('#daftar-transaksi-table').DataTable().destroy()
        $('#daftar-transaksi-table').DataTable({
            data: dataTransaksi,
            columns: [
                {
                    data: function(data, type, row) {
                        let index = dataTransaksi.findIndex(x => x.id == data.id)
                        return index + 1
                    }
                },
                { data: 'kode_invoice' },
                { data: 'member.nama' },
                {
                    data: function(data, type, row) {
                        return moment(data.tgl_bayar).format('DD MMM YYYY')
                    }
                },
                {
                    data: function(data, type, row) {
                        return moment(data.batas_waktu).format('DD MMM YYYY')
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            const metode = data.metode_pembayaran
                            return `<span class="badge bg-light-${ metode === 'cash' ? 'primary' : metode === 'dp' ? 'info' : 'warning'}">${metode}</span>`
                        } else {
                            return data.metode_pembayaran
                        }
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            const status = data.status_transaksi
                            return `<span class="badge bg-light-${status === 'baru' ? 'primary' : status === 'proses' ? 'info' : status === 'selesai' ? 'warning' : 'success'}">${status}</span>`
                        } else {
                            return data.status_transaksi
                        }
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            const status = data.status_pembayaran
                            return `<span class="badge bg-light-${status === 'lunas' ? 'success' : 'danger'}">${data.status_pembayaran}</span>`
                        } else {
                            return data.status_pembayaran
                        }
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        if(type === 'display') {
                            return `<div class="d-flex justify-content-center"><button class="d-flex align-items-center btn btn-outline-success rounded-pill fs-6 p-2 update-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#update-data-modal"><i class="bi bi-pencil-square"></i></button></div>`
                        } else {
                            return ''
                        }
                    },
                    orderable: false,
                }
            ]
        })
    }

    const validation = () => {
        if(selectedTransaksi.length === 0) {
            showAlert('Failed', 'error', 'Tidak dapat mengubah data transaksi')
            return false
        } else {
            return true
        }
    }

    getTransaksiData()
})

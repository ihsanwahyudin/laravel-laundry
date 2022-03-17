import clientRequest from "../api.js"
import { formatNumber } from "../utility.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    let dataTransaksi = []
    let displayedTransaksi = {}
    let selectedData = []
    const statusTransaksi = ['baru', 'proses', 'selesai', 'diambil']
    let currentStatus = 'baru'

    $('#daftar-transaksi-table').on('click', '.detail-transaksi', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        searchTransaksiById(id)
        displayDetailTransaksiData()
        console.log(displayedTransaksi)
    })

    $('#daftar-transaksi-table').on('click', '.checkbox-item', function(e) {
        const id = $(this).data('id')
        if(this.checked) {
            const isAvailable = selectedData.find(transaksi => transaksi.id === id)
            if(!isAvailable) {
                const selected = dataTransaksi.find(transaksi => transaksi.id == id)
                selectedData.push(selected)
            }
        } else {
            const index = selectedData.findIndex(transaksi => transaksi.id === id)
            if(index > -1) {
                selectedData.splice(index, 1)
            }
        }
        toggleUpdateButton()
    })

    $('#update-button').on('click', function(e) {
        e.preventDefault()
        if(validation() && currentStatus !== 'diambil') {
            const indexStatus = statusTransaksi.findIndex(x => x == currentStatus)
            if(indexStatus < 2 || selectedData.findIndex(x => x.status_pembayaran !== 'lunas') === -1) {
                showConfirmAlert('Pemberitahuan !', 'warning', `Apakah anda ingin mengubah status transaksi "${statusTransaksi[indexStatus]}" > "${statusTransaksi[indexStatus + 1]}" ?`, 'Yes', (result) => {
                    if(result.isConfirmed) {
                        const data = {
                            data_transaksi: [...selectedData],
                            status_transaksi: statusTransaksi[indexStatus + 1]
                        }
                        clientRequest('/api/transaksi/update/status-transaksi', 'POST', data, async (status, res) => {
                            if(status) {
                                showToast('Success', 'success', 'Status Transaksi telah diperbarui')
                                $('#daftar-transaksi-table').DataTable().destroy()
                                clearForm()
                                drawDaftarTransaksiTable()
                                toggleUpdateButton()
                            } else {
                                showToast('Failed', 'error', 'Internal Server Error')
                            }
                        })
                    }
                })
            } else {
                showAlert('Peringatan', 'warning', 'Terdapat data yang belum lunas')
            }
        }
    })

    $('#update-status-transaksi').on('click', function(e) {
        e.preventDefault()
        if(validation() && displayedTransaksi.status_transaksi !== 'diambil') {
            const currentStatus = statusTransaksi.findIndex(x => x == displayedTransaksi.status_transaksi)
            if(currentStatus < 2 || displayedTransaksi.status_pembayaran === 'lunas') {
                showConfirmAlert('Pemberitahuan !', 'warning', `Apakah anda ingin mengubah status transaksi "${statusTransaksi[currentStatus]}" > "${statusTransaksi[currentStatus + 1]}" ?`, 'Yes', (result) => {
                    if(result) {
                        const data = {
                            transaksi: {
                                id: displayedTransaksi.id,
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

    $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        var target = $(e.target).attr("href") // activated tab
        currentStatus = target
        clearForm()
        $('#daftar-transaksi-table').DataTable().destroy()
        drawDaftarTransaksiTable()
        toggleUpdateButton()
    });

    const searchTransaksiById = (id) => {
        const selected = dataTransaksi.find(x => x.id == id)
        if(typeof selected !== 'undefined') {
            displayedTransaksi = selected
        } else {
            showAlert('Ups..', 'warning', 'Data Transaksi Tidak Tersedia')
        }
    }

    const displayDetailTransaksiData = () => {
        $.each($('.horizontal-progressbar .progressbar-list'), (index, item) => {
            if(index <= statusTransaksi.findIndex(x => x == displayedTransaksi.status_transaksi)) {
                item.classList.add('active')
            } else {
                item.classList.remove('active')
            }
        })

        for (const key in displayedTransaksi) {
            switch (key) {
                case 'status_transaksi':
                    const statusTransaksi = displayedTransaksi[key]
                    $(`#update-data-modal [name="${key}"]`).html(`<span class="badge bg-light-${statusTransaksi === 'baru' ? 'primary' : statusTransaksi === 'proses' ? 'info' : statusTransaksi === 'selesai' ? 'warning' : 'success'}">${statusTransaksi}</span>`)
                    break;
                case 'status_pembayaran':
                    const statusPembayaran = displayedTransaksi[key]
                    $(`#update-data-modal [name="${key}"]`).html(`<span class="badge bg-light-${statusPembayaran === 'lunas' ? 'success' : 'danger'}">${statusPembayaran}</span> ${statusPembayaran !== 'lunas' ? '(<a href="/transaksi/pembayaran">lakukan pembayaran</a>)' : ''}`)
                    break;
                case 'metode_pembayaran':
                    const metode = displayedTransaksi[key]
                    $(`#update-data-modal [name="${key}"]`).html(`<span class="badge bg-light-${ metode === 'cash' ? 'primary' : metode === 'dp' ? 'info' : 'warning'}">${metode}</span>`)
                    break;
                case 'member':
                    for (const memberKey in displayedTransaksi[key]) {
                        $(`#update-data-modal [name="${memberKey}"]`).html(displayedTransaksi[key][memberKey])
                    }
                    break;
                case 'detail_transaksi':
                    drawDetailPaketTable()
                    break;
                case 'pembayaran':
                    if(displayedTransaksi.status_pembayaran === 'lunas') {
                        for (const pembayaranKey in displayedTransaksi[key]) {
                            $(`#update-data-modal [name="${pembayaranKey}"]`).text(formatNumber(displayedTransaksi[key][pembayaranKey]))
                        }
                        const kembalian = displayedTransaksi[key]['total_pembayaran'] - displayedTransaksi[key]['total_bayar']
                        $(`#update-data-modal [name="kembalian"]`).text(formatNumber(Math.abs(kembalian)))
                        $('#lunas').removeClass('d-none')
                        $('#belum-lunas').addClass('d-none')
                    } else {
                        $('#belum-lunas').removeClass('d-none')
                        $('#lunas').addClass('d-none')
                    }
                    break;
                default:
                    $(`#update-data-modal [name="${key}"]`).html(displayedTransaksi[key])
                    break;
            }
        }

        toggleUpdateButton()
    }

    const toggleUpdateButton = () => {
        if(selectedData.length === 0) {
            $('#update-button').removeClass('btn-primary')
            $('#update-button').addClass('btn-secondary')
        } else {
            $('#update-button').addClass('btn-primary')
            $('#update-button').removeClass('btn-secondary')
        }
    }

    const drawDetailPaketTable = () => {
        $(`#paket-table`).DataTable().destroy()
        $(`#paket-table`).DataTable({
            searching: false,
            paging: false,
            ordering: false,
            info: false,
            data: displayedTransaksi.detail_transaksi,
            columns: [
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            let index = displayedTransaksi.detail_transaksi.findIndex(x => x.id == data.id)
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

    // const getTransaksiData = () => {
    //     clientRequest('/api/laporan/transaksi', 'GET', '', (status, res) => {
    //         if(status) {
    //             dataTransaksi = res.data
    //             drawDaftarTransaksiTable()
    //         }
    //     })
    // }

    const drawDaftarTransaksiTable = () => {
        $('#daftar-transaksi-table').DataTable().destroy()
        $('#daftar-transaksi-table').DataTable({
            ajax: {
                url: `/api/data/transaksi/${currentStatus}`,
                dataSrc: function ( json ) {
                    dataTransaksi = json
                    return json
                }
            },
            columns: [
                {
                    render: function(data, type, row, meta) {
                        return meta.row + 1
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
                            return `<div class="d-flex justify-content-center"><button type="button" class="d-flex align-items-center btn btn-outline-primary rounded-pill fs-6 p-2 detail-transaksi" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#update-data-modal"><i class="bi bi-exclamation-circle"></i></button></div>`
                        } else {
                            return ''
                        }
                    },
                    orderable: false,
                },
                {
                    render: function(data, type, row, meta) {
                        if(type === 'display') {
                            return `<div class="d-flex justify-content-center"><input type="checkbox" class="form-check-input checkbox-item" data-id="${row.id}" ${row.status_transaksi === 'diambil' ? 'disabled' : ''}></div>`
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
        if(currentStatus === 'diambil') {
            showAlert('Peringatan', 'warning', 'Transaksi sudah diambil')
            return false
        } else if(selectedData.length === 0) {
            showAlert('Peringatan', 'warning', 'Pilih data terlebih dahulu')
            return false
        } else {
            return true
        }
    }

    const clearForm = () => {
        selectedData = []
        displayedTransaksi = {}
    }

    // getTransaksiData()
    drawDaftarTransaksiTable()
})

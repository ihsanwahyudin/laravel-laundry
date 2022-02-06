import clientRequest from "../api.js"

$(function() {
    let dataTransaksi = []

    const getTransaksiData = () => {
        clientRequest('/api/laporan/transaksi', 'GET', '', (status, res) => {
            if(status) {
                dataTransaksi = res.data
                drawDaftarTransaksiTable()
            }
        })
    }

    const drawDaftarTransaksiTable = () => {
        $('#daftar-transaksi-table').DataTable({
            data: dataTransaksi,
            columns: [
                { data: 'id' },
                { data: 'kode_invoice' },
                { data: 'member.nama' },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            return moment(data.tgl_bayar).format('DD MMM YYYY')
                        } else {
                            return ''
                        }
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            return moment(data.batas_waktu).format('DD MMM YYYY')
                        } else {
                            return ''
                        }
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            const metode = data.metode_pembayaran
                            return `<span class="badge bg-light-${ metode === 'cash' ? 'primary' : metode === 'dp' ? 'info' : 'warning'}">${metode}</span>`
                        } else {
                            return ''
                        }
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            const status = data.status_transaksi
                            return `<span class="badge bg-light-${status === 'baru' ? 'primary' : status === 'proses' ? 'info' : status === 'selesai' ? 'warning' : 'diambil'}">${status}</span>`
                        } else {
                            return ''
                        }
                    }
                },
                {
                    data: function(data, type, row) {
                        if(type === 'display') {
                            const status = data.status_pembayaran
                            return `<span class="badge bg-light-${status === 'lunas' ? 'success' : 'danger'}">${data.status_pembayaran}</span>`
                        } else {
                            return ''
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

    getTransaksiData()
})

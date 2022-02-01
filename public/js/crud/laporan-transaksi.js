import clientRequest from '../api.js'

$(function() {
    let laporanData = []

    $('#export-txt').click(function() {
        let dataText = ''
        laporanData.map((item, index) => {
            dataText += `${index + 1}.\tNo Invoice\t\t: ${item.kode_invoice}\n\tNama Member\t\t: ${item.member.nama}\n\tTanggal Bayar\t\t: ${item.tgl_bayar}\n\tBatas Waktu\t\t: ${item.batas_waktu}\n\tMetode Pembayaran\t: ${item.metode_pembayaran}\n\tStatus Transaksi\t: ${item.status_transaksi}\n\tStatus Pembayaran\t: ${item.status_pembayaran}\n\n`
        })
        download(dataText, 'laporan-transaksi.txt', 'text/plain')
    })

    const getTransaksiData = () => {
        clientRequest('/api/laporan/transaksi', 'GET', '', (status, res) => {
            if(status) {
                laporanData = res.data
                drawLaporanTable()
            }
        })
    }

    const drawLaporanTable = () => {
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
                                    return '<span class="badge bg-light-warning">diambil</span>'
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
                            return `<div class="d-flex justify-content-center"><button class="d-flex align-items-center btn btn-outline-primary rounded-pill fs-6 p-2 delete-btn" data-id="${row.id}"><i class="bi bi-info-circle"></i></button></div>`
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

import { formatNumber } from "../utility.js"

$(function(){
    const getPemasukanHarian = async () => {
        try {
            const response = await axios.get('/api/laporan/income-per-day/current-month')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    const getPemasukanBulanIni = async () => {
        try {
            const response = await axios.get('/api/laporan/income/current-month')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    const getJumlahTransaksi = async () => {
        try {
            const response = await axios.get('/api/laporan/transaction-amount')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    const getJumlahMember = async () => {
        try {
            const response = await axios.get('/api/laporan/number-of-member')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    const getAktivitasTerbaru = async () => {
        try {
            const response = await axios.get('/api/laporan/recently-activity')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    const getTransaksiTerbaru = async () => {
        try {
            const response = await axios.get('/api/laporan/latest-transaction/4')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    const getJumlahTransaksiPerStatusTransaksi = async () => {
        try {
            const response = await axios.get('/api/laporan/amount-of-transaction/per-status-transaction')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    const getJumlahTransaksiPerHariPerStatusTransaksi = async () => {
        try {
            const response = await axios.get('/api/laporan/amount-of-transaction/per-day-per-status-transaction')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    const getDataMemberPerGender = async () => {
        try {
            const response = await axios.get('/api/laporan/number-of-member/per-gender')
            return response.data
        } catch (err) {
            console.error(err)
        }
    }

    getPemasukanHarian().then((data) => {
        var optionsPemasukanHarian = {
            annotations: {
                position: 'back'
            },
            dataLabels: {
                enabled:false
            },
            chart: {
                type: 'bar',
                height: 300
            },
            fill: {
                opacity:1
            },
            plotOptions: {
            },
            series: [{
                name: 'sales',
                data: data.map(item => item.pemasukan)
            }],
            colors: '#435ebe',
            xaxis: {
                categories: data.map(item => moment(item.tanggal, "YYYY-MM-DD").format('DD MMM')),
            },
        }
        var chartPemasukanHarian = new ApexCharts(document.querySelector("#chart-pemasukan-harian"), optionsPemasukanHarian)
        chartPemasukanHarian.render()
    })

    getPemasukanBulanIni().then((data) => {
        $('#pemasukan').text(formatNumber(data))
    })

    getJumlahTransaksi().then((data) => {
        $('#jumlah-transaksi').text(formatNumber(data))
    })

    getJumlahMember().then((data) => {
        $('#jumlah-member').text(formatNumber(data))
    })

    getJumlahTransaksiPerStatusTransaksi().then((data) => {
        data.map(item => {
            $(`#jumlah-status-${item.status_transaksi}`).text(item.jumlah)
        })
    })

    getTransaksiTerbaru().then((data) => {
        let card = ''
        data.map(item => {
            card +=
            `<div class="recent-message d-flex px-4 py-3">
                <div class="avatar avatar-lg">
                    <img src="/vendors/mazer/dist/assets/images/faces/${getRandomInt(1,5)}.jpg" />
                </div>
                <div class="name ms-4">
                    <h5 class="mb-1">${item.member.nama}</h5>
                    <small class="text-muted mb-0">Baru saja melakukan transaksi dengan no invoice "${item.kode_invoice}"</small>
                </div>
            </div>`
        })
        $('#transaksi-terbaru').html(card)
    })

    getAktivitasTerbaru().then((data) => {
        let tableData = ''
        for (const date in data) {
            data[date].map(item => {
                let activityXML = ''
                if ('kode_invoice' in item) {
                    activityXML += `Melakukan transaksi dengan nomor invoice "${item.kode_invoice}"`
                } else {
                    const allowedColumn = ['nama', 'nama_paket', 'nama_member', 'name']
                    let dataName = ''
                    for (const list of item.detail_log_activity) {
                        if(allowedColumn.includes(list.table_column_list.column_name)) {
                            dataName = list.data
                            break;
                        }
                    }
                    activityXML +=
                    item.action === "1" ?
                        `Menambah data "${dataName}" pada tabel ${item.reference_table.table_name.replace('tb_', '')}` :
                    item.action === "2" ?
                        `Membaca` :
                    item.action === "3" ?
                        `Mengubah data "${dataName}" pada tabel ${item.reference_table.table_name.replace('tb_', '')}` :
                    item.action === "4" ?
                        `Menghapus data "${dataName}" pada tabel ${item.reference_table.table_name.replace('tb_', '')}` :
                    item.action === "5" ?
                        `Login dengan IP Address "${item.detail_log_activity[0].data}"` :
                    ""
                }
                tableData +=
                `<tr>
                    <td class="col-3">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-md">
                                <img src="/vendors/mazer/dist/assets/images/faces/${getRandomInt(1,5)}.jpg" />
                            </div>
                            <p class="font-bold ms-3 mb-0">${item.user.name}</p>
                        </div>
                    </td>
                    <td class="col-auto">
                        <p class="mb-0">${activityXML}</p>
                    </td>
                </tr>`
            })
        }

        $('#aktivitas-terbaru tbody').html(tableData)
    })

    getDataMemberPerGender().then((data) => {
        let optionsMemberData  = {
            series: data.map(item => item.jumlah),
            labels: data.map(item => item.jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan'),
            colors: ['#435ebe','#55c6e8'],
            chart: {
                type: 'donut',
                width: '100%',
                height:'350px'
            },
            legend: {
                position: 'bottom'
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '30%'
                    }
                }
            }
        }
        var chartMemberData = new ApexCharts(document.getElementById('chart-member-data'), optionsMemberData)
        chartMemberData.render()
    })

    // getJumlahTransaksiPerHariPerStatusTransaksi().then(data => {
    //     const colors = ['#5350e9', '#008b75', '#dc3545', '#ffc107', '#17a2b8']
    //     let index = 0
    //     for (const status in data) {
    //         let optionsStatus = {
    //             series: [{
    //                 name: 'jumlah',
    //                 data: data[status].map(item => item.jumlah),
    //             }],
    //             chart: {
    //                 height: 80,
    //                 type: 'area',
    //                 toolbar: {
    //                     show:false,
    //                 },
    //             },
    //             colors: [colors[index]],
    //             stroke: {
    //                 width: 2,
    //             },
    //             grid: {
    //                 show:false,
    //             },
    //             dataLabels: {
    //                 enabled: false
    //             },
    //             xaxis: {
    //                 type: 'datetime',
    //                 categories: data[status].map(item => item.tanggal),
    //                 axisBorder: {
    //                     show:false
    //                 },
    //                 axisTicks: {
    //                     show:false
    //                 },
    //                 labels: {
    //                     show:false,
    //                 }
    //             },
    //             show:false,
    //             yaxis: {
    //                 labels: {
    //                     show:false,
    //                 },
    //             },
    //             tooltip: {
    //                 x: {
    //                     format: 'dd/MM/yy'
    //                 },
    //             },
    //         }
    //         let chartStatus = new ApexCharts(document.querySelector(`#chart-status-${status}`), optionsStatus)
    //         chartStatus.render()
    //         index++
    //     }
    // })

    const getRandomInt = (min, max) => {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    // let optionsAmerica = {
    //     ...optionsEurope,
    //     colors: ['#008b75'],
    // }
    // let optionsIndonesia = {
    //     ...optionsEurope,
    //     colors: ['#dc3545'],
    // }

    // let optionsStatusDiambil = {
    //     ...optionsEurope,
    //     colors: ['#f6c23e'],
    // }



    // var chartEurope = new ApexCharts(document.querySelector("#chart-europe"), optionsEurope);
    // var chartAmerica = new ApexCharts(document.querySelector("#chart-america"), optionsAmerica);
    // var chartIndonesia = new ApexCharts(document.querySelector("#chart-indonesia"), optionsIndonesia);
    // var chartStatusDiambil = new ApexCharts(document.querySelector('#chart-status-diambil'), optionsStatusDiambil);

    // chartIndonesia.render();
    // chartAmerica.render();
    // chartEurope.render();
    // chartMemberData.render()
    // chartStatusDiambil.render()
})

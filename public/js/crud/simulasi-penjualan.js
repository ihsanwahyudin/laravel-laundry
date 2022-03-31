import { formatNumber } from "../utility.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    let allDataPenjualan = []
    localStorage.getItem('allDataPenjualan') && allDataPenjualan.push(...JSON.parse(localStorage.getItem('allDataPenjualan')))
    const ketentuanBarang = [
        {
            nama_barang: "gantungan kunci",
            harga_satuan: 5000,
            satuan: "pcs"
        },
        {
            nama_barang: "ikat rambut",
            harga_satuan: 2500,
            satuan: "pcs"
        }
    ]

    function renderDataBarang(arr) {
        let xml = '<option selected disabled value="">Pilih Barang</option>'
        arr.map(item => {
            xml +=
            `<option value="${item.nama_barang}">${item.nama_barang}</option>`
        })
        $('#barang-dibeli').html(xml)
    }

    renderDataBarang(ketentuanBarang)

    $('#form-data').on('submit', function(e) {
        e.preventDefault()
        const data = new FormData(this)
        const isAvailableID = allDataPenjualan.find(x => x.no_transaksi == data.get('no_transaksi'))
        if(!isAvailableID) {
            insert(data)
            showAlert('Success !', 'success', 'Berhasil menambahkan data baru')
            renderTable(allDataPenjualan)
            clearForm()
        } else {
            showAlert('Peringatan !', 'warning', 'Data sudah ada')
        }
    })

    $('#sorting').on('click', function(e) {
        e.preventDefault()
        const groupBy = $('#group-by').val()
        const orderBy = $('#order-by').val()
        if(groupBy && orderBy) {
            const sorted = bubbleSort(allDataPenjualan, allDataPenjualan.length, orderBy, groupBy)
            renderTable(sorted)
        }

    })

    $('#search').on('keypress', function(e) {
        if (e.keyCode === 13) {
            const text = $("#search").val()
            const arr = linearSearch(allDataPenjualan, text)
            renderTable(arr)
        }
    })

    $('#btnSearch').on('click', function(e) {
        const text = $("#search").val()
        const arr = linearSearch(allDataPenjualan, text)
        renderTable(arr)
    })

    const insert = (data) => {
        // Membuat variable untuk menampung data penjualan dalam 1 transaksi
        let obj = {}
        // Menambahkan data ke obj
        for (const key of data) {
            obj[key[0]] = key[0] === 'no_transaksi' || key[0] === 'jumlah_beli' ? parseInt(key[1]) : key[1]
        }
        obj["harga"] = ketentuanBarang.find(item => item.nama_barang === obj["nama_barang"]).harga_satuan
        obj["diskon"] = calculateDiskon(obj)
        obj["total_harga"] = obj["harga"] * obj["jumlah_beli"]
        // Menambahkan data Object ke array allDataPenjualan
        allDataPenjualan.push(obj)
        // Melakukan penyimpanan allDataPenjualan ke local storage
        localStorage.setItem('allDataPenjualan', JSON.stringify(allDataPenjualan))
    }

    function calculateDiskon(data) {
        // Menentukan nilai persentase diskon
        const persentase = 20
        let diskon = 0
        let total = data.harga * data.jumlah_beli
        if(total > 30000 || data.jumlah_beli >= 10) {
            // Melakukan perhitungan diskon sederhana
            diskon = total * persentase / 100
        }
        // Mengembalikan nilai dari hasil perhitungan
        return diskon
    }

    const linearSearch = (arr, text) => {
        // Melakukan Pengecekan jika text === kosong
        if(text !== '' && text !== null) {
            // Deklarasi Variable untuk menampung semua data yang telah di cari
            let data = []
            // Melakukan Perulangan setiap index pada array multidimensi
            for (let index = 0; index < arr.length; index++) {
                // Membuat Variable untuk menentukan kondisi data telah berhasil di cari atau tidak ada sama sekali
                let isFind = false
                // Melakukan iterasi pada setiap key dalam object array yang terpilih
                for (const key in arr[index]) {
                    // Membuat variable untuk menampung nilai dari data yang akan dibandingkan
                    const value = arr[index][key].toString()
                    // Melakukan perulangan pada setiap huruf berdasarkan panjang text yang di masukan
                    for (let x = 0; x < value.length; x++) {
                        // Melakukan perbadingan huruf / text
                        if (value.substring(x, x + text.length).toLowerCase() == text.toLowerCase()) {
                            data.push(allDataPenjualan[index])
                            isFind = true
                            break
                        }
                    }
                    // Melakukan pengecekan jika data sudah ditemukan
                    if(isFind) {
                        break
                    }
                }
            }
            // Mengembalikan array yang telah di searching
            return data
        } else {
            // Mengembalikan array sebelumnya karena text yang di masukan itu null atau kosong
            return allDataPenjualan
        }
    }

    function insertionSort(arr, n, orderBy, groupBy) {
        // Melakukan Perulangan pada Array
        for (let i = 1; i < n; i++) {
            // Membuat Variable untuk menampung data sementara
            let temp = arr[i]
            let key = arr[i][groupBy]
            let j = i - 1

            // Melakukan pengkondisian sorting Ascending (Menaik) dan Descending (Menurun)
            if(orderBy !== 'desc') {
                // Melakukan perulangan untuk melakukan perbandingan data yang lebih besar
                while (j >= 0 && arr[j][groupBy] > key) {
                    arr[j + 1] = arr[j]
                    j = j - 1
                }
            } else {
                // Melakukan perulangan untuk melakukan perbandingan data yang lebih kecil
                while (j >= 0 && arr[j][groupBy] < key) {
                    arr[j + 1] = arr[j]
                    j = j - 1
                }
            }
            // Mengisi data hasil perbandingan dengan variable temporary
            arr[j + 1] = temp
        }
        // mengembalikan array yang telah di urutkan (sorting)
        return arr
    }

    function selectionSort(arr, n, orderBy, groupBy)
    {
        function swap(arr,xp, yp)
        {
            var temp = arr[xp]
            arr[xp] = arr[yp]
            arr[yp] = temp
        }
        var i, j, min_idx

        // Melakukan perpindahan pada setiap index dalam array
        for (i = 0; i < n-1; i++)
        {
            // Mencari minimum element dalam array
            min_idx = i
            for (j = i + 1; j < n; j++) {
                if(orderBy !== 'desc') {
                    if (arr[j][groupBy] < arr[min_idx][groupBy]) {
                        min_idx = j
                    }
                } else {
                    if (arr[j][groupBy] > arr[min_idx][groupBy]) {
                        min_idx = j
                    }
                }
                // Melakukan swap jika element ditemukan
                swap(arr, min_idx, i)
            }
        }
        return arr
    }

    // An optimized version of Bubble Sort
    function bubbleSort(arr, n, orderBy, groupBy) {
        function swap(arr, xp, yp) {
            var temp = arr[xp]
            arr[xp] = arr[yp]
            arr[yp] = temp
        }
        var i, j;
        for (i = 0; i < n-1; i++) {
            for (j = 0; j < n-i-1; j++) {
                if(orderBy !== 'desc') {
                    if (arr[j][groupBy] > arr[j+1][groupBy]) {
                        swap(arr,j,j+1)
                    }
                } else {
                    if (arr[j][groupBy] < arr[j+1][groupBy]) {
                        swap(arr,j,j+1)
                    }
                }
            }
        }
        return arr
    }

    function renderTable(data) {
        let xml = ''
        if (data.length !== 0) {
            // Melakukan looping
            let totalHarga = 0
            let totalQTY = 0
            let totalDiskon = 0
            let totalPembayaran = 0
            data.map((item, index) => {
                totalHarga += item.harga
                totalQTY += item.jumlah_beli
                totalDiskon += item.diskon
                totalPembayaran += item.total_harga - item.diskon
                return xml += `
                <tr>
                    <td>${item.no_transaksi}</td>
                    <td>${moment(item.tanggal_beli).format('DD MMMM YYYY')}</td>
                    <td>${item.nama_barang}</td>
                    <td>${item.warna}</td>
                    <td>Rp ${formatNumber(item.harga)}</td>
                    <td>${item.jumlah_beli}</td>
                    <td>${item.nama_pembeli}</td>
                    <td>Rp ${formatNumber(item.diskon)}</td>
                    <td>Rp ${formatNumber(item.total_harga)}</td>
                </tr>`
            })
            xml += `
            <tr>
                <th colspan="4" class="table-primary text-primary">Total</td>
                <th>Rp ${formatNumber(totalHarga)}</td>
                <th>${totalQTY}</td>
                <th class="table-primary text-primary"></td>
                <th>Rp ${formatNumber(totalDiskon)}</td>
                <th>Rp ${formatNumber(totalPembayaran)}</td>
            </tr>`
        } else {
            xml = `
            <tr>
                <td colspan="9">Data Kosong</td>
            </tr>`
        }
        $('.table tbody').html(xml)
    }

    const clearForm = () => {
        $('#form-data').trigger('reset')
    }

    renderTable(allDataPenjualan)
})

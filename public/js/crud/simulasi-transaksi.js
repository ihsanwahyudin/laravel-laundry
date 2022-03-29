import { formatNumber } from "../utility.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    const allDataBarang = []
    localStorage.getItem('allDataBarang') && allDataBarang.push(...JSON.parse(localStorage.getItem('allDataBarang')))
    let dataBarang = {
        nama_barang: '',
        harga: 0,
        jumlah: 0,
        diskon: 0,
        total_harga: 0,
        jenis_pembayaran: '',
        tanggal_beli: ''
    }
    let isCheckedCash = true
    let isCheckedEmoney = true

    $('#nama-barang').on('change', function() {
        const value = $(this).val()
        switch (value) {
            case "detergen":
                dataBarang.nama = "Detergen"
                dataBarang.harga = 15000
                break;
            case "pewangi":
                dataBarang.nama = "Pewangi"
                dataBarang.harga = 10000
                break;
            case "detergen sepatu":
                dataBarang.nama = "Detergen Sepatu"
                dataBarang.harga = 25000
                break;
        }
        $('#harga').text(formatNumber(dataBarang.harga))
    })

    $('#form-data').on('submit', function(e) {
        e.preventDefault()
        const data = new FormData(this)
        insert(data)
        showAlert('Success !', 'success', 'Berhasil menambahkan data baru')
        renderTable(allDataBarang)
        enableCheckbox()
        clearForm()
    })

    $('#sorting').on('click', function(e) {
        e.preventDefault()
        if(isCheckedCash && isCheckedEmoney) {
            const sort = insertionSort(allDataBarang, allDataBarang.length, 'desc', 'id')
            renderTable(sort)
        } else if(isCheckedCash) {
            const arr = filterJenisPembayaran(allDataBarang, 'cash')
            const sort = insertionSort(arr, arr.length, 'desc', 'id')
            renderTable(sort)
        } else if(isCheckedEmoney) {
            const arr = filterJenisPembayaran(allDataBarang, 'e-money/transfer')
            const sort = insertionSort(arr, arr.length, 'desc', 'id')
            renderTable(sort)
        } else {
            renderTable([])
        }

    })

    $('.checkbox-jenis-pembayaran').on('change', function() {
        const value = $(this).val()
        isCheckedCash = $('#checkbox-cash').is(':checked')
        isCheckedEmoney = $('#checkbox-e-money-transfer').is(':checked')
        if(isCheckedCash && isCheckedEmoney) {
            renderTable(allDataBarang)
        } else if(isCheckedCash) {
            const arr = filterJenisPembayaran(allDataBarang, 'cash')
            renderTable(arr)
        } else if(isCheckedEmoney) {
            const arr = filterJenisPembayaran(allDataBarang, 'e-money/transfer')
            renderTable(arr)
        } else {
            renderTable([])
        }
    })

    $('#search').on('keypress', function(e) {
        if (e.keyCode === 13) {
            const text = $("#search").val()
            const arr = searching(allDataBarang, text)
            renderTable(arr)
            enableCheckbox()
        }
    })

    $('#btnSearch').on('click', function(e) {
        const text = $("#search").val()
        const arr = searching(allDataBarang, text)
        renderTable(arr)
        enableCheckbox()
    })

    const filterJenisPembayaran = (data, jenis) => {
        const arr = []
        data.forEach(item => {
            if(item.jenis_pembayaran === jenis) {
                arr.push(item)
            }
        })
        return arr
    }

    const insert = (data) => {
        // Menambahkan data ke obj
        for (const key of data) {
            dataBarang[key[0]] = key[0] === 'id' || key[0] === 'jumlah' ? parseInt(key[1]) : key[1]
        }
        dataBarang.total_harga = dataBarang.harga * dataBarang.jumlah
        dataBarang.diskon = dataBarang.total_harga > 50000 ? calculateDiskon(dataBarang) : 0
        dataBarang.subtotal = dataBarang.total_harga - dataBarang.diskon
        // Menambahkan data Object ke array allDataBarang
        allDataBarang.push(dataBarang)
        // Melakukan penyimpanan allDataBarang ke local storage
        localStorage.setItem('allDataBarang', JSON.stringify(allDataBarang))
    }

    const calculateDiskon = (data) => {
        // Menentukan nilai persentase diskon
        const persentase = 15
        // Melakukan perhitungan diskon sederhana
        let diskon = data.total_harga * persentase / 100
        // Mengembalikan nilai dari hasil perhitungan
        return diskon
    }

    const searching = (arr, text) => {
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
                    // Melakukan pengecekan jika data sudah ditemukan
                    if(!isFind) {
                        // Membuat variable untuk menampung nilai dari data yang akan dibandingkan
                        const value = arr[index][key].toString()
                        // Melakukan perulangan pada setiap huruf berdasarkan panjang text yang di masukan
                        for (let x = 0; x < value.length; x++) {
                            // Melakukan perbadingan huruf / text
                            if (value.substring(x, x + text.length).toLowerCase() == text.toLowerCase()) {
                                data.push(allDataBarang[index])
                                isFind = true
                                break
                            }
                        }
                    }
                }
            }
            // Mengembalikan array yang telah di searching
            return data
        } else {
            // Mengembalikan array sebelumnya karena text yang di masukan itu null atau kosong
            return allDataBarang
        }
    }

    const insertionSort = (arr, n, orderBy, groupBy) => {
        // Melakukan Perulangan pada Array
        for (let i = 1; i < n; i++) {
            // Membuat Variable untuk menampung data sementara
            let temp = arr[i]
            let key = arr[i][groupBy]
            let j = i - 1

            // Melakukan pengkondisian sorting Ascending (Menaik) dan Descending (Menurun)
            if(orderBy === 'desc') {
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

    const renderTable = (data) => {
        let xml = ''
        if (data.length !== 0) {
            // Melakukan looping
            let totalHarga = 0
            let totalQTY = 0
            let totalDiskon = 0
            let totalPembayaran = 0
            data.map((item, index) => {
                totalHarga += item.harga
                totalQTY += item.jumlah
                totalDiskon += item.diskon
                totalPembayaran += item.subtotal
                return xml += `
                <tr>
                    <td>${item.id}</td>
                    <td>${moment(item.tanggal_beli).format('DD MMMM YYYY')}</td>
                    <td>${item.nama_barang}</td>
                    <td>Rp ${formatNumber(item.harga)}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${formatNumber(item.diskon)}</td>
                    <td>Rp ${formatNumber(item.subtotal)}</td>
                    <td>${item.jenis_pembayaran}</td>
                </tr>`
            })
            xml += `
            <tr>
                <th colspan="3" class="table-primary text-primary">Total</td>
                <th>Rp ${formatNumber(totalHarga)}</td>
                <th>${totalQTY}</td>
                <th>Rp ${formatNumber(totalDiskon)}</td>
                <th>Rp ${formatNumber(totalPembayaran)}</td>
                <th></th>
            </tr>`
        } else {
            xml = `
            <tr>
                <td colspan="8">Data Kosong</td>
            </tr>`
        }
        $('.table tbody').html(xml)
    }

    const clearForm = () => {
        $('#form-data').trigger('reset')
        $('#harga').text(0)
        dataBarang = {
            nama_barang: '',
            harga: 0,
            jumlah: 0,
            total_harga: 0,
            jenis_pembayaran: '',
            tanggal_beli: ''
        }
    }

    const enableCheckbox = () => {
        isCheckedCash = true
        isCheckedEmoney = true
        $('.checkbox-jenis-pembayaran').prop('checked', true)
    }
    enableCheckbox()

    renderTable(allDataBarang)
})

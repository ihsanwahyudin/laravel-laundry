import { formatNumber } from "../utility.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    const dataKaryawan = []
    localStorage.getItem('dataKaryawan') && dataKaryawan.push(...JSON.parse(localStorage.getItem('dataKaryawan')))

    // const getDataKaryawan = async ()  => {
    //     try {
    //         const res = await axios.get('/data/karyawan')
    //         return res.data
    //     } catch (error) {
    //         console.log(res)
    //     }
    // }

    // getDataKaryawan().then(data => {
    //     let xml = '<option selected disabled value="">Pilih Karyawan</option>'
    //     data.map(item => {
    //         xml += `
    //             <option value="${item.id}">${item.name}</option>
    //         `
    //     })
    //     $('#id_karyawan').html(xml)
    // })

    $('#status-menikah').on('change', function() {
        const value = $(this).val()
        if (value === 'single') {
            $('#jumlah-anak').attr('readonly', '')
            $('#jumlah-anak').val(0)
        } else {
            $('#jumlah-anak').removeAttr('readonly')
        }
    })

    $('#form-data').on('submit', function(e) {
        e.preventDefault()
        const data = new FormData(this)
        insert(data)
        showAlert('Success !', 'success', 'Berhasil menambahkan data baru')
        renderTable(dataKaryawan)
        clearForm()
    })

    $('#sorting').on('change', function(e) {
        e.preventDefault()
        const orderBy = $(this).val()
        const groupBy = $('#group-by').val()
        if(orderBy) {
            const sort = insertionSort(dataKaryawan, dataKaryawan.length, orderBy, groupBy)
            renderTable(dataKaryawan)
        }
    })

    $('#group-by').on('change', function(e) {
        e.preventDefault()
        const groupBy = $(this).val()
        const orderBy = $('#sorting').val()
        if(orderBy) {
            const sort = insertionSort(dataKaryawan, dataKaryawan.length, orderBy, groupBy)
            renderTable(dataKaryawan)
        }
    })

    $('#search').on('keypress', function(e) {
        if (e.keyCode === 13) {
            const text = $("#search").val()
            const arr = searching(dataKaryawan, text)
            renderTable(arr)
        }
    })

    $('.table tbody').on('click', '.delete-btn', function(e) {
        e.preventDefault()
        const index = $(this).data('index')
        showConfirmAlert('Peringatan !', 'warning', `Apakah anda ingin menghapus data ini "${dataKaryawan[index].nama}" ?`, 'Yes', (result) => {
            if(result.isConfirmed) {
                deleteData(index)
                renderTable(dataKaryawan)
                showAlert('Success !', 'success', 'Data Berhasil di hapus !')
            }
        })
    })

    const insert = (data) => {
        const obj = {}
        // Menambahkan data ke obj
        for (const key of data) {
            obj[key[0]] = key[0] === 'id' || key[0] === 'jumlah_anak' ? parseInt(key[1]) : key[1]
        }
        obj['gaji_awal'] = 2000000
        obj['tunjangan'] = calculateTunjangan(obj)
        obj['total_gaji'] = obj['gaji_awal'] + obj['tunjangan']

        // Menambahkan data Object ke array dataKaryawan
        dataKaryawan.push(obj)
        // Melakukan penyimpanan dataKaryawan ke local storage
        localStorage.setItem('dataKaryawan', JSON.stringify(dataKaryawan))
    }

    const calculateAge = (birthday) => {
        // Melakukan Konversi data string tanggal mulai bekerja ke Date format JavaScript dengan default timezone device system
        birthday = new Date(birthday)
        // Melakukan perhitungan tanggal sekarang dengan tanggal mulai bekerja dengan mengembalikan nilai integer
        var ageDifMs = Date.now() - birthday.getTime()
        // Melakukan konversi data integer Date ke dalam Date format JavaScript
        var ageDate = new Date(ageDifMs)
        // Mengembalikan total bekerja dalam bentuk tahun
        return Math.abs(ageDate.getUTCFullYear() - 1970)
    }

    const calculateTunjangan = (data) => {
        // Menentukan jumlah kenaikan gaji pertahun
        const kenaikanGajiPertahun = 150000
        // Melakukan pengecekan jika karyawan sudah menikah atau belum menikah
        if(data.status_menikah === 'couple') {
            // Menentukan jumlah tunjangan untuk karyawan yang sudah menikah
            const tunjanganMenikah = 250000
            // Menentukan jumlah tunjangan anak untuk karyawan yang sudah menikah
            const tunjanganPerAnak = 150000

            // Membuat variable untuk menampung total tunjangan
            let totalTunjangan = 0
            // Melakukan Perhitungan Total Tunjangan berdasarkan data karyawan yang di masukan
            totalTunjangan += kenaikanGajiPertahun * calculateAge(data.mulai_bekerja)
            totalTunjangan += tunjanganMenikah
            totalTunjangan += (data.jumlah_anak > 2) ? tunjanganPerAnak * 2 : tunjanganPerAnak * data.jumlah_anak
            // Mengembalikan hasil dari perhitungan
            return totalTunjangan
        } else {
            // Membuat variable untuk menampung total tunjangan
            let totalTunjangan = 0
            // Melakukan Perhitungan Total Tunjangan berdasarkan data karyawan yang di masukan
            totalTunjangan += kenaikanGajiPertahun * calculateAge(data.mulai_bekerja)
            // Mengembalikan hasil dari perhitungan
            return totalTunjangan
        }
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
                                data.push(dataKaryawan[index])
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
            return dataKaryawan
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

    const deleteData = (index) => {
        // Melakukan hapus pada array dataKaryawan berdasarkan Index yang di pilih
        dataKaryawan.splice(index, 1)
        // Melakukan penyimpanan dataKaryawan ke local storage
        localStorage.setItem('dataKaryawan', JSON.stringify(dataKaryawan))
    }

    const renderTable = (data) => {
        let xml = ''
        if (data.length !== 0) {
            // Melakukan looping
            let totalGajiAwal = 0
            let totalTunjangan = 0
            let totalkeseluruhan = 0
            data.map((item, index) => {
                totalGajiAwal += item.gaji_awal
                totalTunjangan += item.tunjangan
                return xml += `
                <tr>
                    <td>${item.id}</td>
                    <td>${item.nama}</td>
                    <td>${item.jk == 'L' ? 'Laki-laki' : 'Perempuan'}</td>
                    <td>${item.status_menikah}</td>
                    <td>${item.jumlah_anak}</td>
                    <td>${moment(item.mulai_bekerja).format('DD MMMM YYYY')}</td>
                    <td>Rp ${formatNumber(item.gaji_awal)}</td>
                    <td>Rp ${formatNumber(item.tunjangan)}</td>
                    <td>Rp ${formatNumber(item.total_gaji)}</td>
                    <td><button type="button" class="d-flex align-items-center btn btn-outline-danger rounded-pill fs-6 p-2 delete-btn" data-index="${index}"><i class="bi bi-trash"></i></button></td>
                </tr>`
            })
            totalkeseluruhan = totalGajiAwal + totalTunjangan
            xml += `
            <tr>
                <th colspan="6" class="table-primary text-primary">Total</td>
                <th>Rp ${formatNumber(totalGajiAwal)}</td>
                <th>Rp ${formatNumber(totalTunjangan)}</td>
                <th>Rp ${formatNumber(totalkeseluruhan)}</td>
            </tr>`
        } else {
            xml = `
            <tr>
                <td colspan="10">Data Kosong</td>
            </tr>`
        }
        $('.table tbody').html(xml)
    }

    const clearForm = () => {
        $('#form-data').trigger('reset')
    }

    renderTable(dataKaryawan)
})

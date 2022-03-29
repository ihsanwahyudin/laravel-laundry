import { formatNumber } from "../utility.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    const dataKaryawan = []
    localStorage.getItem('dataKaryawan') && dataKaryawan.push(...JSON.parse(localStorage.getItem('dataKaryawan')))

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
            const sort = quickSort(dataKaryawan, 0, dataKaryawan.length - 1, orderBy, groupBy)
            renderTable(sort)
        }
    })

    $('#group-by').on('change', function(e) {
        e.preventDefault()
        const groupBy = $(this).val()
        const orderBy = $('#sorting').val()
        if(orderBy) {
            const sort = quickSort(dataKaryawan, 0, dataKaryawan.length - 1, orderBy, groupBy)
            renderTable(sort)
        }
    })

    $('#search').on('keypress', function(e) {
        if (e.keyCode === 13) {
            const text = $("#search").val()
            const arr = binarySearch(dataKaryawan, text)
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
            // Mengembalikan array yang telah di cari
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

    // Javascript program for implementation of selection sort

    function selectionSort(arr, n, orderBy, groupBy)
    {
        function swap(arr,xp, yp)
        {
            var temp = arr[xp]
            arr[xp] = arr[yp]
            arr[yp] = temp
        }
        var i, j, min_idx

        // One by one move boundary of unsorted subarray
        for (i = 0; i < n-1; i++)
        {
            // Find the minimum element in unsorted array
            min_idx = i
            for (j = i + 1; j < n; j++) {
                if(orderBy === 'desc') {
                    if (arr[j][groupBy] < arr[min_idx][groupBy]) {
                        min_idx = j
                    }
                } else {
                    if (arr[j][groupBy] > arr[min_idx][groupBy]) {
                        min_idx = j
                    }
                }
                // Swap the found minimum element with the first element
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
                if(orderBy === 'desc') {
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

    // A utility function to swap two elements
    function swap(arr, i, j) {
        let temp = arr[i];
        arr[i] = arr[j];
        arr[j] = temp;
    }

    /* This function takes last element as pivot, places
    the pivot element at its correct position in sorted
    array, and places all smaller (smaller than pivot)
    to left of pivot and all greater elements to right
    of pivot */
    function partition(arr, low, high, orderBy, groupBy) {

        // pivot
        let pivot = arr[high];

        // Index of smaller element and
        // indicates the right position
        // of pivot found so far
        let i = (low - 1);

        for (let j = low; j <= high - 1; j++) {

            // If current element is smaller
            // than the pivot
            if(orderBy === 'desc') {
                if (arr[j][groupBy] < pivot[groupBy]) {

                    // Increment index of
                    // smaller element
                    i++;
                    swap(arr, i, j);
                }
            } else {
                if (arr[j][groupBy] > pivot[groupBy]) {
                    i++;
                    swap(arr, i, j);
                }
            }
        }
        swap(arr, i + 1, high);
        return (i + 1);
    }

    /* The main function that implements QuickSort
            arr[] --> Array to be sorted,
            low --> Starting index,
            high --> Ending index
    */
    function quickSort(arr, low, high, orderBy, groupBy) {
        if (low < high) {

            // pi is partitioning index, arr[p]
            // is now at right place
            let pi = partition(arr, low, high, orderBy, groupBy);

            // Separately sort elements before
            // partition and after partition
            quickSort(arr, low, pi - 1, orderBy, groupBy);
            quickSort(arr, pi + 1, high, orderBy, groupBy);
        }
        return arr
    }

    // const binarySearch = (arr, text) => {
    //     const searchText = (arr, mid, key, text, position) => {
    //         let data = []
    //         if(position === 'right') {
    //             for (let i = mid; i < arr.length; i++) {
    //                 const value = arr[i][key].toString()
    //                 for (let x = 0; x < value.length; x++) {
    //                     if (value.substring(x, x + text.length).toLowerCase() == text.toLowerCase()) {
    //                         data.push(arr[i])
    //                         break
    //                     }
    //                 }
    //             }
    //             return data
    //         } else {
    //             for (let i = mid; i > 0; i--) {
    //                 const value = arr[i][key].toString()
    //                 for (let x = 0; x < value.length; x++) {
    //                     if (value.substring(x, x + text.length).toLowerCase() == text.toLowerCase()) {
    //                         data.push(arr[i])
    //                         break
    //                     }
    //                 }
    //             }
    //             return data
    //         }
    //     }

    //     const subArray = (arr, index, key, text) => {
    //         const value = arr[index][key].toString()
    //         for (let x = 0; x < value.length; x++) {
    //             if (value.toLowerCase() == text.toLowerCase() || text.toLowerCase() > value.toLowerCase()) {
    //                 return "right"
    //             } else {
    //                 return "left"
    //             }
    //         }
    //     }

    //     if(text !== '' && text !== null) {
    //         let range = arr.length - 1
    //         let mid = Math.floor((range) / 2)
    //         for (const key in arr[mid]) {
    //             const sorted = insertionSort(arr, arr.length, "desc", key)
    //             const position = subArray(sorted, mid, key, text)
    //             if(position === 'right') {
    //                 const data = searchText(arr, mid, key, text, position)
    //                 if(data.length > 0) {
    //                     return data
    //                 }
    //             } else {
    //                 const data = searchText(arr, mid, key, text, position)
    //                 if(data.length > 0) {
    //                     return data
    //                 }
    //             }
    //         }
    //         return []
    //     } else {
    //         return arr
    //     }
    // }

    const binarySearch = (arr, text) => {
        const searchText = (arr, index, key, text) => {
            const value = arr[index][key].toString()
            for (let x = 0; x < value.length; x++) {
                if (value.substring(x, x + text.length).toLowerCase() == text.toLowerCase()) {
                    return index
                }
            }
            return -1
        }

        const subArrayPosition = (arr, mid, key, text) => {
            let value = arr[mid][key].toString()
            if (text.localeCompare(value) >= 0) {
                return "right"
            } else {
                return "left"
            }
        }

        if(text !== '' && text !== null) {
            let data = []
            let range = arr.length - 1
            let mid = Math.floor((range) / 2)
            for (const key in arr[mid]) {
                const sorted = insertionSort(arr, arr.length, "desc", key)
                const position = subArrayPosition(sorted, mid, key, text)
                if(position === 'right') {
                    for(let i = mid; i < arr.length; i++) {
                        const index = searchText(arr, i, key, text)
                        if(index !== -1 && typeof data.find(x => x.id == arr[index].id) === 'undefined') {
                            data.push(arr[index])
                        }
                    }
                } else {
                    for(let i = mid; i >= 0; i--) {
                        const index = searchText(arr, i, key, text)
                        if(index !== -1 && typeof data.find(x => x.id == arr[index].id) === 'undefined') {
                            data.push(arr[index])
                        }
                    }
                }
            }
            return data
        } else {
            return arr
        }
    }

})

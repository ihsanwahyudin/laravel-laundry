@extends('layout.app')
@section('title', 'Simulasi Data')
@section('main')
    <div class="page-heading">
        <h3>Simulasi Data</h3>
    </div>
    <div class="page-content">
        <div class="card">
            <div class="card-header">
                <h3>Form Input</h3>
            </div>
            <div class="card-body">
                <form method="POST" id="form-data">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="id">id</label>
                            <input type="text" class="form-control" name="id" id="id" required>
                        </div>
                        <div class="form-group">
                            <label for="name">name</label>
                            <input type="text" class="form-control" name="name" id="name" required>
                        </div>
                        <div class="d-flex gap-5 mb-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jk" id="l" value="L" required>
                                <label class="form-check-label" for="l">
                                    Laki-laki
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="jk" id="p" value="P" required>
                                <label class="form-check-label" for="p">
                                    Perempuan
                                </label>
                            </div>
                        </div>
                        <button class="btn btn-outline-primary">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header">
                <h3>Data Karyawan</h3>
            </div>
            <div class="card-body">
                <div class="my-2 d-flex justify-content-between">
                    <span class="d-flex gap-2">
                        <select class="form-select" id="sorting">
                            <option selected disabled>Sorting</option>
                            <option value="desc">Descending</option>
                            <option value="asc">Ascending</option>
                        </select>
                        {{-- <button class="btn btn-outline-primary" id="sorting">
                            Sorting
                        </button> --}}
                    </span>
                    <span class="d-flex gap-2">
                        <input type="search" class="form-control" id="search" style="width: 200px">
                        <button class="btn btn-outline-primary" id="btnSearch">
                            Search
                        </button>
                    </span>
                </div>
                <table class="table text-center table-borderless">
                    <thead class="table-primary text-primary">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
@push('script')
    <script>
        $(function() {
            const dataKaryawan = []
            localStorage.getItem('dataKaryawan') && dataKaryawan.push(...JSON.parse(localStorage.getItem('dataKaryawan')))

            let filtered = []
            $('#form-data').on('submit', function(e) {
                // Menghilangkan fungsi default
                e.preventDefault()
                // Menangkap data dari form
                const formData = new FormData(this)
                // Melakukan Insert Data
                insert(formData)
                // Melakukan render data
                renderTable(dataKaryawan)
            })

            $('#sorting').on('change', function(e) {
                e.preventDefault()
                const orderBy = $(this).val()
                if(orderBy) {
                    const sort = insertionSort(dataKaryawan, dataKaryawan.length, orderBy)
                    console.log(sort)
                    renderTable(dataKaryawan)
                }
            })

            $('#btnSearch').on('click', function(e) {
                const text = $("#search").val()
                const arr = searching(dataKaryawan, text)
                renderTable(arr)
            })

            $('#search').on('keypress', function(e) {
                if (e.keyCode === 13) {
                    const text = $("#search").val()
                    const arr = searching(dataKaryawan, text)
                    console.log(arr)
                    renderTable(arr)
                }
            })

            $('.table tbody').on('click', '.delete-btn', function(e) {
                e.preventDefault()
                const index = $(this).data('index')
                deleteData(index)
                renderTable(dataKaryawan)
            })

            // function
            const insert = (data) => {
                const obj = {}
                // Menambahkan data ke obj
                for (const key of data) {
                    obj[key[0]] = key[0] === 'id' ? parseInt(key[1]) : key[1]
                }
                // Menambahkan data ke array
                dataKaryawan.push(obj)
                localStorage.setItem('dataKaryawan', JSON.stringify(dataKaryawan))
            }

            const renderTable = (data) => {
                let xml = ''
                if (data.length !== 0) {
                    // Melakukan looping
                    data.map((item, index) => {
                        return xml += `
                    <tr>
                        <td>${item.id}</td>
                        <td>${item.name}</td>
                        <td>${item.jk == 'L' ? 'Laki-laki' : 'Perempuan'}</td>
                        <td><button type="button" class="d-flex align-items-center btn btn-outline-danger rounded-pill fs-6 p-2 delete-btn" data-index="${index}"><i class="bi bi-trash"></i></button></td>
                    </tr>`
                    })
                } else {
                    xml = `
                    <tr>
                        <td colspan="4">Data Kosong</td>
                    </tr>`
                }
                $('.table tbody').html(xml)
            }

            renderTable(dataKaryawan)

            function insertionSort(arr, n, orderBy) {
                for (let i = 1; i < n; i++) {
                    let temp = arr[i]
                    let id = arr[i]['id']
                    let j = i - 1

                    if(orderBy === 'desc') {
                        while (j >= 0 && arr[j]['id'] > id) {
                            arr[j + 1] = arr[j]
                            j = j - 1
                        }
                    } else {
                        while (j >= 0 && arr[j]['id'] < id) {
                            arr[j + 1] = arr[j]
                            j = j - 1
                        }
                    }
                    arr[j + 1] = temp
                }
                return arr
            }

            const searching = (arr, text) => {
                if(text !== '') {
                    let data = []
                    for (let index = 0; index < arr.length; index++) {
                        for (const key in arr[index]) {
                            const value = arr[index][key].toString()
                            for (let x = 0; x < value.length; x++) {
                                if (value.substring(x, x + text.length).toLowerCase() == text.toLowerCase()) {
                                    data.push(dataKaryawan[index])
                                    break;
                                }
                            }
                        }
                    }
                    return data
                } else {
                    return dataKaryawan
                }
            }

            const deleteData = (index) => {
                dataKaryawan.splice(index, 1)
                localStorage.setItem('dataKaryawan', JSON.stringify(dataKaryawan))
            }
        })
    </script>
    {{-- <script src="{{ asset('js/example.js') }}"></script> --}}
@endpush

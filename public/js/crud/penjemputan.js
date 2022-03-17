import clientRequest from "../api.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    let penjemputanData = []
    let selectedData = {}
    let transaksiData = []
    let selectedTransaksiData = []

    $('#create-data-modal form').on('submit', function(e) {
        e.preventDefault()
        const data = new FormData(this)
        storeDataToServer(data)
    })

    $('#penjemputan-table').on('click', '.update-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        searchDataById(id)
    })

    $('#update-data-modal form').on('submit', function(e) {
        e.preventDefault()
        const id = selectedData.id
        const data = new FormData(this)
        for (const key of data) {
            console.info(key)
        }
        data.append('_method', 'PUT')
        updateDataToServer(data, id)
    })

    $('#penjemputan-table').on('click', '.delete-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        Swal.fire({
            title: 'Warning',
            icon: 'warning',
            text: 'Are you sure, want delete this data ?',
            confirmButtonText: 'Delete',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#797979'
        }).then((result) => {
            if(result.value) {
                deleteDataToServer(id)
            }
        })
    })

    $('#penjemputan-table').on('change', '.change-status', async function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const status = $(this).val()
        const data = {
            status: status,
            _method: 'PUT'
        }
        updateStatusToServer(data, id)
    })

    $('#penjemputan-table').on('click', '.cant-delete', function(e) {
        e.preventDefault()
        showAlert('Peringatan', 'warning', 'Cant delete this data, because it has related data')
    })

    $('#daftar-transaksi-table').on('click', '.select-btn', async function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const data = await searchDataTransaksiById(id)
        for (const key in data.member) {
            $(`#create-data-modal [name="${key}"]`).val(data.member[key])
        }
        $('#create-data-modal [name="transaksi_id"]').val(id)
        $('#create-data-modal [name="kode_invoice"]').val(data.kode_invoice)
        $('#select-transaksi-modal').modal('hide')
        $('#create-data-modal').modal('show')
    })

    const searchDataTransaksiById = (id) => {
        const data = transaksiData.find(function(item) {
            return item.id === id
        })
        return data
    }

    const storeDataToServer = (data) => {
        clientRequest('/api/penjemputan', 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Create Data Successfully')
                renderPenjemputanTable()
                clearErrors()
                clearForm('#create-data-modal')
                $('#create-data-modal').modal('toggle')
            } else {
                if(res.status === 422) {
                    displayErrors('#create-data-modal', res.data.errors)
                    showToast('Failed', 'warning', 'Please Check your data before submit')
                } else {
                    showToast('Failed', 'error', 'Internal Server Error')
                }
            }
        })
    }

    const searchDataById = (id) => {
        const selected = penjemputanData.find(x => x.id == id)
        if(selected) {
            selectedData = selected
            for (const key in selected.transaksi.member) {
                $(`#update-data-modal [name="${key}"]`).val(selected.transaksi.member[key])
            }
            $(`#update-data-modal [name="kode_invoice"]`).val(selected.transaksi.kode_invoice)
            for(const key in selected) {
                $(`#update-data-modal [name="${key}"]`).val(selected[key])
            }
        }
    }

    const updateDataToServer = (data, id) => {
        clientRequest(`/api/penjemputan/${id}`, 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Update Data Successfully')
                clearErrors()
                renderPenjemputanTable()
                $('#update-data-modal').modal('hide')
            } else {
                if(res.status === 422) {
                    displayErrors('#update-data-modal', res.data.errors)
                    showToast('Failed', 'warning', 'Please Check your data before submit')
                } else {
                    showToast('Failed', 'error', 'Internal Server Error')
                }
            }
        })
    }

    const updateStatusToServer = (data, id) => {
        clientRequest(`/api/penjemputan/update-status/${id}`, 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Update Data Successfully')
                clearErrors()
            } else {
                if(res.status === 422) {
                    displayErrors('#update-data-modal', res.data.errors)
                    showToast('Failed', 'warning', 'Please Check your data before submit')
                } else {
                    showToast('Failed', 'error', 'Internal Server Error')
                }
            }
        })
    }

    const deleteDataToServer = (id) => {
        clientRequest(`/api/penjemputan/${id}`, 'DELETE', '', (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Delete Data Successfully')
                renderPenjemputanTable()
            } else {
                showToast('Failed', 'error', 'Internal Server Error')
            }
        })
    }

    const displayErrors = (el, errors) => {
        clearErrors()
        for (const key in errors) {
            const input = $(`${el} form [name=${key}]`)
            const parent = input.parent().parent()
            input.addClass('is-invalid')
            parent.find('span.form-errors').text(errors[key][0])
        }
	}

	const clearErrors = () => {
		$('input.form-control').removeClass('is-invalid')
		$('select.form-select').removeClass('is-invalid')
		$('textarea.form-control').removeClass('is-invalid')
		$('span.form-errors').text('')
	}

	const clearForm = (el) => {
		$(`${el} input.form-control`).val('')
		$(`${el} textarea.form-control`).val('')
	}

    const renderPenjemputanTable = () => {
        $('#penjemputan-table').DataTable().destroy()
        $('#penjemputan-table').DataTable({
            ajax:{
                    url: "/api/penjemputan",
                    dataSrc: function ( json ) {
                        penjemputanData = json
                        return json
                    }
                },
            columns: [
                {
                    render: function(data, type, row, meta) {
                        return meta.row + 1
                    }
                },
                { data: 'transaksi.member.nama' },
                { data: 'transaksi.member.alamat' },
                { data: 'transaksi.member.tlp' },
                { data: 'petugas_penjemput' },
                {
                    render: function(data, type, row, meta) {
                        return `
                        <select class="form-control change-status" data-id="${row.id}">
                            <option value="tercatat" ${row.status === 'tercatat' ? 'selected' : ''}>Tercatat</option>
                            <option value="penjemputan" ${row.status === 'penjemputan' ? 'selected' : ''}>Penjemputan</option>
                            <option value="selesai" ${row.status === 'selesai' ? 'selected' : ''}>Selesai</option>
                        </select>`

                    }
                },
                {
                    render: function(data, type, row, meta) {
                        if(type === 'display') {
                            let actionXML = `<div class="d-flex justify-content-center gap-2">`
                                actionXML += `<button class="d-flex align-items-center btn btn-outline-success rounded-pill fs-6 p-2 update-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#update-data-modal"><i class="bi bi-pencil-square"></i></button>`
                                actionXML += `<button class="d-flex align-items-center btn btn-outline-danger rounded-pill fs-6 p-2 delete-btn" data-id="${row.id}"><i class="bi bi-trash"></i></button>`
                            actionXML += `</div>`
                            return actionXML
                        } else {
                            return ''
                        }
                    },
                    orderable: false,
                }
            ]
        })
    }

    renderPenjemputanTable()

    const renderDaftarTransaksiTable = () => {
        $('#daftar-transaksi-table').DataTable({
            ajax: {
                url: `/api/data/transaksi/selesai`,
                dataSrc: function ( json ) {
                    transaksiData = json
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
                                    return '<span class="badge bg-light-success">diambil</span>'
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
                                case "lunas":
                                    return '<span class="badge bg-light-success">lunas</span>'
                                case "belum lunas":
                                    return '<span class="badge bg-light-danger">belum lunas</span>'
                            }
                        } else {
                            return ''
                        }
                    }
                },
                {
                    render: function(data, type, row, meta) {
                        if(type === 'display') {
                            return `<div class="d-flex justify-content-center">
                                        <button class="d-flex align-items-center btn btn-outline-primary rounded-pill fs-6 p-2 select-btn" data-id="${row.id}">
                                            <i class="bi bi-check2"></i>
                                        </button>
                                    </div>`
                        } else {
                            return ''
                        }
                    },
                    orderable: false,
                    searchable: false
                }
            ]
        })
    }

    renderDaftarTransaksiTable()
})

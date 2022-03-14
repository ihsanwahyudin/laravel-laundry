import clientRequest from "../api.js"
import { showConfirmAlert, showToast, showAlert } from "../sweetalert.js"
import { formatNumber } from "../utility.js"

$(function() {
    let paketData = []
    let selectedData = {}
    const paketTable = $('#paket-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                url: "/api/paket",
                dataSrc: function ( json ) {
                    paketData = json.data
                    return json.data
                }
            },
        columns: [
            { data: 'DT_RowIndex' },
            {
                data: function(data, type, row) {
                    if(type === 'display') {
                        if(data.outlet !== null) {
                            return data.outlet.nama
                        } else {
                            return '-'
                        }
                    } else {
                        return ''
                    }
                }
            },
            { data: 'nama_paket' },
            { data: 'jenis' },
            {
                data: function(data, type, row) {
                    if(type === 'display') {
                        return formatNumber(data.harga)
                    } else {
                        return data.harga
                    }
                },
                orderable: true,
            },
            {
                render: function(data, type, row, meta) {
                    if(type === 'display') {
                        let actionXML = `<div class="d-flex justify-content-center gap-2">`
                            actionXML += `<button class="d-flex align-items-center btn btn-outline-success rounded-pill fs-6 p-2 update-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#update-data-modal"><i class="bi bi-pencil-square"></i></button>`
                            actionXML += `<button class="d-flex align-items-center btn btn-outline-${row.detail_transaksi_count <= 0 ? 'danger' : 'secondary'} rounded-pill fs-6 p-2 ${row.detail_transaksi_count <= 0 ? 'delete-btn' : 'cant-delete'}" data-id="${row.id}"><i class="bi bi-trash"></i></button>`
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

    $('#create-data-modal form').on('submit', function(e) {
        e.preventDefault()
        const data = new FormData(this)
        storeDataToServer(data)
    })

    $('#paket-table').on('click', '.update-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        searchDataById(id)
    })

    $('#update-data-modal form').on('submit', function(e) {
        e.preventDefault()
        const id = selectedData.id
        const data = new FormData(this)
        data.append('_method', 'PUT')
        updateDataToServer(data, id)
    })

    $('#paket-table').on('click', '.delete-btn', function(e) {
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

    $('#paket-table').on('click', '.cant-delete', function(e) {
        e.preventDefault()
        showAlert('Peringatan', 'warning', 'Cant delete this data, because it has related data')
    })

    $('#create-data-modal').on('hidden.bs.modal', function (e) {
        clearForm('#create-data-modal')
        clearErrors()
    })

    $('#update-data-modal').on('hidden.bs.modal', function (e) {
        clearForm('#update-data-modal')
        clearErrors()
    })

    const getOutletData = () => {
        clientRequest('/api/outlet/create', 'GET', '', (status, res) => {
            if(status) {
                drawOutletData(res.data)
            }
        })
    }

    const drawOutletData = (data) => {
        let xml = '<option selected disabled value="">Choose Outlet...</option>'
        data.map(item => {
            xml += `<option value="${item.id}">${item.nama}</option>`
        })
        $('#create-data-modal [name="outlet_id"]').html(xml)
        $('#update-data-modal [name="outlet_id"]').html(xml)
    }

    const storeDataToServer = (data) => {
        clientRequest('/api/paket', 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Create Data Successfully')
                paketTable.ajax.reload()
                $('#create-data-modal').modal('toggle')
                clearErrors()
                clearForm()
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
        const selected = paketData.find(x => x.id == id)
        if(selected) {
            selectedData = selected
            for (const key in selected) {
                console.info(selected[key])
                $(`#update-data-modal [name="${key}"]`).val(selected[key])
            }
        }
    }

    const updateDataToServer = (data, id) => {
        clientRequest(`/api/paket/${id}`, 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Update Data Successfully')
                paketTable.ajax.reload()
                $('#update-data-modal').modal('toggle')
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
        clientRequest(`/api/paket/${id}`, 'DELETE', '', (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Delete Data Successfully')
                paketTable.ajax.reload()
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
		$(`${el} select.form-select`).val('')
		$(`${el} textarea.form-control`).val('')
	}

    getOutletData()
})

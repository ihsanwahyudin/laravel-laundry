import clientRequest from "../api.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    let outletData = []
    let selectedData = {}
    const outletTable = $('#outlet-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                url: "/api/outlet",
                dataSrc: function ( json ) {
                    outletData = json.data
                    return json.data
                }
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'nama' },
            { data: 'alamat' },
            { data: 'tlp' },
            {
                render: function(data, type, row, meta) {
                    if(type === 'display') {
                        let actionXML = `<div class="d-flex justify-content-center gap-2">`
                            actionXML += `<button class="d-flex align-items-center btn btn-outline-success rounded-pill fs-6 p-2 update-btn" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#update-data-modal"><i class="bi bi-pencil-square"></i></button>`
                            actionXML += `<button class="d-flex align-items-center btn btn-outline-${row.paket_count <= 0 ? 'danger' : 'secondary'} rounded-pill fs-6 p-2 ${row.paket_count <= 0 ? 'delete-btn' : 'cant-delete'}" data-id="${row.id}"><i class="bi bi-trash"></i></button>`
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

    $('#outlet-table').on('click', '.update-btn', function(e) {
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

    $('#outlet-table').on('click', '.delete-btn', function(e) {
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

    $('#outlet-table').on('click', '.cant-delete', function(e) {
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

    const storeDataToServer = (data) => {
        clientRequest('/api/outlet', 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Create Data Successfully')
                outletTable.ajax.reload()
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
        const selected = outletData.find(x => x.id == id)
        if(selected) {
            selectedData = selected
            for (const key in selected) {
                $(`#update-data-modal [name="${key}"]`).val(selected[key])
            }
        }
    }

    const updateDataToServer = (data, id) => {
        clientRequest(`/api/outlet/${id}`, 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Update Data Successfully')
                outletTable.ajax.reload()
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
        clientRequest(`/api/outlet/${id}`, 'DELETE', '', (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Delete Data Successfully')
                outletTable.ajax.reload()
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

})

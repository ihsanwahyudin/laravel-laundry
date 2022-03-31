import clientRequest from "../api.js"
import { showAlert, showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    const allData = []
    let selectedData = {}

    $('#create-data-modal form').on('submit', function(e) {
        e.preventDefault()
        const data = new FormData(this)
        storeDataToServer(data)
    })

    $('#example-table').on('click', '.update-btn', function(e) {
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

    $('#example-table').on('click', '.delete-btn', function(e) {
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

    $('#example-table').on('change', '.change-status', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        const status = $(this).val()
        const data = {
            status_barang: status,
            _method: 'PUT'
        }
        updateStatusToServer(data, id)
        renderTable()
    })

    $('#example-table').on('click', '.cant-delete', function(e) {
        e.preventDefault()
        showAlert('Peringatan', 'warning', 'Cant delete this data, because it has related data')
    })

    const searchDataById = (id) => {
        const selected = barangData.find(x => x.id == id)
        if(selected) {
            selectedData = selected
            for(const key in selected) {
                if(key === 'waktu_beli') {
                    $(`#update-data-modal [name="${key}"]`).val(moment(selected[key]).format('YYYY-MM-DDTHH:mm'))
                } else {
                    $(`#update-data-modal [name="${key}"]`).val(selected[key])
                }
            }
        }
    }

    const storeDataToServer = (data) => {
        clientRequest('/api/example', 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Create Data Successfully')
                renderTable()
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

    const deleteDataToServer = (id) => {
        clientRequest(`/api/barang/${id}`, 'DELETE', '', (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Delete Data Successfully')
                renderBarangTable()
            } else {
                showToast('Failed', 'error', 'Internal Server Error')
            }
        })
    }

    const updateDataToServer = (data, id) => {
        clientRequest(`/api/barang/${id}`, 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Update Data Successfully')
                clearErrors()
                renderTable()
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

    const renderTable = () => {
        $('#example-table').DataTable().destroy()
        $('#example-table').DataTable({
            ajax:{
                    url: "/api/example",
                    dataSrc: function ( json ) {
                        allData = json
                        return json
                    }
                },
            columns: [
                {
                    render: function(data, type, row, meta) {
                        return meta.row + 1
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

    const clearForm = (id) => {
        $(`${id} form`).trigger('reset')
    }
})

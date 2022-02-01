import clientRequest from "../api.js"
import { showConfirmAlert, showToast } from "../sweetalert.js"

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
            { data: 'harga' },
            { data: 'action', orderable: false, searchable: false }
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

    const getOutletData = () => {
        clientRequest('/api/outlet/create', 'GET', '', (status, res) => {
            if(status) {
                drawOutletData(res.data)
            }
        })
    }

    const drawOutletData = (data) => {
        let xml = '<option selected disabled>Choose Outlet...</option>'
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
		$('textarea.form-control').removeClass('is-invalid')
		$('span.form-errors').text('')
	}

	const clearForm = (el) => {
		$(`${el} input.form-control`).val('')
		$(`${el} textarea.form-control`).val('')
	}


    getOutletData()
})

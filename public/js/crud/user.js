import clientRequest from "../api.js"
import { showConfirmAlert, showToast } from "../sweetalert.js"

$(function() {
    let userData = []
    let selectedData = {}
    const userTable = $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                url: "/api/user",
                dataSrc: function ( json ) {
                    userData = json.data
                    return json.data
                }
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'name' },
            {
                data: function(data, type, row) {
                    if(type === 'display') {
                        switch (data.role) {
                            case "admin":
                                return '<span class="badge bg-light-primary">Admin</span>'
                            case "kasir":
                                return '<span class="badge bg-light-info">Kasir</span>'
                            case "owner":
                                return '<span class="badge bg-light-danger">Owner</span>'
                        }
                        if(data.role === 'P') {
                        } else {
                        }
                    } else {
                        return ''
                    }
                }
            },
            {
                data: function(data, type, row) {
                    if(type === 'display') {
                        if(data.outlet === null) {
                            return '-'
                        } else {
                            return data.outlet.nama
                        }
                    } else {
                        return ''
                    }
                }
            },
            { data: 'action', orderable: false, searchable: false }
        ]
    })

    $('#create-data-modal form').on('submit', function(e) {
        e.preventDefault()
        const data = new FormData(this)
        storeDataToServer(data)
    })

    $('#user-table').on('click', '.update-btn', function(e) {
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

    $('#user-table').on('click', '.delete-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        showConfirmAlert('Warning !', 'warning', 'Are you sure, want delete this data ?', 'Yes', (result) => {
            if(result.value) {
                deleteDataToServer(id)
            }
        })
    })

    const storeDataToServer = (data) => {
        clientRequest('/api/user', 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Create Data Successfully')
                userTable.ajax.reload()
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
        const selected = userData.find(x => x.id == id)
        if(selected) {
            selectedData = selected
            for (const key in selected) {
                $(`#update-data-modal [name="${key}"]`).val(selected[key])
            }
        }
    }

    const updateDataToServer = (data, id) => {
        clientRequest(`/api/user/${id}`, 'POST', data, (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Update Data Successfully')
                userTable.ajax.reload()
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
        clientRequest(`/api/user/${id}`, 'DELETE', '', (status, res) => {
            if(status) {
                showToast('Success', 'success', 'Delete Data Successfully')
                userTable.ajax.reload()
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

})

import clientRequest from "../api.js"
import { showToast } from "../sweetalert.js";

$(function() {
    $('#filter-data-form').on('submit', function(e) {
        e.preventDefault();
        const data = new FormData(this)
        filterLogs(data)
    })

    const getAllLogActivity = () => {
        clientRequest('/api/log-activity/all', 'GET', null, (status, res) => {
            if(status) {
                renderLogActivity(res.data)
            } else {
                console.info(res)
            }
        })
    }

    const renderLogActivity = (data) => {
        let card = ''
        for (const date in data) {
            let totalActivity = 0
            let logs = ''
            data[date].map((item) => {
                let activityXML = ''
                totalActivity++
                if ('kode_invoice' in item) {
                    activityXML += `Melakukan transaksi dengan nomor invoice "${item.kode_invoice}"`
                } else {
                    const allowedColumn = ['nama', 'nama_paket', 'nama_member', 'name']
                    let dataName = ''
                    for (const list of item.detail_log_activity) {
                        if(allowedColumn.includes(list.table_column_list.column_name)) {
                            dataName = list.data
                            break;
                        }
                    }
                    activityXML +=
                    item.action === "1" ?
                        `Menambah data "${dataName}" pada tabel ${item.reference_table.table_name.replace('tb_', '')}` :
                    item.action === "2" ?
                        `Membaca` :
                    item.action === "3" ?
                        `Mengubah data "${dataName}" pada tabel ${item.reference_table.table_name.replace('tb_', '')}` :
                    item.action === "4" ?
                        `Menghapus data "${dataName}" pada tabel ${item.reference_table.table_name.replace('tb_', '')}` :
                    item.action === "5" ?
                        `Login dengan IP Address "${item.detail_log_activity[0].data}"` :
                    ""
                }
                logs +=
                `<div class="recent-message d-flex px-4 py-3">
                    <div class="avatar avatar-lg">
                        <img src="/vendors/mazer/dist/assets/images/faces/${getRandomInt(1,5)}.jpg" />
                    </div>
                    <div class="name ms-4">
                        <div class="title">
                            <h5>${item.user.name}</h5>
                            <span><small>${moment(item.created_at).startOf('minute').fromNow()}</small></span>
                        </div>
                        <h6 class="text-muted mb-0">${activityXML}</h6>
                    </div>
                </div>`
            })
            card +=
            `<div class="card">
                <div class="card-header d-flex justify-content-between">
                        <h4>${moment(date).format('DD MMMM YYYY')}</h4>
                    <h4>${totalActivity} Aktivitas</h4>
                </div>
                <div class="card-content pb-4">
                    ${logs}
                </div>
            </div>`
        }
        $('#log-data').html(card)
    }

    const filterLogs = (data) => {
        clientRequest('/api/log-activity/filter', 'POST', data, (status, res) => {
            if(status) {
                renderLogActivity(res.data)
            } else {
                if(res.status === 422) {
                    showToast('Failed', 'warning', 'Harap masukkan tanggal yang valid')
                } else {
                    showToast('Failed', 'error', 'Terjadi kesalahan pada server')
                }
            }
        })
    }

    const getRandomInt = (min, max) => {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
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

    getAllLogActivity()
})

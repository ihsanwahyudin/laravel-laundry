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
                renderLogActivity(res.data.data)
            } else {
                console.info(res)
            }
        })
    }

    const renderLogActivity = (data) => {
        let card = ''
        data.forEach(item => {
            let totalActivity = 0
            let logs = ''
            item.logs.forEach(list => {
                totalActivity++
                logs +=
                `<div class="recent-message d-flex px-4 py-3">
                    <div class="avatar avatar-lg">
                        <img src="/vendors/mazer/dist/assets/images/faces/${getRandomInt(1,5)}.jpg" />
                    </div>
                    <div class="name ms-4">
                        <div class="title">
                            <h5>${list.context.user_name}</h5>
                            <span><small>${moment(list.timestamp).startOf('minute').fromNow()}</small></span>
                        </div>
                        <h6 class="text-muted mb-0">${list.message}</h6>
                    </div>
                </div>`
            })
            card +=
            `<div class="card">
                <div class="card-header d-flex justify-content-between">
                        <h4>${moment(item.date).format('DD MMMM YYYY')}</h4>
                    <h4>${totalActivity} Aktivitas</h4>
                </div>
                <div class="card-content pb-4">
                    ${logs}
                </div>
            </div>`
        })
        $('#log-data').html(card)
    }

    const filterLogs = (data) => {
        clientRequest('/api/log-activity/filter', 'POST', data, (status, res) => {
            if(status) {
                renderLogActivity(res.data.data)
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

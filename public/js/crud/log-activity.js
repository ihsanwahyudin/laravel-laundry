import clientRequest from "../api.js"

$(function() {
    const getAllLogActivity = () => {
        clientRequest('/api/log-activity/all', 'GET', null, (status, res) => {
            if(status) {
                console.info(res)
                renderLogActivity(res.data)
            } else {
                console.info(res)
            }
        })
    }

    const renderLogActivity = (data) => {
        let html = ''
        // ACTION STATUS 1 = CREATE , 2 = READ , 3 = UPDATE, 4 = DELETE, 5 = LOGIN
        data.date.map((item, index) => {
            let logsXML = ''
            let totalActivity = 0
            data.logs.map((list, index) => {
                if(item.date === list.created_at.substring(0,10)) {
                    totalActivity++
                    logsXML += `<div class="recent-message d-flex px-4 py-3">
                                    <div class="avatar avatar-lg">
                                        <img src="/vendors/mazer/dist/assets/images/faces/${getRandomInt(1,5)}.jpg" />
                                    </div>
                                    <div class="name ms-4">
                                        <div class="title">
                                            <h5>${list.user.name}</h5>
                                            <span><small>${moment(list.created_at).startOf('hour').fromNow()}</small></span>
                                        </div>
                                        <h6 class="text-muted mb-0">${
                                            list.action === "1" ? `Menambah data "${list.detail_log_activity[0].data}" pada tabel ${list.reference_table.table_name.replace('tb_', '')}` :
                                            list.action === "2" ? `Membaca` :
                                            list.action === "3" ? `Mengubah data "${list.detail_log_activity[0].data}" pada tabel ${list.reference_table.table_name.replace('tb_', '')}` :
                                            list.action === "4" ? `Menghapus data "${list.detail_log_activity[0].data}" pada tabel ${list.reference_table.table_name.replace('tb_', '')}` :
                                            list.action === "5" ? `Login dengan IP Address "${list.detail_log_activity[0].data}"` :
                                            ""
                                        }</h6>
                                    </div>
                                </div>`
                }
            })
            html += `<div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h4>${moment(item.date).format('DD MMMM YYYY')}</h4>
                            <h4>${totalActivity} Aktivitas</h4>
                        </div>
                        <div class="card-content pb-4">
                        ${logsXML}
                        </div>
                    </div>`
        })

        $('#log-data').html(html)
    }

    const getRandomInt = (min, max) => {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    getAllLogActivity()
})

import clientRequest from "../api.js"
import { showConfirmAlert, showToast, showAlert } from "../sweetalert.js"
import { formatNumber } from "../utility.js"

$(function() {
    let paketData = []
    let selectedData = []
    let memberData = []
    let selectedMember = []
    const paymentMethod = ['cash', 'dp', 'bayar nanti']
    let selectedPaymentMethod = 'cash'
    let transaksi =  {
        member_id: '',
        tgl: '',
        batas_waktu: '',
        biaya_tambahan: 0,
        diskon: 0,
        pajak: 10,
        total_bayar: 0
    }
    let totalPenjualan = 0
    const selectedPaketTable = $('#transaksi-table').DataTable()
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
            { data: 'nama_paket' },
            { data: 'jenis' },
            {
                data: function(data, type, row) {
                    if(type === 'display') {
                        return formatNumber(data.harga)
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
    const memberTable = $('#member-table').DataTable({
        processing: true,
        serverSide: true,
        ajax:{
                url: "/api/member",
                dataSrc: function ( json ) {
                    memberData = json.data
                    return json.data
                }
            },
        columns: [
            { data: 'DT_RowIndex' },
            { data: 'nama' },
            { data: 'tlp' },
            { data: 'alamat' },
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

    $('#paket-table').on('click', '.select-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        searchPaketById(id)
        $('#select-data-modal').modal('toggle')
    })

    $('#transaksi-table').on('click', '.delete-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        deletePaketById(id)
    })

    $('#transaksi-table').on('change', '[name="qty[]"]', function(e) {
        const value = parseInt($(this).val())
        const id = $(this).data('id')
        const index = selectedData.findIndex(x => x.id == id)
        selectedData[index]['qty'] = value
        calculate()
    })

    $('#transaksi-table').on('change', '[name="ket[]"]', function(e) {
        const value = $(this).val()
        const id = $(this).data('id')
        const index = selectedData.findIndex(x => x.id == id)
        selectedData[index]['ket'] = value
    })

    $('[name="biaya_tambahan"]').on('keyup', function(e) {
        let value = $(this).val()
        value == '' ? value = 0 : $(this).val(parseInt(value))
        transaksi.biaya_tambahan = parseInt(value)
        calculate()
    })

    $('[name="diskon"]').on('keyup', function(e) {
        let value = $(this).val()
        value == '' ? value = 0 : $(this).val(parseInt(value))
            if(parseInt(value) > 100) {
                $(this).val(100)
                transaksi.diskon = 100
            } else if(parseInt(value) <= 0) {
                $(this).val(0)
                transaksi.diskon = 0
            } else {
                transaksi.diskon = parseInt(value)
            }
            calculate()
    })

    $('[name="pajak"]').on('keyup', function(e) {
        let value = $(this).val()
        value == '' ? value = 0 : $(this).val(parseInt(value))
            if(parseInt(value) > 100) {
                $(this).val(100)
                transaksi.pajak = 100
            } else if(parseInt(value) <= 0) {
                $(this).val(0)
                transaksi.pajak = 0
            } else {
                transaksi.pajak = parseInt(value)
            }
            calculate()
    })

    $('#store-transaction').on('submit', function(e) {
        e.preventDefault()
        if(validation()) {
            Swal.fire({
                title: 'Konfirmasi Transaksi',
                icon: 'warning',
                html:   `<table width="100%" class="text-start">
                            <tr>
                                <td>Nama Pembeli</td>
                                <td style="margin: 0 5px">:</td>
                                <td>${selectedMember.nama}</td>
                            </tr>
                            <tr>
                                <td>Total Pembayaran</td>
                                <td>:</td>
                                <td>Rp ${formatNumber(totalPenjualan)}</td>
                            </tr>
                            <tr>
                                <td>Total Bayar</td>
                                <td>:</td>
                                <td>Rp ${formatNumber(transaksi.total_bayar)}</td>
                            </tr>
                        </table>`,
                confirmButtonText: 'submit',
                showCancelButton: true,
                confirmButtonColor: '#435ebe',
                cancelButtonColor: '#797979'
            }).then((result) => {
                if(result.value) {
                    storeTransactionToServer()
                }
            })
        }
    })

    $('#member-table').on('click', '.select-btn', function(e) {
        e.preventDefault()
        const id = $(this).data('id')
        searchMemberById(id)
    })

    $('[name="metode_pembayaran"]').on('change', function(e) {
        e.preventDefault()
        const value = $(this).val()
        switch (value) {
            case 'cash':
                selectedPaymentMethod = 'cash'
                enablePaymentForm()
                break;
            case 'dp':
                selectedPaymentMethod = 'dp'
                enablePaymentForm()
                break;
            case 'bayar nanti':
                selectedPaymentMethod = 'bayar nanti'
                disablePaymentForm()
                break;
        }
    })

    const storeTransactionToServer = () => {
        const data = {
            member: selectedMember,
            detailTransaksi: selectedData,
            transaksi: {
                member_id: selectedMember.id,
                tgl_bayar: $('[name="tgl_bayar"]').val(),
                batas_waktu: $('[name="batas_waktu"]').val(),
                status_transaksi: 'baru',
                metode_pembayaran: selectedPaymentMethod,
                biaya_tambahan: transaksi.biaya_tambahan,
                diskon: transaksi.diskon,
                pajak: transaksi.pajak,
                total_pembayaran: totalPenjualan,
                total_bayar: transaksi.total_bayar,
            }
        }
        clientRequest('/api/transaksi/store', 'POST', data, (status, res) => {
            if(status) {
                const text = `Faktur Pembayaran\n` +
                `No Invoice\t\t\t: ${res.data.transaksi.kode_invoice}\n` +
                `Pelanggan\t\t\t: ${data.member.nama}\n` +
                `No Telp\t\t\t\t: ${data.member.tlp}\n` +
                `Metode Pembayaran\t: ${res.data.transaksi.metode_pembayaran}\n` +
                `Status Pembayaran\t\t: ${res.data.transaksi.status_pembayaran}\n` +
                `*Detail Lengkap*\n` +
                `http://127.0.0.1:8000/api/transaksi/cetak-faktur/${res.data.transaksi.kode_invoice}` +
                `\n\n*Terima Kasih Telah Menggunakan Jasa Cucian di Toko Kami*`
                Swal.fire({
                    title: 'Transaksi Berhasil !',
                    html: `
                    <div class="m-2">
                        <p class="text-center">Send to</p>
                        <a target="_blank" href="https://wa.me/6281357517855?text=${encodeURI(text)}">
                            <i class="bi bi-whatsapp fs-1"></i>
                        </a>
                    </div>`,
                    icon: 'success',
                    confirmButtonText: 'Kembali',
                    showCancelButton: false,
                    confirmButtonColor: '#435ebe',
                })
                clearErrors()
                clearForm()
                window.open('/api/transaksi/cetak-faktur/' + res.data.transaksi.kode_invoice, '_blank')
            } else {
                if(res.status === 422) {
                    displayErrors(res.data.errors)
                    showToast('failed', 'warning', 'Pastikan data yang anda masukan benar !')
                } else {
                    showToast('failed', 'error', 'Internal Server Error')
                }
            }
        })
    }

    const searchPaketById = (id) => {
        const selected = paketData.find(x => x.id == id)
        if(typeof selected !== 'undefined') {
            const isAvailable = selectedData.find(x => x.id == id)
            if(typeof isAvailable === 'undefined') {
                selected['qty'] = 1
                selected['ket'] = ''
                selectedData.push(selected)
                addRowTable(selected)
                calculate()
            } else {
                const index = selectedData.findIndex(x => x.id == id)
                const newValue = selectedData[index].qty++
                calculate()
                changeValueQty(index, newValue + 1)
            }
        } else {
            showAlert('Ups..', 'warning', 'Maaf Barang yang kamu cari tidak ada')
        }
    }

    const searchMemberById = (id) => {
        const selected = memberData.find(x => x.id == id)
        if(typeof selected !== 'undefined') {
            selectedMember = selected
            displayMemberData()
            $('#select-member-modal').modal('toggle')
        } else {
            showAlert('Ups..', 'warning', 'Member belum terdaftar')
        }
    }

    const deletePaketById = (id) => {
        const index = selectedData.findIndex(x => x.id == id)
        selectedData.splice(index, 1)
        selectedPaketTable.row($(this).parents("tr")).remove().draw()
        calculate()
        redrawDatatable()
    }

    const addRowTable = (data) => {
        let index = selectedData.findIndex(x => x.id == data.id)
        selectedPaketTable.row.add([
            index + 1,
            data.nama_paket,
            data.jenis,
            formatNumber(data.harga),
            `<input type="number" name="qty[]" class="form-control mx-auto text-center" style="width: 100px" value="${data.qty}" data-id="${data.id}">`,
            `<input type="text" name="ket[]" class="form-control mx-auto text-center" style="width: 400px" value="${data.ket}" data-id="${data.id}" autocomplete="off">`,
            `<div class="d-flex justify-content-center">
                <button type="button" class="d-flex align-items-center btn btn-outline-danger rounded-pill fs-6 p-2 delete-btn" data-id="${data.id}">
                    <i class="bi bi-trash"></i>
                </button>
            </div>`
        ]).draw()
    }

    const changeValueQty = (index, value) => {
        const tr = $('#transaksi-table tbody tr')
        tr.map((idx, itm) => {
            if(idx == index) {
                itm.querySelector('input[name="qty[]"]').value = value
            }
        })
    }

    const redrawDatatable = () => {
        selectedPaketTable.clear().draw()
        selectedData.map((item, index) => {
            selectedPaketTable.row.add([
                index + 1,
                item.nama_paket,
                item.jenis,
                formatNumber(item.harga),
                `<input type="number" name="qty[]" class="form-control mx-auto text-center" style="width: 100px" value="${item.qty}" data-id="${item.id}">`,
                `<input type="text" name="ket[]" class="form-control mx-auto text-center" style="width: 400px" value="${item.ket}" data-id="${item.id}" autocomplete="off">`,
                `<div class="d-flex justify-content-center">
                    <button type="button" class="d-flex align-items-center btn btn-outline-danger rounded-pill fs-6 p-2 delete-btn" data-id="${item.id}">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>`
            ]).draw()
        })
    }

    const calculate = () => {
        totalPenjualan = 0
        selectedData.map(item => {
            totalPenjualan += (parseInt(item.harga) * parseInt(item.qty))
        })
        totalPenjualan += transaksi.biaya_tambahan
        const diskon = Math.round((totalPenjualan * transaksi.diskon) / 100)
        totalPenjualan -= diskon
        const pajak = Math.round((totalPenjualan * transaksi.pajak) / 100)
        totalPenjualan += pajak
        $('[name="total_penjualan"]').html(formatNumber(totalPenjualan))
    }

    const displayMemberData = () => {
        for (const key in selectedMember) {
            $(`[name="${key}"]`).val(selectedMember[key])
        }
    }

    const disablePaymentForm = () => {
        $('[name="total_bayar"]').attr('readonly', '')
        $('[name="diskon"]').attr('readonly', '')
        $('[name="biaya_tambahan"]').attr('readonly', '')
    }

    const enablePaymentForm = () => {
        $('[name="total_bayar"]').removeAttr('readonly')
        $('[name="diskon"]').removeAttr('readonly')
        $('[name="biaya_tambahan"]').removeAttr('readonly')
    }

    const validation = () => {
        if(selectedData.length === 0) {
            showAlert('Opps..', 'warning', 'Tolong pilih paket dulu !')
            return false
        } else if(selectedMember.length === 0) {
            showAlert('Opps..', 'warning', 'Tolong pilih member dulu !')
            return false
        } else {
            const totalBayar = $('[name="total_bayar"]').val()
            switch (selectedPaymentMethod) {
                case 'cash':
                    if(parseInt(totalBayar) < totalPenjualan || totalBayar === '') {
                        showAlert('Opps..', 'warning', 'Maaf uang tidak cukup')
                        return false
                    } else {
                        transaksi.total_bayar = parseInt(totalBayar)
                        return true
                    }
                case 'dp':
                    if(parseInt(totalBayar) <= 0 || totalBayar === '') {
                        showAlert('Opps..', 'warning', 'Tolong masukan nominal harga yang valid')
                        return false
                    } else {
                        transaksi.total_bayar = parseInt(totalBayar)
                        return true
                    }
                case 'bayar nanti':
                    transaksi.total_bayar = 0
                    return true
            }
        }
    }

    const clearErrors = () => {
		$('input.form-control').removeClass('is-invalid')
		$('textarea.form-control').removeClass('is-invalid')
		$('span.form-errors').text('')
	}

    const clearForm = () => {
        selectedData = []
        selectedMember = []
        $('[name="nama"]').val('')
        $('[name="tlp"]').val('')
        $('[name="tgl_bayar"]').val('')
        $('[name="batas_waktu"]').val('')
        selectedPaketTable.clear().draw()
        transaksi.biaya_tambahan = 0
        transaksi.diskon = 0
        transaksi.total_bayar = 0
        transaksi.tgl = ''
        transaksi.batas_waktu = ''
        transaksi.member_id = ''
        $('[name="biaya_tambahan"]').val('')
        $('[name="diskon"]').val('')
        $('[name="total_bayar"]').val('')
        $('[name="total_penjualan"]').text('0')
    }

    const displayErrors = (errors) => {
        clearErrors()
        for (const key in errors) {
            const newKey = key.split('.')
            if(newKey[0] === 'detailTransaksi') {
                $(`input[name="qty[]"]`).map((index, item) => {
                    if(newKey[1] == index) item.classList.add('is-invalid')
                })
            } else if(newKey[0] === 'transaksi') {
                $(`input[name="${newKey[1]}"]`).addClass('is-invalid')
            }
        }
	}
})

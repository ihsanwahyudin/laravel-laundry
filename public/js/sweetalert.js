const showToast = (title, icon, message) => {
    Swal.fire({
        toast: true,
        title: title,
        text: message,
        icon: icon,
        position: 'top-right',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    })
}

const showAlert = (title, icon, message) => {
    Swal.fire({
        title: title,
        text: message,
        icon: icon,
        confirmButtonText: 'Kembali',
        showCancelButton: false,
        confirmButtonColor: '#435ebe',
    })
}

const showDeleteAlert = (title, icon, message, callback) => {
    Swal.fire({
        title,
        icon,
        text: message,
        confirmButtonText: 'Delete !',
        showCancelButton: true,
        confirmButtonColor: '#435ebe',
        cancelButtonColor: '#797979'
    }).then((result) => {
        callback(result);
    })
}

const showConfirmAlert = (title, icon, message, buttonText, callback) => {
    Swal.fire({
        title,
        icon,
        text: message,
        confirmButtonText: buttonText,
        showCancelButton: true,
        confirmButtonColor: '#435ebe',
        cancelButtonColor: '#797979'
    }).then((result) => {
        callback(result);
    })
}

export { showToast, showAlert, showDeleteAlert, showConfirmAlert };

function showSwal(icon, title, message, confirmButtonText, callback) {
    Swal.fire({
        icon: icon,
        title: title,
        text: message,
        showConfirmButton: true,
        allowOutsideClick: false,
        confirmButtonText: confirmButtonText
    }).then(callback);
}

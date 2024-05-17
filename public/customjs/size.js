$(document).ready(function() {

    initialPageload();

    $('#size_form').submit(function(event) {
        event.preventDefault();
        var url = $(this).data('url');
        var formData = new FormData($(this)[0]);
        var productId = $('#product_id').val();
        if (productId) {
            url = BASE_URL + '/update-size/' + productId;
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: 'POST',
            data: formData,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                if (response.status === 200 || response.status === 201) {
                    showSwal('success', 'Success!', response.message, 'OK', function() {
                        location.reload();
                    });
                } else {
                    showSwal('error', 'Error!', 'An unexpected error occurred. Please try again later.', 'OK');
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 500) {
                    showSwal('error', 'Error!', xhr.statusText, 'OK', function() {
                        location.reload();
                    });
                } else{ alert();
                    $('.text-red-500').remove();
                    var errors = xhr.responseJSON.errors; console.log(errors);
                    $.each(errors, function(field, messages) {
                        console.log(field);
                        console.log(messages);

                            $.each(messages, function(index, message) {
                                $('#' + field).closest('.form-group').append('<span class="text-red-500 text-danger">' + message + '</span>');
                            });
                    });
                }
                
            },
            cache: false,
            contentType: false,
            processData: false
        });
    });


    $('#size-table').on('click', '.edit-size', function(e) {
        e.preventDefault();
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'GET',
            success: function(response) {
                $('#edit-modal').modal('show');
                $('.modal-title').text('Edit Size');
                $('#edit_name').val(response.data.name);
                $('#edit_id').val(response.data.id);
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });


    $('#update_btn').click(function(event) {
        event.preventDefault();
        $.ajax({
            url: BASE_URL +'/update-size/'+ $('#edit_id').val(),
            type: 'PUT',
            data: {
                edit_name: $('#edit_name').val()
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                console.log(response);
                if (response.status === 200 || response.status === 201) {
                    showSwal('success', 'Success!', response.message, 'OK', function() {
                        location.reload();
                    });
                } else {
                    showSwal('error', 'Error!', 'An unexpected error occurred. Please try again later.', 'OK');
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 500) {
                    showSwal('error', 'Error!', xhr.statusText, 'OK', function() {
                        location.reload();
                    });
                } else {
                    $('.text-red-500').remove();
                    var errors = xhr.responseJSON.errors;
                    $.each(errors, function(field, messages) {
                        $.each(messages, function(index, message) {
                            $('#' + field).closest('.form-group').append('<span class="text-red-500 text-danger">' + message + '</span>');
                        });
                    });
                }
            },
        });
    });
});

$(document).on('click', '.delete-size', function() {
    var deleteUrl = $(this).data('url');

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: deleteUrl,
                type: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    Swal.fire(
                        'Deleted!',
                        response.message,
                        'success'
                    ).then(function() {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : 'An error occurred while deleting the company.';
                    Swal.fire(
                        'Error!',
                        errorMessage,
                        'error'
                    );
                }
                
            });
        }
    });
});


function initialPageload(params) {
    var table = $('#size-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: BASE_URL +'/size-lists',
        columns: [
            { data: 'id'},
            { data: 'name'},
            { 
                data: null,
                render: function(data, type, full, meta) {
                    return '<div class="btn-group" role="group" aria-label="Company Actions">' +
                               '<button class="btn btn-primary btn-sm edit-size" data-url="' + BASE_URL + '/edit-size/' + full.encriptedId + '" data-id="' + full.id + '">Edit</button>' +
                               '<button class="btn btn-danger btn-sm delete-btn delete-size" data-url="' + BASE_URL + '/delete-size/' + full.id + '" data-id="' + full.id + '">Delete</button>' +
                           '</div>';
                }
            }
            
        ]
    });
    
}
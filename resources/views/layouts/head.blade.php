<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Auto Provisioning</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href=" {{ asset('vendor/bootstrap/css/bootstrap.min.css') }}">
    <link href="{{ asset('vendor/fonts/circular-std/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('libs/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/fontawesome/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/fonts/themify-icons/themify-icons.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/buttons.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/select.bootstrap4.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/datatables/css/fixedHeader.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/waitMe/waitMe.min.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/toastr/toastr.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('vendor/select2-bootstrap4-theme/select2-bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('css/terminal.css') }}">
    <script src=" {{ asset('vendor/jquery/jquery-3.3.1.min.js') }}"></script>
    <script src=" {{ asset('vendor/bootstrap/js/bootstrap.bundle.js') }}"></script>
    <script src=" {{ asset('vendor/slimscroll/jquery.slimscroll.js') }}"></script>
    <script src=" {{ asset('libs/js/main-js.js') }}"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="{{ asset('vendor/datatables/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script>
    <script src="{{ asset('vendor/datatables/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('vendor/datatables/js/data-table.js') }}"></script>
    <script src="{{ asset('vendor/waitMe/waitMe.min.js') }}"></script>
    <script src="{{ asset('vendor/sweetalert2/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('vendor/toastr/toastr.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/jquery-pjax.js') }}"></script>

    <style>
    .btn {
        margin: 0px 3px;
    }
    </style>
</head>

<script>
$('a').on('click', function() {
    event.prefentDefault();
})
$(document).pjax('.page', '#myContent');

function getSearchParams(k) {
    var p = {};
    location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(s, k, v) {
        p[k] = v
    })
    return k ? p[k] : p;
}
var simpanResponse;

/*function goToPage(page) {
    event.preventDefault();
    $.ajax({
        url: "{{ url('auth/check-login') }}",
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function(jqXHR) {
            loadingOpen('.dashboard-wrapper');
        },
        success: function(response) {
            if (response) {
                $("#myContent").load("{{url('')}}" + "/" + page);
            } else {
                location.href = "{{ url('login') }}";
            }
            loadingClose('.dashboard-wrapper');
        }
    })
}*/

function simpan() {
    event.preventDefault();
    var url = $("#url").val();
    var formData = new FormData($('#form_data')[0]);
    $.ajax({
        url: url,
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        beforeSend: function() {
            loadingOpen('.dashboard-wrapper');
            $('#validasi_content').html('');
        },
        success: function(response) {
            loadingClose('.dashboard-wrapper');
            if (response.status == 200) {
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
                if (typeof response.object !== 'undefined') {
                    //if (response.object.length > 0) {
                    $.each(response.object, function(key, value) {
                        $('#' + key).val(value);
                    });
                    //}
                }
            } else if (response.status == 422) {
                $.each(response.error, function(i, val) {
                    $('#validasi_content').append('<li>' + val + '</li>');
                })
                $('#modal_validation').modal('show');
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: response.message
                });
            }
            simpanResponse = response;
        },
        error: function() {
            loadingClose('.dashboard-wrapper');
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }
    });
}

function loadPage(page, selector) {
    event.preventDefault();
    $.ajax({
        url: "{{ url('auth/check-login') }}",
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function(jqXHR) {
            loadingOpen('.dashboard-wrapper');
        },
        success: function(response) {
            if (response) {
                $(selector).load("{{url('')}}" + "/" + page);
            } else {
                location.href = "{{ url('login') }}";
            }
            loadingClose('.dashboard-wrapper');
        }
    })
}
//bsCustomFileInput.init();

function loadingOpen(selector) {
    $(selector).waitMe({
        effect: 'progressBar',
        text: 'Wait ...',
        bg: 'rgba(255,255,255,0.7)',
        color: '#000'
    });
}

function loadingClose(selector) {
    $(selector).waitMe('hide');
}

const Toast = Swal.mixin({
    toast: true,
    position: 'middle-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer)
        toast.addEventListener('mouseleave', Swal.resumeTimer)
    }
})

function refreshDropZone() {
    var myDropzone = Dropzone.forElement("#dropzone");
    myDropzone.removeAllFiles(true);
    $('#keterangan_dropzone').html('');
}

function notificationLogin() {
    Toast.fire({
        icon: 'success',
        title: "Anda login dengan google!"
    });
}

function select2AutoSuggest(selector, endpoint, sourcepoint = '') {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 3,
        cache: true,
        theme: 'bootstrap4',
        ajax: {
            url: '{{ url("panel/select2") }}' + '/' + endpoint,
            type: 'POST',
            dataType: 'JSON',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(params) {
                if (sourcepoint != '') {
                    var query = {
                        search: params.term,
                        sourcepoint: $('#' + sourcepoint).val()
                    }
                } else {
                    var query = {
                        search: params.term,
                        sourcepoint: ''
                    }
                }
                return query;
            },
            processResults: function(data) {
                return {
                    results: data.items
                }
            }
        }
    });
}

function select2AutoSuggestMultiple(selector, endpoint) {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 3,
        allowClear: true,
        multiple: true,
        cache: true,
        ajax: {
            url: '{{ url("panel/select2") }}' + '/' + endpoint,
            type: 'POST',
            dataType: 'JSON',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(params) {
                return {
                    search: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.items
                }
            }
        }
    });
}

function select2AutoSuggestTags(selector, endpoint, node) {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 2,
        allowClear: true,
        tags: true,
        cache: true,
        ajax: {
            url: '{{ url("panel/select2") }}' + '/' + endpoint + '?node=' + $(node).val(),
            type: 'GET',
            dataType: 'JSON',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(params) {
                return {
                    node: node,
                    search: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: data.items
                }
            }
        },
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            } else {
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }
    });
}

function select2Qos(selector, node) {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 4,
        tags: true,
        cache: true,
        ajax: {
            url: '{{ url("panel/select2/qos") }}',
            type: 'GET',
            dataType: 'JSON',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(params) {
                return {
                    node: $(node).val(),
                    search: params.term,
                };
            },
            processResults: function(data) {
                return {
                    results: data.items
                }
            }
        },
        createTag: function(params) {
            var term = $.trim(params.term);
            if (term === '') {
                return null;
            } else {
                return {
                    id: term,
                    text: term,
                    newTag: true
                }
            }
        }
    });
}
</script>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <link rel="stylesheet" href="{{ asset('libs/css/validation.css') }}">

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

    #progressbar {
        overflow: hidden;
        /*CSS counters to number the steps*/
        counter-reset: step;
        width: 100%;
        text-align: center;
    }

    #progressbar li {
        list-style-type: none;
        color: rgb(51, 51, 51);
        text-transform: uppercase;
        font-size: 1em;
        width: 20%;
        float: left;
        position: relative;
    }

    #progressbar li:before {
        content: counter(step);
        counter-increment: step;
        width: 20px;
        line-height: 20px;
        display: block;
        font-size: 1em;
        color: #333;
        background: white;
        border-radius: 3px;
        margin: 0 auto 5px auto;
    }

    /*progressbar connectors*/
    #progressbar li:after {
        content: "";
        width: 100%;
        height: 2px;
        background: white;
        position: absolute;
        left: -50%;
        top: 9px;
        z-index: -1;
        /*put it behind the numbers*/
    }

    #progressbar li:first-child:after {
        /*connector not needed before the first step*/
        content: none;
    }

    /*marking active/completed steps green*/
    /*The number of the step and the connector before it = green*/
    #progressbar li.active:before,
    #progressbar li.active:after {
        background: #7b1fa2;
        color: white;
    }
    </style>
</head>

<script>
/*$('a').on('click', function() {
    event.prefentDefault();
})*/
//$(document).pjax('.page', '#myContent');
function copyText(divID) {
  if (document.selection) {
    var range = document.body.createTextRange();
    range.moveToElementText(document.getElementById(divID));
    range.select().createTextRange();
    document.execCommand("copy");
  } else if (window.getSelection) {
    var range = document.createRange();
    range.selectNode(document.getElementById(divID));
    window.getSelection().addRange(range);
    document.execCommand("copy");
    alert("Config has been copied");
  }
}
function getSearchParams(k) {
    var p = {};
    location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(s, k, v) {
        p[k] = v
    })
    return k ? p[k] : p;
}

var simpanResponse;

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

function select2AutoSuggest(selector, endpoint, sourcepoint = '') {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 1,
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
function allowNumbersOnly(e) {
  var code = e.which ? e.which : e.keyCode;
  if (code > 31 && (code < 46 || code > 57)) {
    e.preventDefault();
  }
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

/*function select2Qos(selector, node) {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 1,
        cache: true,
        theme: 'bootstrap4',
        ajax: {
            url: '{{ url("panel/select2/qos") }}',
            type: 'GET',
            dataType: 'JSON',
            delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(params) {
                var query = {
                    search: params.term,
                    node: $(node).val(),
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
}*/


function pickNode(id, node_id) {
    $('#' + node_id).val($('#' + id + ' option:selected').text());
    checkAll();
}

function generateRandomColor() {
    let maxVal = 0xFFFFFF; // 16777215
    let randomNumber = Math.random() * maxVal;
    randomNumber = Math.floor(randomNumber);
    randomNumber = randomNumber.toString(16);
    let randColor = randomNumber.padStart(6, 0);
    return `#${randColor.toUpperCase()}`
}

function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 40 || code > 57)) {
        e.preventDefault();
    }
}

function allowChar(e, id) {
    const reg = /\`|\~|\!|\@|\#|\$|\%|\^|\&|\*|\(|\)|\+|\=|\[|\{|\]|\}|\||\\|\'|\<|\,|\.|\>|\?|\""|\;|\:|\s/g;
    if (e.key.replace(reg, "") == "") {
        e.preventDefault();
    }
}

var validation;


function setUnavailable(span_id, input_id, text) {
    $('#' + span_id).addClass('not-available');
    $('#' + span_id).removeClass('found');
    $('#' + span_id).removeClass('optional');
    $('#' + span_id).text(text);
    $('#' + input_id).addClass('not-available');
    $('#' + input_id).removeClass('found');
    $('#' + input_id).removeClass('optional');
    validation++;
    //$('#' + input_id).removeClass('loading');
}

function setOptional(span_id, input_id, text) {
    $('#' + span_id).addClass('optional');
    $('#' + span_id).removeClass('not-available');
    $('#' + span_id).removeClass('found');
    $('#' + span_id).text(text);
    $('#' + input_id).addClass('optional');
    $('#' + input_id).removeClass('found');
    $('#' + input_id).removeClass('not-available');
    //validation--;
    //$('#' + input_id).removeClass('loading');
}

function setAvailable(span_id, input_id, text) {
    $('#' + span_id).addClass('found');
    $('#' + span_id).removeClass('not-available');
    $('#' + span_id).removeClass('optional');
    $('#' + span_id).text(text);
    $('#' + input_id).addClass('found');
    $('#' + input_id).removeClass('not-available');
    $('#' + input_id).removeClass('optional');
    //$('#' + input_id).removeClass('loading');
}

$('input').on('change', function(e) {
    // Capitalize all character ever typed.
    $(this).val($(this).val().toUpperCase());
})
$('textarea').on('change', function(e) {
    // Capitalize all character ever typed.
    $(this).val($(this).val().toUpperCase());
})
</script>
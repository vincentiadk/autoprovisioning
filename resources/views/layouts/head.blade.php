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

    if ($('#description_access').val() == "") {
        setUnavailable("description_access_lbl", "description_access", "Please entry description access");
    }
    if ($('#description_backhaul_1').val() == "") {
        setUnavailable("description_backhaul_1_lbl", "description_backhaul_1", "Please entry description backhaul 2");
    }
    if ($('#description_backhaul_2').val() == "") {
        setUnavailable("description_backhaul_2_lbl", "description_backhaul_2", "Please entry description backhaul 2");
    }
    //if ($('#access_description').val() == "") {
    //    setUnavailable("access_description_lbl", "access_description", "Please entry access description");
    //}
    if ($('#vcid').val() == "") {
        setUnavailable("vcid_access_lbl", "vcid", "Please entry VCID/VSI ID");
        setAvailable("vcid_backhaul_1_lbl", "vcid", "");
        setAvailable("vcid_backhaul_2_lbl", "vcid", "");
    }
    if ($('#vsiname').val() == "" && $('#node_manufacture').val() == "HUAWEI") {
        setUnavailable("vsiname_access_lbl", "vsiname", "Please entry VSI Name");
        setAvailable("vsiname_backhaul_1_lbl", "vsiname", "");
        setAvailable("vsiname_backhaul_2_lbl", "vsiname", "");
    }
    if ($('#node_access_name').val() == null) {
        setUnavailable("node_access_lbl", "node_access_name", "Please select node access");
    }
    if ($('#node_manufacture').val() == "HUAWEI" && $('#select_port_access').val() == null) {
        setUnavailable("port_access_lbl", "select_port_access", "Please select port access");
    }
    if ($('#node_manufacture').val() == "ALCATEL-LUCENT" && $('#input_port_access').val() == null) {
        setUnavailable("port_access_lbl", "input_port_access", "Please entry port access");
    }
    if ($('#node_backhaul_1_name').val() == null) {
        setUnavailable("node_backhaul_1_lbl", "node_backhaul_1_name", "Please select node backhaul 1");
    }
    if ($('#node_backhaul_2_name').val() == null) {
        setUnavailable("node_backhaul_2_lbl", "node_backhaul_2_name", "Please select node backhaul 2");
    }
    if ($('#vlan_access').val() == "") {
        setUnavailable("vlan_access_lbl", "vlan_access", "Please entry VLAN access");
    }
    var url = $("#url").val();
    var formData = new FormData($('#form_data')[0]);
    var mvar = "";
    $('#validasi_content').empty();
    $("span.not-available").each(function() {
        $('#validasi_content').append('<li>' + $(this).html() + '</li>');
        mvar += $(this).html();
    });
    if(mvar != "") {
        $('#modal_validation').modal('show');
    }
    if (mvar == "") {
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
                        $.each(response.object, function(key, value) {
                            $('#' + key).val(value);
                        });
                    }
                    if(response.url != "") {
                        window.open(response.url, "_self");
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

function select2Node(selector, node, controller, manufacture = 'ALCATEL-LUCENT') {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 2,
        cache: true,
        theme: 'bootstrap4',
        ajax: {
            url: '{{ url("panel/select2") }}' + '/' + controller + '?manufacture=' + manufacture,
            type: 'GET',
            dataType: 'JSON',
            //delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(params) {
                var query = {
                    search: params.term,
                    manufacture: manufacture,
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
}


function pickNode(id, node_id) {
    $('#' + node_id).val($('#' + id + ' option:selected').text());
    checkAll();
}

function checkScheduler(id) {
    if ($('#' + id).val() != '') {
        setAvailable(id + '_lbl', id, "Scheduler is set");
    } else {
        setOptional(id + '_lbl', id, "Please choose a scheduler");
    }
}

function checkTaskId(task_id) {
    if ($('#task_id').text().trim() == '') {

        $('#btn_confirm_task').hide();
        $('#btn_check_task').hide();
    } else {
        $.ajax({
            url: "{{ url('panel/metro/status-task') }}" + '?task_id=' + task_id,
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                $('#div_status').html(response.status);
                if (response.status == 'submitted' || response.status == 'executing' || response.status ==
                    'done') {
                    $('input').attr('readonly', true);
                    $('.select2').attr('disabled', true);
                } else {
                    $('#btn_confirm_task').show();
                }
                $('#btn_check_task').show();
            }
        })

    }
}

function checkTask(task_id) {
    $.ajax({
        url: "{{ url('panel/metro/check-task') }}" + '?task_id=' + task_id,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            var message = "<div class='row'>";
            for (var i = 0; i < response.length; i++) {
                message += '<div class="col-md-4">' +
                    '<div class="flex terminal-title">' +
                    '<div class="flex terminal-button">' +
                    '<div class="rounded-full w-4 h-4 bg-red mr-2"></div>' +
                    '<div class="rounded-full w-4 h-4 bg-green mr-2"></div>' +
                    '<div class="rounded-full w-4 h-4 bg-yellow mr-2"></div>' + response[i].node +
                    '</div></div>';
                message += response[i].plan[0].replace(/\n/g, '<br />');
                message += "</div><br/>";

            }
            message += "</div>";
            $('#plans').html(message);
            $('#modal-plans').modal('show');
        }
    });
}

function generateRandomColor() {
    let maxVal = 0xFFFFFF; // 16777215
    let randomNumber = Math.random() * maxVal;
    randomNumber = Math.floor(randomNumber);
    randomNumber = randomNumber.toString(16);
    let randColor = randomNumber.padStart(6, 0);
    return `#${randColor.toUpperCase()}`
}

function confirmTask(task_id) {
    if (confirm("Apakah Anda yakin?")) {
        $.ajax({
            url: "{{ url('panel/metro/confirm-task') }}" + '?task_id=' + task_id,
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                alert('confirmed!');
            }
        });
    }
}

function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 40 || code > 57)) {
        e.preventDefault();
    }
}

function loadScheduler(node, id, oldScheduler = '') {
    var div = '<div class="loading-select" id="div_' + id + '"></div>';
    $('#' + id).prev().append(div);
    $.ajax({
        url: "{{ url('panel/select2/scheduler') }}" + '?node=' + node,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            $('#' + id + ' option').remove();
            var option = "";
            for (var i = 0; i < response.length; i++) {
                option += "<option value='" + response[i].name + "'>" + response[i].name + "</option>";
            }
            $('#' + id).append(option);
            if (oldScheduler != '') {
                $('#' + id).val(oldScheduler);
            }
            checkScheduler(id);
            $('#div_' + id).remove();
        }
    });
}
var validation;

function checkAll() {
    //validation = 0;
    $('#div_vsiname').hide();
    $('#select_port_access').hide();
    $('#select_port_backhaul_1').hide();
    $('#select_port_backhaul_2').hide();
    /*checkDescription('service_description', 'service_description_lbl');
    checkDescription('access_description', 'access_description_lbl');

    checkNode('node_access_name', 'node_access_lbl', 'node_access', $('#node_access_scheduler').val());
    checkNode('node_backhaul_1_name', 'node_backhaul_1_lbl', 'node_backhaul_1', $('#node_backhaul_1_scheduler').val());
    checkNode('node_backhaul_2_name', 'node_backhaul_2_lbl', 'node_backhaul_2', $('#node_backhaul_2_scheduler').val());

    checkVcid('vcid', 'vcid_access_lbl');
    checkVcid('vcid', 'vcid_backhaul_1_lbl');
    checkVcid('vcid', 'vcid_backhaul_2_lbl');

    checkInterface('port_access', 'vlan_access', 'port_access_lbl', 'vlan_access_lbl', 'node_access_name');
    checkInterface('port_backhaul_1', 'vlan_backhaul_1', 'port_backhaul_1_lbl', 'vlan_backhaul_1_lbl',
        'node_backhaul_1_name');
    checkInterface('port_backhaul_2', 'vlan_backhaul_2', 'port_backhaul_2_lbl', 'vlan_backhaul_2_lbl',
        'node_backhaul_2_name');

    checkQosBefore('qos_access', 'qos_access_lbl', 'node_access_name');
    checkQosBefore('qos_backhaul_1', 'qos_backhaul_1_lbl', 'node_backhaul_1_name');
    checkQosBefore('qos_backhaul_2', 'qos_backhaul_2_lbl', 'node_backhaul_2_name');

    checkScheduler('node_access_scheduler');
    checkScheduler('node_backhaul_1_scheduler');
    checkScheduler('node_backhaul_2_scheduler');
    */
}

function checkDescription(id, lbl) {
    $('#' + id).addClass('loading');
    if ($('#' + id).val().length < 6) {
        setUnavailable(lbl, id, "Description Min 6 character");
    } else {
        setAvailable(lbl, id, "OK");
    }
    $('#' + id).removeClass('loading');
}


function checkNode(id, lbl, textbox, oldScheduler = '') {
    var name = id.replace('_name', '').replace('node_', '');
    $.ajax({
        url: "{{ url('panel/metro/check-node') }}" + '?name=' + $('#' + id).val(),
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
            var div = '<div class="loading-select" id="div_' + id + '"></div>';
            $('#' + id).prev().prev().append(div);
        },
        success: function(response) {
            if (response.status == 200) {
                if ($('#node_manufacture').val() == "") {
                    $('#node_manufacture').val(response.manufacture);
                }
                if ($('#node_manufacture').val() == response.manufacture) {
                    setAvailable(lbl, id, "Found Node : " + response.ip + " manufacture " + response
                        .manufacture);
                    $('#' + textbox).val(response.ip);

                    $('#' + id.replace('name', '') + 'manufacture').val(response.manufacture);

                    if (response.manufacture == "HUAWEI") {
                        $('#select_port_' + name).show();
                        select2Node('#select_port_' + name, '#node_' + name + '_name', 'port-huawei',
                            response
                            .manufacture);
                        $('#input_port_' + name).hide();
                        $('#node_' + name + '_scheduler').hide();
                        $('#node_' + name + '_scheduler').val('');
                        $('#div_vsiname').show();
                        $('#lblvcid').text('VSI ID');
                    } else {
                        $('#select_port_' + name).hide();
                        $('#input_port_' + name).show();
                        $('#node_' + name + '_scheduler').show();
                        $('#node_' + name + '_scheduler').val();
                        $('#div_vsiname').hide();
                        $('#vsiname').val('');
                        $('#lblvcid').text('VCID');
                    }
                    $('#port_' + name + '_lbl_top').html('Port ' + name.replace("_", " "));
                    select2Node('#qos_' + name, '#node_' + name + '_name', 'qos', response.manufacture);
                } else {
                    setUnavailable(lbl, id, "Cannot choose diferent manufacture!");
                    $('#select_port_' + name).hide();
                    $('#port_' + name).hide();
                    $('#' + textbox).val('');
                    $('#' + id.replace('name', '') + 'manufacture').val('');
                }
            } else {
                setUnavailable(lbl, id, "Node " + name + " unavailable");
                $('#select_port_' + name).hide();
                $('#port_' + name).hide();
                $('#' + textbox).val('');
                $('#' + id.replace('name', '') + 'manufacture').val('');
            }
            if ($('#' + id.replace('name', 'scheduler')).val() != "") {
                loadScheduler($('#' + id).val(), id.replace('name', 'scheduler'), oldScheduler);
            } else {
                loadScheduler($('#' + id).val(), id.replace('name', 'scheduler'));
            }
            if (name == "access") {
                checkAccess();
            }
        },
        complete: function() {
            $('#div_' + id).remove();
        }
    });
}

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

function checkVcid(id, lbl, vcidOrVsiname) {
    var name = lbl.replace('vcid_', '').replace('_lbl', '');
    var vsiname = $('#vsiname').val();
    var url = "{{ url('panel/metro/check-vcid') }}" + '?name=' + $('#node_' + name + '_name').val();
    if (vcidOrVsiname == "vcid") {
        url += '&vcid=' + $('#' + id).val() + '&vsiname=';
    } else if (vcidOrVsiname == "vcid") {
        url += '&vcid=&vsiname=' + vsiname;
    } else {
        url += '&vcid=' + $('#' + id).val() + '&vsiname=' + vsiname;
    }
    if ($('#' + id).val().length < 4) {
        setUnavailable(lbl, id, "VCID/VSI ID " + name + " min 4 characters");
    }
    $.ajax({
        url: url,
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
            $('#' + id).addClass('loading');
        },
        success: function(response) {
            if (response.status !== 200) {
                if ($('#' + id).val().length < 4) {
                    setUnavailable(lbl, id, "VCID/VSI ID " + name + " min 4 character");
                } else {
                    setAvailable(lbl, id, "VCID/VSI ID " + name + " Available");
                }
                if ($('#vsiname').val() != "" && $('#node_manufacture').val() == "HUAWEI") {
                    setAvailable('vsiname_' + name + '_lbl', 'vsiname', "VSI-Name " + name + " available");
                } else if($('#vsiname').val() == "" && $('#node_manufacture').val() == "HUAWEI") {
                    setUnavailable('vsiname_' + name + '_lbl', 'vsiname', "Please entry VSI-Name " + name);
                }
                $('#vlan_' + name)
                    .removeAttr("readonly");
                $('#input_port_' + name)
                    .removeAttr("readonly");
                $("#select_port_" + name)
                    .trigger("change")
                    .removeAttr('disabled');

                if (name != 'access') {
                    setOptional('vlan_' + name + "_lbl", 'vlan_' + name, '(optional) Please entry VLAN ' +
                        name);
                    if (response.manufacture == "ALCATEL-LUCENT") {
                        setOptional('port_' + name + "_lbl", 'input_port_' + name,
                            '(optional) Please entry PORT ' + name);
                    } else {
                        setOptional('port_' + name + "_lbl", 'select_port_' + name,
                            '(optional) Please select PORT ' + name);
                    }

                } else {
                    setUnavailable('vlan_' + name + "_lbl", 'vlan_' + name, 'Please entry VLAN ' + name);
                    if (response.manufacture == "ALCATEL-LUCENT") {
                        setUnavailable('port_' + name + "_lbl", 'input_port_' + name, 'Please entry PORT ' +
                            name);
                    } else {
                        setUnavailable('port_' + name + "_lbl", 'select_port_' + name,
                            'Please select PORT ' + name);
                    }
                }
            } else { //ditemukan vcid, port dan vlan
                if (name != 'access') {
                    $('#qos_' + name).val('');
                    $('#node_' + name + '_scheduler').val('');
                    var vlanPort = "";

                    $('#vlan_' + name)
                        .val(response.vlan)
                        .attr("readonly", true);

                    $('#input_port_' + name)
                        .val(response.port)
                        .attr("readonly", true);

                    var newOption = new Option(response.port, response.port, true, true);
                    $("#select_port_" + name)
                        .append(newOption)
                        .trigger("change")
                        .select2({
                            disabled: 'readonly'
                        });

                    setAvailable(lbl, id, "Node " + name + " already configured, and used for " + response
                        .description);
                    if (vcidOrVsiname == "vcid" && response.manufacture == 'HUAWEI') {
                        $('#vsiname').val(response.description).show();
                    } else if (vcidOrVsiname == "vsiname") {
                        $('#vcid').val(response.vcid);
                        setAvailable('vsiname_' + name + '_lbl', 'vsiname', "VSI-Name already configured");
                    } else if (vcidOrVsiname != "vcid" && vcidOrVsiname != "vsiname" && response
                        .manufacture == 'HUAWEI') {
                        if ($('#vsiname').val() == '') {
                            $('#vsiname').val(response.description)
                        }
                        if ($('#vcid').val() == '') {
                            $('#vcid').val(response.vcid)
                        }
                    }
                    setAvailable('vsiname_' + name + '_lbl', 'vsiname', "VSI-Name " + name +
                        " already configured");
                    setAvailable('vlan_' + name + "_lbl", 'vlan_' + name, 'Vlan ' + name +
                        " already configured");
                    setAvailable('port_' + name + "_lbl", 'input_port_' + name, 'Port ' + name +
                        " already configured");
                    setAvailable('port_' + name + "_lbl", 'select_port_' + name, 'Port ' + name +
                        " already configured");
                } else {
                    checkAccess()
                    /*$('#vlan_' + name)
                        .val(response.vlan)
                        .attr("readonly", true);
                    $('#input_port_' + name)
                        .val(response.port)
                        .attr("readonly", true);
                    var newOption = new Option(response.port, response.port, true, true);
                    $("#select_port_" + name)
                        .append(newOption)
                        .trigger("change")
                        .select2({
                            disabled: 'readonly'
                        });
                    setUnavailable(lbl, id, "Node " + name +
                        " already configured and unavailable for VCID = " + response.vcid);
                    if (vcidOrVsiname == "vcid" && response.manufacture == 'HUAWEI') {
                        $('#vsiname').val(response.description).show();
                    } else if (vcidOrVsiname == "vsiname") {
                        $('#vcid').val(response.vcid);
                        setUnavailable('vsiname_' + name + '_lbl', 'vsiname',
                        "VSI-Name already configured");
                    }
                    setUnavailable('vsiname_' + name + '_lbl', 'vsiname', "VSI-Name " + name +
                        " already configured and unavailable");
                    setUnavailable('vlan_' + name + "_lbl", 'vlan_' + name, 'Vlan ' + name +
                        " already configured and unavailable, please change VCID/VSI name to use this vlan"
                        );
                    setUnavailable('port_' + name + "_lbl", 'input_port_' + name, 'Port ' + name +
                        " already configured and unavailable, please change VCID/VSI name to use this port"
                        );
                    setUnavailable('port_' + name + "_lbl", 'select_port_' + name, 'Port ' + name +
                        " already configured and unavailable, please change VCID/VSI name to use this port"
                        );
                    //checkInterface(name);*/
                }
            }
            if (!$('#node_' + name + '_lbl').hasClass("found") && name != "access") {
                setUnavailable(lbl, id, "Node " + name + " not valid");
            }
        },
        complete: function() {
            $('#' + id).removeClass('loading');
        }
    });
}

function checkAccess() {
    var manufacture = $('#node_manufacture').val();
    var port = "";
    var vlan = $('#vlan_access').val();
    var vcid = $('#vcid').val();
    var node = $('#node_access_name').val();
    if (manufacture == "HUAWEI") {
        port = $('#select_port_access').val();
    } else {
        port = $('#input_port_access').val();
    }
    $('#hidden_port_access').val(port);
    if (port == "") {
        setUnavailable('port_access_lbl', 'input_port_access', "Please entry port access");
        setUnavailable('port_access_lbl', 'select_port_access', "Please entry port access");
    }
    if (vlan == "") {
        setUnavailable('vlan_access_lbl', 'vlan_access', "Please entry VLAN access");
    }
    if (vlan.length < 3) {
        setUnavailable('vlan_access_lbl', 'vlan_access', "VLAN access min 3 characters");
    }
    if (vcid == "") {
        setUnavailable('vcid_access_lbl', 'vcid', "Please entry VCID/VSI ID access");
    }
    if (vcid.length < 4) {
        setUnavailable('vcid_access_lbl', 'vcid', "VCID/VSI ID min 4 characters");
    }
    if (node == "" || node == null) {
        setUnavailable('vcid_access_lbl', 'vcid', "Please select node access");
        setUnavailable('node_access_lbl', 'node_access_name', "Please select node access");
    }
    //checkPort("access");
    $.ajax({
        url: "{{ url('panel/metro/check-access') }}" + '?name=' + node +
            '&vlan=' + $('#vlan_access').val() +
            '&port=' + port +
            '&vcid=' + $('#vcid').val() +
            '&vsiname=' + $('#vsiname').val() +
            '&manufacture=' + manufacture,
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
            //    var div = '<div class="loading-select" id="div_' + id + '"></div>';
            //    $('#' + id).prev().prev().append(div);
        },
        success: function(response) {
            if (node != "") {
                if (manufacture == "HUAWEI") {
                    var vcidLbl = "VSI ID";
                } else {
                    var vcidLbl = "VCID";
                }
                if (response.statusVcid != 200 && vcid != "" && vcid.length > 3) {
                    setAvailable('vcid_access_lbl', 'vcid', vcidLbl + " access available");
                } else if (response.statusVcid == 200 && vcid != "" && vcid.length > 3) {
                    var msgVcid = vcidLbl + " access configured with " + response.interfaces.total +
                        " interfaces ";
                    if (response.interfaces.total == 1) {
                        msgVcid += response.interfaces.result[0].name;
                    }
                    setAvailable('vcid_access_lbl', 'vcid', msgVcid);
                }
                
                if (response.statusPort == 200 && port != "") {
                    if(response.vcid == vcid) {
                        setUnavailable('port_access_lbl', 'input_port_access', "Interfaces " + response
                            .interface + " already configured with " + vcidLbl + " = " + response.vcid);
                        setUnavailable('port_access_lbl', 'select_port_access', "Interfaces " + response
                            .interface + " already configured with " + vcidLbl + " = " + response.vcid);
                        setUnavailable('vcid_access_lbl', 'vcid', msgVcid);
                    }
                } else if (response.statusPort != 200 && port != "") {
                    setAvailable('port_access_lbl', 'input_port_access', "Port access available");
                    setAvailable('port_access_lbl', 'select_port_access', "Port access available");
                }
                if (response.statusVlan == 200 && vlan != "" && vlan.length > 2) {
                    setUnavailable('vlan_access_lbl', 'vlan_access', "Interfaces " + response.interface +
                        " already configured with " + vcid + " = " + response.vcid);
                } else if (response.statusVlan != 200 && vlan != "" && vlan.length > 2) {
                    setAvailable('vlan_access_lbl', 'vlan_access', "VLAN access available");
                }
            }
        },
        complete: function() {
            $('#div_' + id).remove();
        }
    });
}

$('input').on('change', function(e) {
    // Capitalize all character ever typed.
    $(this).val($(this).val().toUpperCase());
})

function checkQosBefore(id, lbl, node) {
    var name = id.replace('qos_', '');
    var qosType = "";
    if (id.includes('access')) {
        qosType = "access";
    } else if (id.includes('backhaul_1')) {
        qosType = "backhaul 1";
    } else {
        qosType = "bakhaul 2";
    }
    var manufacture = $('#node_' + name + '_manufacture').val();
    if($('#qos_'+name+'_install').val() == 1) {
        $.ajax({
            url: "{{ url('panel/metro/check-qos') }}" + '?node=' + $('#' + node).val() +
                '&qos=' + $('#' + id).val() +
                '&manufacture=' + manufacture,
            contentType: 'application/json',
            dataType: 'json',
            beforeSend: function() {
                var div = '<div class="loading-select" id="div_' + id + '"></div>';
                $('#' + id).prev().prev().append(div);
            },
            success: function(response) {
                if (response.status == 200) {
                    setAvailable(lbl, id, response.message);
                } else {
                    setUnavailable(lbl, id, "Qos " + qosType + " not available");
                }
            },
            complete: function() {
                $('#div_' + id).remove();
            }
        });
        setAvailable(lbl, id, "");
    }
}

function checkPort(name) {
    var port = '';
    if ($('#node_manufacture') == 'HUAWEI') {
        port = $("#select_port_" + name).val();
    } else {
        port = $("#input_port_" + name).val();
    }
    $.ajax({
        url: "{{ url('panel/metro/check-port') }}" + '?port=' + port +
            '&name=' + $("#node_" + name + '_name').val(),
        dataType: 'json',
        beforeSend: function() {
            $('#select_port_' + name).addClass('loading');
            $('#input_port_' + name).addClass('loading');
        },
        success: function(response) {
            if (response.status == 200) {
                if (response.parent != port) {
                    $('#port_' + name + '_lbl_top').html('Port ' + name.replace("_", " ") + ' : ' + port +
                        ' is a member of ' + response.parent)
                } else {
                    $('#port_' + name + '_lbl_top').html('Port ' + name.replace("_", " "));
                }
                $("#select_port_" + name).val(response.parent);
                $("#input_port_" + name).val(response.parent);
                $("#hidden_port_" + name).val(response.parent);
            } else {
                $('#port_' + name + '_lbl_top').html('Port ' + name.replace("_", " "));
                $("#hidden_port_" + name).val(port);
            }
        },
        complete: function() {
            $('#select_port_' + name).removeClass('loading');
            $('#input_port_' + name).removeClass('loading');
            if (name != "access") {
                checkInterface(name);
            } else {
                checkAccess();
            }
        }
    });
}

function checkInterface(name) {
    var manufacture = 'node_' + name + '_manufacture';
    var node = 'node_' + name + '_name';
    var lbl_port = 'port_' + name + '_lbl';
    var lbl_vlan = 'vlan_' + name + '_lbl';
    var vlan = 'vlan_' + name;
    var value_node = $('#' + node).val();

    if ($('#' + manufacture).val() == "ALCATEL-LUCENT") {
        var port = 'input_port_' + name;
        var portVal = $('#' + port).val();

    } else {
        var port = 'select_port_' + name;
        var portVal = $('#' + port).val();
    }
    if (value_node == '' || value_node == null) {
        setUnavailable(lbl_port, port, "Please choose node " + name.replace('_', ' '));
        setUnavailable(lbl_vlan, vlan, "Please choose node " + name.replace('_', ' '));
    } else if (portVal == '' || portVal == null) {
        if ($('#input_' + port).css('display') == 'block') {
            if(name != "access") {
                setOptional(lbl_port, port, "Please entry port " + name.replace('_', ' '));
            } else {
                setUnavailable(lbl_port, port, "Please entry port " + name.replace('_', ' '));
            }
        } else {
            if(name != "access") {
                setOptional(lbl_port, port, "Please entry port " + name.replace('_', ' '));
            } else {
                setUnavailable(lbl_port, port, "Please entry port " + name.replace('_', ' '));
            }
        }
        setOptional(lbl_vlan, vlan, "Please entry port " + name.replace('_', ' '));
    } else if ($('#' + vlan).val() == '' || $('#' + vlan).val() == null) {
        if ($('#input_' + port).css('display') == 'block') {
            setOptional(lbl_port, port, "Please entry vlan " + name.replace('_', ' '));
        } else {
            setOptional(lbl_port, port, "Please entry vlan " + name.replace('_', ' '));
        }
        setOptional(lbl_vlan, vlan, "Please entry vlan " + name.replace('_', ' '));
    } else if ($('#' + vlan).val().length < 4) {
        setUnavailable(lbl_port, port, "VLAN must be 4 digits");
        setUnavailable(lbl_vlan, vlan, "VLAN must be 4 digits");
    } else {
        var urlCheck = "{{ url('panel/metro/check-interface') }}" + '?name=' + value_node +
            '&port=' + portVal +
            '&vlan=' + $('#' + vlan).val() +
            '&manufacture=' + $('#' + manufacture).val();
        $.ajax({
            url: urlCheck,
            contentType: 'application/json',
            dataType: 'json',
            beforeSend: function() {
                $('#' + port).addClass('loading');
                $('#' + vlan).addClass('loading');
            },
            success: function(response) {
                if (response.code !== 200) {
                    setAvailable(lbl_port, port, "Port " + name + " available");
                    setAvailable(lbl_vlan, vlan, "VLAN " + name + " available");
                } else { //jika sudah used
                    $('#vcid').val(response.vcid);
                    if ($('#' + manufacture).val() == "HUAWEI") {
                        $('#vsiname').val(response.vsiname);
                        setAvailable('vcid_' + name + "_lbl", 'vcid_' + name, "VSI ID " + name +
                            " available");
                    } else {
                        setAvailable('vcid_' + name + "_lbl", 'vcid_' + name, "VCID " + name +
                        " available");
                    }
                    setAvailable(lbl_port, port, response.message);
                    setAvailable(lbl_vlan, vlan, response.message);
                }
                if ($('#' + manufacture).val() == "HUAWEI") {
                    $('#select_port_' + name).show();
                    $('#input_port_' + name).hide();
                } else {
                    $('#select_port_' + name).hide();
                    $('#input_port_' + name).show();
                }


            },
            complete: function() {
                $('#' + port).removeClass('loading');
                $('#' + vlan).removeClass('loading');
            }
        });
    }
    $('#vlan_' + name + '_lbl').show();
    $('#port_' + name + '_lbl').show();
    $('#qos_' + name + '_lbl').show();
    $('#node_' + name + '_scheduler_lbl').show();
}
</script>
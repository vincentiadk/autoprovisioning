<style>
.found {
    color: #28a745;
    font-size: 80%;
}

.not-available {
    font-size: 80%;
    color: #dc3545;
}

.form-control.not-available {
    color: #dc3545;
    border: 1px solid #dc3545;
}

.form-control.found {
    color: #28a745;
    border: 1px solid #28a745;
}

.loading {
    background-color: white;
    background-image: url("{{ url('storage/spin2.gif') }}");
    background-size: 25px 25px;
    background-position: right center;
    background-repeat: no-repeat;
}

.loading-select {
    width: 25px;
    height: 25px;
    background-color: transparent;
    position: absolute;
    margin-right: 0px;
    margin-left: 70%;
    margin-top: 10px;
    z-index: 999;
    background-image: url(http://localhost:8000/storage/spin2.gif);
    background-size: 25px 25px;
    background-position: right center;
    background-repeat: no-repeat;
}
</style>
<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="card-title mb-0">
                {{ $data['title'] }}
            </h4>
            Task ID : <span id="task_id"> {{ $data['metro']->task_id }} </span>

        </div>
    </div>
    <!--row-->

    <hr>
    <div class="row mt-4 mb-4">
        <input type="hidden" name="metro_list_id" id="metro_list_id"
            value="{{ $data['metro']->id ? $data['metro']->id : '' }}">
        <div class="col-sm-10">
            <div class="form-group">
                <label for="service_description" class="form-control-label">
                    Service Description
                </label>
                <input type="text" name="service_description" id="service_description" class="form-control"
                    value="{{ $data['metro']->service_description }}" required onchange="checkAll()">
                <span id="service_description_lbl" class="not-available"></span>
            </div>
            <div class="form-group">
                <label for="access_description" class="form-control-label">
                    Access Description
                </label>
                <input type="text" name="access_description" id="access_description" class="form-control"
                    value="{{ $data['metro']->access_description }}" required onchange="checkAll()">
                <span id="access_description_lbl" class="not-available"></span>
            </div>
            <div class="form-group">
                <label for="vcid" class="form-control-label">
                    VCID
                </label>
                <input type="tel" name="vcid" id="vcid" class="form-control" value="{{ $data['metro']->vcid }}"
                    onkeypress="allowNumbersOnly(event)" onchange="checkAll()" required>
                <span id="vcid_lbl" class="not-available"></span>
            </div>

            <div class="row">
                <div class="col-md-4" style="background: #cdf5fb;    padding: 10px;">
                    <div class="form-group">
                        <label for="vlan" class="form-control-label">
                            Node Access
                        </label>
                        <input type="hidden" name="node_access" id="node_access"
                            value="{{ $data['metro']->node_access }}">
                        <select class="select2 form-control" id="node_access_name" name="node_access_name"
                            onchange="checkAll()">
                            @if($data['metro']->node_access != '')
                            <option value="{{$data['metro']->node_access_name}}" selected>
                                {{$data['metro']->node_access_name}}
                            </option>
                            @endif
                        </select>
                        <span id="node_access_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="port_access" class="form-control-label">
                            Port Akses
                        </label>
                        <input type="tel" name="port_access" id="port_access" class="form-control"
                            value="{{ $data['metro']->port_access }}" onchange="checkAll()">
                        <span id="port_access_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="vlan_access" class="form-control-label">
                            VLAN
                        </label>
                        <input type="tel" name="vlan_access" id="vlan_access" class="form-control"
                            value="{{ $data['metro']->vlan_access }}" onkeypress="allowNumbersOnly(event)"
                            onchange="checkAll()">
                        <span id="vlan_access_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="qos_access" class="form-control-label">
                            QOS access
                        </label>
                        <select class="form-control" id="qos_access" name="qos_access" onchange="checkAll()">
                            @if($data['metro']->qos_access != '')
                            <option value="{{$data['metro']->qos_access}}" selected>{{$data['metro']->qos_access}}
                            </option>
                            @endif
                        </select>
                        <span id="qos_access_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="node_access_scheduler" class="form-control-label">
                            Scheduler access
                        </label>
                        <select class="select2 form-control" id="node_access_scheduler" name="scheduler_access" onchange="checkScheduler(id)">
                            @if($data['metro']->scheduler_access != '')
                            <option value="{{$data['metro']->scheduler_access}}" selected>
                                {{$data['metro']->scheduler_access}}
                            </option>
                            @endif
                        </select>
                        <span id="node_access_scheduler_lbl" class="not-available"></span>
                    </div>
                </div>
                <div class="col-md-4" style="    background: #bff3c8bb;    padding: 10px;">
                    <div class="form-group">
                        <label for="node_backhaul_1" class="form-control-label">
                            Node Backhaul 1
                        </label>
                        <input type="hidden" name="node_backhaul_1" id="node_backhaul_1"
                            value="{{ $data['metro']->node_backhaul_1 }}">
                        <select class="select2 form-control col-8" id="node_backhaul_1_name" name="node_backhaul_1_name"
                            onchange="checkAll()">
                            @if($data['metro']->node_backhaul_1_name != '')
                            <option value="{{$data['metro']->node_backhaul_1_name}}" selected>
                                {{$data['metro']->node_backhaul_1_name}}</option>
                            @endif
                        </select>
                        <span id="node_backhaul_1_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="port_backhaul_1" class="form-control-label">
                            Port Backhaul 1
                        </label>
                        <input type="tel" name="port_backhaul_1" id="port_backhaul_1" class="form-control"
                            value="{{ $data['metro']->port_backhaul_1 }}" onchange="checkAll()">
                        <span id="port_backhaul_1_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="vlan_backhaul_1" class="form-control-label">
                            VLAN Backhaul 1
                        </label>
                        <input type="tel" name="vlan_backhaul_1" id="vlan_backhaul_1" class="form-control"
                            value="{{ $data['metro']->vlan_backhaul_1 }}" onkeypress="allowNumbersOnly(event)"
                            onchange="checkAll()">
                        <span id="vlan_backhaul_1_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="qos_backhaul_1" class="form-control-label">
                            QOS Backhaul 1
                        </label>
                        <select class="select2 form-control" id="qos_backhaul_1" name="qos_backhaul_1"
                            onchange="checkAll()">
                            @if($data['metro']->qos_backhaul_1 != '')
                            <option value="{{$data['metro']->qos_backhaul_1}}" selected>
                                {{$data['metro']->qos_backhaul_1}}</option>
                            @endif
                        </select>
                        <span id="qos_backhaul_1_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="node_backhaul_1_scheduler" class="form-control-label">
                            Scheduler Backhaul 1
                        </label>
                        <select class="select2 form-control" id="node_backhaul_1_scheduler" name="scheduler_backhaul_1" onchange="checkScheduler(id)">
                            @if($data['metro']->scheduler_backhaul_1 != '')
                            <option value="{{$data['metro']->node_backhaul_1_scheduler}}" selected>
                                {{$data['metro']->scheduler_backhaul_1}}
                            </option>
                            @endif
                        </select>
                        <span id="node_backhaul_1_scheduler_lbl" class="not-available"></span>
                    </div>
                </div>
                <div class="col-md-4" style="background: #e3ebfd;    padding: 10px;">
                    <div class="form-group">
                        <label for="node_backhaul_2" class="form-control-label">
                            Node Backhaul 2
                        </label>
                        <input type="hidden" name="node_backhaul_2" id="node_backhaul_2"
                            value="{{ $data['metro']->node_backhaul_2 }}">
                        <select class="select2 form-control" id="node_backhaul_2_name" name="node_backhaul_2_name"
                            onchange="checkAll()">
                            @if($data['metro']->node_backhaul_2_name != '')
                            <option value="{{$data['metro']->node_backhaul_2_name}}" selected>
                                {{ $data['metro']->node_backhaul_2_name}}</option>
                            @endif
                        </select>
                        <span id="node_backhaul_2_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="port_backhaul_2" class="form-control-label">
                            Port Backhaul 2
                        </label>
                        <input type="tel" name="port_backhaul_2" id="port_backhaul_2" class="form-control"
                            value="{{ $data['metro']->port_backhaul_2 }}" onchange="checkAll()">
                        <span id="port_backhaul_2_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="vlan_backhaul2" class="form-control-label">
                            VLAN Backhaul 2
                        </label>
                        <input type="tel" name="vlan_backhaul_2" id="vlan_backhaul_2" class="form-control"
                            value="{{ $data['metro']->vlan_backhaul_2 }}" onkeypress="allowNumbersOnly(event)"
                            onchange="checkAll()">
                        <span id="vlan_backhaul_2_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="qos_backhaul_2" class="form-control-label">
                            QOS Backhaul 2
                        </label>
                        <select class="select2 form-control" id="qos_backhaul_2" name="qos_backhaul_2"
                            onchange="checkAll()">
                            @if($data['metro']->qos_backhaul_2 != '')
                            <option value="{{$data['metro']->qos_backhaul_2}}" selected>
                                {{$data['metro']->qos_backhaul_2}}</option>
                            @endif
                        </select>
                        <span id="qos_backhaul_2_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="node_backhaul_2_scheduler" class="form-control-label">
                            Scheduler Backhaul 2
                        </label>
                        <select class="select2 form-control" id="node_backhaul_2_scheduler" name="scheduler_backhaul_2" onchange="checkScheduler(id)">
                            @if($data['metro']->scheduler_backhaul_2 != '')
                            <option value="{{$data['metro']->scheduler_backhaul_2}}" selected >
                                {{$data['metro']->scheduler_backhaul_2}}
                            </option>
                            @endif
                        </select>
                        <span id="node_backhaul_2_scheduler_lbl" class="not-available"></span>
                    </div>
                </div>
            </div>

            <input type="hidden" id="url" value="{{ url('panel/metro/store') }}">
        </div>
        <div class="col-sm-2">
            <a href="#" class="btn btn-info" onclick="checkTask({{ $data['metro']->task_id }})" style="margin:10px"
                id="btn_check_task">Check Task</a>
            <a href="#" class="btn btn-success" onclick="confirmTask({{ $data['metro']->task_id }})" style="margin:10px"
                id="btn_confirm_task">Confirm Task</a>
        </div>
    </div>
    <script>
    checkTaskId();
    var validation, NodeAccess, NodeBackhaul_1, NodeBackhaul_2;
    select2AutoSuggest('#node_access_name', 'node');
    select2AutoSuggest('#node_backhaul_1_name', 'node');
    select2AutoSuggest('#node_backhaul_2_name', 'node');
    select2Qos('#qos_access', '#node_access_name');
    select2Qos('#qos_backhaul_1', '#node_backhaul_1_name');
    select2Qos('#qos_backhaul_2', '#node_backhaul_2_name');
    
    function pickNode(id, node_id) {
        $('#' + node_id).val($('#' + id + ' option:selected').text());
        checkAll();
    }
    function checkScheduler(id) {
        if($('#' + id).val() != '') {
            setAvailable(id+'_lbl', id, "Scheduler is set");
            validation--;
        } else {
            setUnavailable(id+'_lbl', id, "Please choose a scheduler");
        }
    }
    function checkTaskId() {
        if ($('#task_id').text().trim() == '') {
            checkAll();
            $('#btn_confirm_task').hide();
            $('#btn_check_task').hide();
        } else {
            $('input').attr('readonly', true);
            $('#btn_confirm_task').show();
            $('#btn_check_task').show();
        }
    }

    function checkTask(task_id) {
        $.ajax({
            url: "{{ url('panel/metro/check-task') }}" + '?task_id=' + task_id,
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                console.log(response);
                alert(response);
            }
        });
    }

    function confirmTask(task_id) {
        if (confirm("Apakah Anda yakin?")) {
            $.ajax({
                url: "{{ url('panel/metro/confirm-task') }}" + '?task_id=' + task_id,
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    alert(response);
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
    function loadScheduler(node, id){
        var div = '<div class="loading-select" id="div_' + id + '"></div>';
        $('#' + id).prev().append(div);
        $.ajax({
            url: "{{ url('panel/select2/scheduler') }}" + '?node='+ node,
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                $('#' + id + ' option').remove();
                var option = "";
                for(var i = 0; i < response.length; i++) {
                    option += "<option value='"+ response[i].name + "'>" + response[i].name + "</option>";
                }
                $('#' + id).append(option);
                checkScheduler(id);
                $('#div_' + id).remove();
            }
        });
    }
    function checkAll() {
        validation = 0;
        checkDescription('service_description', 'service_description_lbl');
        checkDescription('access_description', 'access_description_lbl');
        
        checkNode('node_access_name', 'node_access_lbl', 'node_access');
        checkNode('node_backhaul_1_name', 'node_backhaul_1_lbl', 'node_backhaul_1');
        checkNode('node_backhaul_2_name', 'node_backhaul_2_lbl', 'node_backhaul_2');
        checkInterface('port_access', 'vlan_access', 'port_access_lbl', 'vlan_access_lbl', 'node_access_name');
        checkInterface('port_backhaul_1', 'vlan_backhaul_1', 'port_backhaul_1_lbl', 'vlan_backhaul_1_lbl',
            'node_backhaul_1_name');
        checkInterface('port_backhaul_2', 'vlan_backhaul_2', 'port_backhaul_2_lbl', 'vlan_backhaul_2_lbl',
            'node_backhaul_2_name');
        
        checkVcid('vcid', 'vcid_lbl');
        checkQos('qos_access', 'qos_access_lbl');
        checkQos('qos_backhaul_1', 'qos_backhaul_1_lbl');
        checkQos('qos_backhaul_2', 'qos_backhaul_2_lbl');
    }

    function checkDescription(id, lbl) {
        $('#' + id).addClass('loading');
        if ($('#' + id).val().length < 6) {
            setUnavailable(lbl, id, "Min 6 character");
        } else {
            setAvailable(lbl, id, "OK");
        }
    }

    function checkNode(id, lbl, textbox) {
        var div = '<div class="loading-select" id="div_' + id + '"></div>';
        $('#' + id).prev().prev().append(div);
        $.ajax({
            url: "{{ url('panel/metro/check-node') }}" + '?name=' + $('#' + id).val(),
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                if (response.status == 200) {
                    setAvailable(lbl, id, "Found Node : " + response.ip);
                    $('#' + textbox).val(response.ip);
                    if (id == "node_access_name") {
                        checkVcid('vcid', 'vcid_lbl');
                    }
                } else {
                    setUnavailable(lbl, id, "Node not found");
                    $('#' + textbox).val('');
                }
                $('#div_' + id).remove();
                loadScheduler($('#' + id).val(), id.replace('name', 'scheduler'));
            }
        });
    }
    function setUnavailable(span_id, input_id, text) {
        $('#' + span_id).addClass('not-available');
        $('#' + span_id).removeClass('found');
        $('#' + span_id).text(text);
        $('#' + input_id).addClass('not-available');
        $('#' + input_id).removeClass('found');
        validation++;
        //$('#btn_simpan').hide();
        $('#' + input_id).removeClass('loading');
        console.log(validation);
    }

    function setAvailable(span_id, input_id, text) {
        $('#' + span_id).addClass('found');
        $('#' + span_id).removeClass('not-available');
        $('#' + span_id).text(text);
        $('#' + input_id).addClass('found');
        $('#' + input_id).removeClass('not-available');
        /*if (validation > 0) {
            $('#btn_simpan').hide();
        } else {
            $('#btn_simpan').show();
        }*/
        $('#' + input_id).removeClass('loading');
    }

    function checkVcid(id, lbl) {
        $('#' + id).addClass('loading');
        if ($('#' + id).val().length > 3) {
            if ($('#node_access_lbl').hasClass("found")) {
                $.ajax({
                    url: "{{ url('panel/metro/check-vcid') }}" + '?name=' + $('#node_access_name').val() +
                        '&vcid=' + $(
                            '#' + id).val(),
                    contentType: 'application/json',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status !== 200) {
                            setAvailable(lbl, id, "VCID Available");
                        } else {
                            setUnavailable(lbl, id, "Circuit already used for " + response.description);
                        }
                    }
                });
            } else {
                setUnavailable(lbl, id, "Node access not valid");
            }
        } else {
            setUnavailable(lbl, id, "VCID min 4 character");
        }
    }

    function checkQos(id, lbl) {
        var div = '<div class="loading-select" id="div_' + id + '"></div>';
        $('#' + id).prev().prev().append(div);
        var qosType = "";
        if (id.includes('access')) {
            qosType = "access";
        } else if (id.includes('backhaul_1')) {
            qosType = "backhaul 1";
        } else {
            qosType = "bakhaul 2";
        }
        if ($('#' + id).val() == "") {
            setUnavailable(lbl, id, "Please choose QOS " + qosType);
        } else {
            setAvailable(lbl, id, "QOS " + qosType + " available");
        }
        $('#div_' + id).remove();
    }
    $('input').on('change', function(e) {
        // Capitalize all character ever typed.
        $(this).val($(this).val().toUpperCase());
    })

    function checkInterface(port, vlan, lbl_port, lbl_vlan, node) {
        
        if ($('#' + node).val() == '') {
            setUnavailable(lbl_port, port, "Please entry a node");
            setUnavailable(lbl_vlan, vlan, "Please entry a node");
        } else if ($('#' + port).val() == '') {
            setUnavailable(lbl_port, port, "Please entry a port");
            setUnavailable(lbl_vlan, vlan, "Please entry a port");
        } else if ($('#' + vlan).val() == '') {
            setUnavailable(lbl_port, port, "Please entry a vlan");
            setUnavailable(lbl_vlan, vlan, "Please entry a vlan");
        } else if ($('#' + vlan).val().trim().length < 4) {
            setUnavailable(lbl_port, port, "VLAN must be 4 digits");
            setUnavailable(lbl_vlan, vlan, "VLAN must be 4 digits");
        } else {
            $('#' + port).addClass('loading');
            $('#' + vlan).addClass('loading');
            $.ajax({
                url: "{{ url('panel/metro/check-interface') }}" + '?name=' + $('#' + node).val() +
                    '&port=' + $(
                        '#' + port).val() + '&vlan=' + $('#' + vlan).val(),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.status !== 200) {
                        setAvailable(lbl_port, port, "Port available");
                        if($('#node_backhaul_2_name').val() == $('#node_backhaul_1_name').val()) {
                            if($('#vlan_backhaul_1').val() != $('#vlan_backhaul_2').val()) {
                                setUnavailable('vlan_backhaul_1_lbl', 'vlan_backhaul_1', 'VLAN backhaul 1 must be same as VLAN backhaul 2');
                                setUnavailable('vlan_backhaul_2_lbl', 'vlan_backhaul_2', 'VLAN backhaul 2 must be same as VLAN backhaul 1');
                                setAvailable('vlan_access_lbl', 'vlan_access', 'VLAN available');
                            } else {
                                setAvailable('vlan_backhaul_1_lbl', 'vlan_backhaul_1', 'VLAN backhaul 1 available');
                                setAvailable('vlan_backhaul_2_lbl', 'vlan_backhaul_2', 'VLAN backhaul 2 available');
                                setAvailable(lbl_vlan, vlan, response.message);
                            }
                        }
                    } else {
                        setUnavailable(lbl_port, port, response.message);
                        setUnavailable(lbl_vlan, vlan, response.message);

                    }
                }
            });
        }
    }
    </script>
</div>
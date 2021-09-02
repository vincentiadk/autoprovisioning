<style>
.found {
    color: green;
}

.not-available {
    color: red;
}

.form-control.not-available {
    color: red;
    border: 1px solid red;
}

.form-control.found {
    color: green;
    border: 1px solid green;
}
</style>
<div class="card-body">
    <div class="row">
        <div class="col-sm-12">
            <h4 class="card-title mb-0">
                {{ $data['title'] }}
            </h4>
            Task ID : <input type="text" value="{{ $data['metro']->task_id }}" id="task_id" readonly="true"
                style="width:60%;font-size:14px">

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
                <span id="service_description_lbl"></span>
            </div>
            <div class="form-group">
                <label for="access_description" class="form-control-label">
                    Access Description
                </label>
                <input type="text" name="access_description" id="access_description" class="form-control"
                    value="{{ $data['metro']->access_description }}" required onchange="checkAll()">
                <span id="access_description_lbl"></span>
            </div>
            <div class="form-group">
                <label for="vcid" class="form-control-label">
                    VCID
                </label>
                <input type="number" name="vcid" id="vcid" class="form-control" value="{{ $data['metro']->vcid }}"
                    onkeypress="allowNumbersOnly(event)" onchange="checkAll()" required>
                <span id="vcid_lbl"></span>
            </div>
            <div class="form-group">
                <div class="row" style="    background: #cdf5fb;    padding: 10px;">
                    <div class="col-4">
                        <label for="vlan" class="form-control-label">
                            Node Access
                        </label>
                        <input type="hidden" name="node_access" id="node_access"
                            value="{{ $data['metro']->node_access }}">
                        <input type="tel" name="node_access_name" id="node_access_name" class="form-control"
                            value="{{ $data['metro']->node_access_name }}" onchange="checkAll()">
                        <span id="node_access_lbl"></span>
                    </div>
                    <div class="col-4">
                        <label for="port_access" class="form-control-label">
                            Port Akses
                        </label>
                        <input type="tel" name="port_access" id="port_access" class="form-control"
                            value="{{ $data['metro']->port_access }}" onchange="checkAll()">
                        <span id="port_access_lbl"></span>
                    </div>
                    <div class="col-4">
                        <label for="vlan_access" class="form-control-label">
                            VLAN
                        </label>
                        <input type="tel" name="vlan_access" id="vlan_access" class="form-control"
                            value="{{ $data['metro']->vlan_access }}" onkeypress="allowNumbersOnly(event)"
                            onchange="checkAll()">
                        <span id="vlan_access_lbl"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">

                <div class="row" style="    background: #bff3c8bb;    padding: 10px;">
                    <div class="col-4">
                        <label for="node_backhaul_1" class="form-control-label">
                            Node Backhaul 1
                        </label>
                        <input type="hidden" name="node_backhaul_1" id="node_backhaul_1"
                            value="{{ $data['metro']->node_backhaul_1 }}">
                        <input type="tel" name="node_backhaul_1_name" id="node_backhaul_1_name" class="form-control"
                            value="{{ $data['metro']->node_backhaul_1_name }}" onchange="checkAll()">
                        <span id="node_backhaul_1_lbl"></span>
                    </div>
                    <div class="col-4">
                        <label for="port_backhaul_1" class="form-control-label">
                            Port Backhaul 1
                        </label>
                        <input type="tel" name="port_backhaul_1" id="port_backhaul_1" class="form-control"
                            value="{{ $data['metro']->port_backhaul_1 }}" onchange="checkAll()">
                        <span id="port_backhaul_1_lbl"></span>
                    </div>
                    <div class="col-4">
                        <label for="vlan_backhaul_1" class="form-control-label">
                            VLAN Backhaul 1
                        </label>
                        <input type="tel" name="vlan_backhaul_1" id="vlan_backhaul_1" class="form-control"
                            value="{{ $data['metro']->vlan_backhaul_1 }}" onkeypress="allowNumbersOnly(event)"
                            onchange="checkAll()">
                        <span id="vlan_backhaul_1_lbl"></span>
                    </div>
                </div>
            </div>

            <div class="form-group">

                <div class="row" style="    background: #fde3e3;    padding: 10px;">
                    <div class="col-4">
                        <label for="node_backhaul_2" class="form-control-label">
                            Node Backhaul 2
                        </label>
                        <input type="hidden" name="node_backhaul_2" id="node_backhaul_2"
                            value="{{ $data['metro']->node_backhaul_2 }}">
                        <input type="tel" name="node_backhaul_2_name" id="node_backhaul_2_name" class="form-control"
                            value="{{ $data['metro']->node_backhaul_2_name }}" onchange="checkAll()">
                        <span id="node_backhaul_2_lbl"></span>
                    </div>
                    <div class="col-4">
                        <label for="port_backhaul_2" class="form-control-label">
                            Port Backhaul 2
                        </label>
                        <input type="tel" name="port_backhaul_2" id="port_backhaul_2" class="form-control"
                            value="{{ $data['metro']->port_backhaul_2 }}" onchange="checkAll()">
                        <span id="port_backhaul_2_lbl"></span>
                    </div>

                    <div class="col-4">
                        <label for="vlan_backhaul2" class="form-control-label">
                            VLAN Backhaul 2
                        </label>
                        <input type="tel" name="vlan_backhaul_2" id="vlan_backhaul_2" class="form-control"
                            value="{{ $data['metro']->vlan_backhaul_2 }}" onkeypress="allowNumbersOnly(event)"
                            onchange="checkAll()">
                        <span id="vlan_backhaul_2_lbl"></span>
                    </div>
                </div>
            </div>

            <input type="hidden" id="url" value="{{ url('panel/metro/store') }}">
        </div>
        <div class="col-sm-2">
            <a href="#" class="btn btn-info" onclick="checkTask({{ $data['metro']->task_id }})" style="margin:10px" id="btn_check_task">Check Task</a>
            <a href="#" class="btn btn-success" onclick="confirmTask({{ $data['metro']->task_id }})" style="margin:10px" id="btn_confirm_task">Confirm Task</a>
        </div>
    </div>
    <script>

    checkTaskId();
    var validation, NodeVar = false;
    function checkTaskId() {
        if ($('#task_id').val() == '') {
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


    function checkAll() {
        validation = 0;
        checkDescription('service_description', 'service_description_lbl');
        checkDescription('access_description', 'access_description_lbl');
        checkInterface('port_access', 'vlan_access', 'port_access_lbl', 'vlan_access_lbl', 'node_access_name');
        checkInterface('port_backhaul_1', 'vlan_backhaul_1', 'port_backhaul_1_lbl', 'vlan_backhaul_1_lbl',
            'node_backhaul_1_name');
        checkInterface('port_backhaul_2', 'vlan_backhaul_2', 'port_backhaul_2_lbl', 'vlan_backhaul_2_lbl',
            'node_backhaul_2_name');
        checkNode('node_access_name', 'node_access_lbl', 'node_access');
        checkNode('node_backhaul_2_name', 'node_backhaul_2_lbl', 'node_backhaul_2');
        checkNode('node_backhaul_1_name', 'node_backhaul_1_lbl', 'node_backhaul_1');
        checkVcid('vcid', 'vcid_lbl');
    }

    function checkDescription(id, lbl) {
        if ($('#' + id).val().length < 6) {
            setUnavailable(lbl, id, "Min 6 character");
        } else {
            setAvailable(lbl, id, "OK");
        }
    }

    function checkNode(id, lbl, textbox) {
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
    }

    function setAvailable(span_id, input_id, text) {
        $('#' + span_id).addClass('found');
        $('#' + span_id).removeClass('not-available');
        $('#' + span_id).text(text);
        $('#' + input_id).addClass('found');
        $('#' + input_id).removeClass('not-available');
        if (validation > 0) {
            $('#btn_simpan').hide();
        } else {
            $('#btn_simpan').show();
        }
    }

    function checkVcid(id, lbl) {
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
    $('input').keyup(function(e){
        var input = $(this);
        var key = e.keyCode;
        var val = input.val();

        // Capitalize all character ever typed.
        input.val(val.toUpperCase());
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
        } else {
            $.ajax({
                url: "{{ url('panel/metro/check-interface') }}" + '?name=' + $('#' + node).val() + '&port=' + $(
                    '#' + port).val() + '&vlan=' + $('#' + vlan).val(),
                contentType: 'application/json',
                dataType: 'json',
                success: function(response) {
                    if (response.status !== 200) {
                        setAvailable(lbl_port, port, "Port available");
                        setAvailable(lbl_vlan, vlan, "VLAN available");
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
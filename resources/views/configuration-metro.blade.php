<style>
.found {
    color: #28a745;
    font-size: 80%;
}

.not-available {
    font-size: 80%;
    color: #dc3545;
}

.optional {
    font-size: 80%;
    color: #5969ff;
}

.form-control.not-available {
    color: #dc3545;
    border: 1px solid #dc3545;
}

.form-control.optional {
    color: #5969ff;
    border: 1px solid #5969ff;
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

.status {
    background-color: #17c0dc;
    height: 50px;
    width: 150px;
    position: absolute;
    right: 0px;
    padding: 15px;
    color: white;

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

#plans {
    font-size: 10px;
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
        <div id="div_status" class="status">
            {{ $data['metro']->status }}
        </div>
    </div>
    <!--row-->

    <hr>
    <div class="row mt-4 mb-4">
        <input type="hidden" name="metro_list_id" id="metro_list_id"
            value="{{ $data['metro']->id ? $data['metro']->id : '' }}">
        <input id="node_manufacture" name="node_manufacture" type="hidden">
        <div class="col-sm-10">
            <!--<div class="form-group">
                <label for="service_description" class="form-control-label">
                    Service Description
                </label>
                <input type="text" name="service_description" id="service_description" class="form-control"
                    value="{{ $data['metro']->service_description }}" required>
                <span id="service_description_lbl" class="not-available"></span>
            </div>
            <div class="form-group">
                <label for="access_description" class="form-control-label">
                    Access Description
                </label>
                <input type="text" name="access_description" id="access_description" class="form-control"
                    value="{{ $data['metro']->access_description }}" required>
                <span id="access_description_lbl" class="not-available"></span>
            </div>-->
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="vcid" class="form-control-label" id="lblvcid">
                        VCID
                    </label>
                    <input type="tel" name="vcid" id="vcid" class="form-control" value="{{ $data['metro']->vcid }}"
                        onkeypress="allowNumbersOnly(event)" required>
                    <span id="vcid_access_lbl" class="not-available"></span><br />
                    <span id="vcid_backhaul_1_lbl" class="not-available"></span><br />
                    <span id="vcid_backhaul_2_lbl" class="not-available"></span>
                </div>
                <div class="col-md-6" id="div_vsiname">
                    <label for="vsiname" class="form-control-label">
                        VSI Name
                    </label>
                    <input type="text" name="vsiname" id="vsiname" class="form-control"
                        value="{{ $data['metro']->vsiname }}" required>
                    <span id="vsiname_access_lbl"></span><br />
                    <span id="vsiname_backhaul_1_lbl"></span><br />
                    <span id="vsiname_backhaul_2_lbl"></span>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4" style="background: #cdf5fb;    padding: 10px;" id="vcid_node_access">
                    <div class="form-group">
                        <label for="service_description" class="form-control-label">
                            Description Access
                        </label>
                        <input type="text" name="description_access" id="description_access" class="form-control"
                            value="{{ $data['metro']->description_access }}" required>
                        <span id="description_access_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">

                        <label for="vlan" class="form-control-label">
                            Node Access
                        </label>
                        <input type="hidden" name="node_access" id="node_access"
                            value="{{ $data['metro']->node_access }}">
                        <select class="select2 form-control node" id="node_access_name" name="node_access_name">
                            @if($data['metro']->node_access != '')
                            <option value="{{$data['metro']->node_access_name}}" selected>
                                {{$data['metro']->node_access_name}}
                            </option>
                            @endif
                        </select>
                        <span id="node_access_lbl" class="not-available"></span>
                        <input id="node_access_manufacture" name="node_access_manufacture" type="hidden">
                    </div>
                    <div class="form-group">
                        <label for="port_access" class="form-control-label port" id="port_access_lbl_top">
                            Port access
                        </label>
                        <input type="hidden" value="{{ $data['metro']->port_access }}" id="hidden_port_access"
                            name="port_access">
                        <input type="tel" id="input_port_access" class="form-control"
                            value="{{ $data['metro']->port_access }}" onchange="checkAccess()">

                        <select class="select2 form-control" id="select_port_access" onchange="checkAccess()">
                            @if($data['metro']->port_access != '')
                            <option value="{{$data['metro']->port_access}}" selected>
                                {{$data['metro']->port_access}}
                            </option>
                            @endif
                        </select>
                        <span id="port_access_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="vlan_access" class="form-control-label">
                            VLAN access
                        </label>
                        <input type="tel" name="vlan_access" id="vlan_access" class="form-control"
                            value="{{ $data['metro']->vlan_access }}" onkeypress="allowNumbersOnly(event)" required
                            onchange="checkAccess()">
                        <span id="vlan_access_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label">
                                Install QOS?
                            </label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control qos_install" id="qos_access_install" name="qos_access_install">
                                @if($data['metro']->qos_access != '')
                                <option value="0">NO
                                </option>
                                <option value="1" selected>YES
                                </option>
                                @else
                                <option value="0" selected>NO
                                </option>
                                <option value="1">YES
                                </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div id="div_qos_access_install" @if($data['metro']->qos_access=='')style="display:none" @endif>
                        <div class="form-group">
                            <label for="qos_access" class="form-control-label">
                                QOS access
                            </label>
                            <select class="form-control qos" id="qos_access" name="qos_access">
                                @if($data['metro']->qos_access != '')
                                <option value="{{$data['metro']->qos_access}}" selected>{{$data['metro']->qos_access}}
                                </option>
                                @endif
                            </select>
                            <span id="qos_access_lbl"></span>
                        </div>
                        <div class="form-group">
                            <label for="node_access_scheduler" class="form-control-label">
                                Scheduler access
                            </label>
                            <select class="select2 form-control" id="node_access_scheduler" name="scheduler_access"
                                onchange="checkScheduler(id)">
                                @if($data['metro']->scheduler_access != '')
                                <option value="{{$data['metro']->scheduler_access}}" selected>
                                    {{$data['metro']->scheduler_access}}
                                </option>
                                @endif
                            </select>
                            <span id="node_access_scheduler_lbl"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="    background: #bff3c8bb;    padding: 10px;" id="vcid_node_backhaul_1">
                    <div class="form-group">
                        <label for="service_description" class="form-control-label">
                            Description Backhaul 1
                        </label>
                        <input type="text" name="description_backhaul_1" id="description_backhaul_1"
                            class="form-control" value="{{ $data['metro']->description_backhaul_1 }}" required>
                        <span id="description_backhaul_1_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="node_backhaul_1" class="form-control-label">
                            Node Backhaul 1
                        </label>
                        <input type="hidden" name="node_backhaul_1" id="node_backhaul_1"
                            value="{{ $data['metro']->node_backhaul_1 }}">
                        <select class="select2 form-control col-8 node" id="node_backhaul_1_name"
                            name="node_backhaul_1_name">
                            @if($data['metro']->node_backhaul_1_name != '')
                            <option value="{{$data['metro']->node_backhaul_1_name}}" selected>
                                {{$data['metro']->node_backhaul_1_name}}</option>
                            @endif
                        </select>
                        <span id="node_backhaul_1_lbl" class="not-available"></span>
                        <input id="node_backhaul_1_manufacture" name="node_backhaul_1_manufacture" type="hidden">
                    </div>
                    <div class="form-group">
                        <label for="port_backhaul_1" class="form-control-label" id="port_backhaul_1_lbl_top">
                            Port backhaul 1
                        </label>
                        <input type="hidden" value="{{ $data['metro']->port_backhaul_1 }}" id="hidden_port_backhaul_1"
                            name="port_backhaul_1">
                        <input type="tel" id="input_port_backhaul_1" class="form-control port"
                            value="{{ $data['metro']->port_backhaul_1 }}">
                        <select class="select2 form-control select-port" id="select_port_backhaul_1">
                            @if($data['metro']->port_backhaul_1 != '')
                            <option value="{{$data['metro']->port_backhaul_1}}" selected>
                                {{$data['metro']->port_backhaul_1}}
                            </option>
                            @endif
                        </select>
                        <span id="port_backhaul_1_lbl"></span>
                    </div>
                    <div class="form-group">
                        <label for="vlan_backhaul_1" class="form-control-label">
                            VLAN backhaul 1
                        </label>
                        <input type="tel" name="vlan_backhaul_1" id="vlan_backhaul_1" class="form-control vlan"
                            value="{{ $data['metro']->vlan_backhaul_1 }}" onkeypress="allowNumbersOnly(event)" required>
                        <span id="vlan_backhaul_1_lbl"></span>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label">
                                Install QOS?
                            </label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control qos_install" id="qos_backhaul_1_install"
                                name="qos_backhaul_1_install">
                                @if($data['metro']->qos_backhaul_1 != '')
                                <option value="0">NO
                                </option>
                                <option value="1" selected>YES
                                </option>
                                @else
                                <option value="0" selected>NO
                                </option>
                                <option value="1">YES
                                </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div id="div_qos_backhaul_1_install" @if($data['metro']->qos_backhaul_1=='')style="display:none"
                        @endif>
                        <div class="form-group">
                            <label for="qos_backhaul_1" class="form-control-label">
                                QOS Backhaul 1
                            </label>
                            <select class="select2 form-control qos" id="qos_backhaul_1" name="qos_backhaul_1">
                                @if($data['metro']->qos_backhaul_1 != '')
                                <option value="{{$data['metro']->qos_backhaul_1}}" selected>
                                    {{$data['metro']->qos_backhaul_1}}</option>
                                @endif
                            </select>
                            <span id="qos_backhaul_1_lbl"></span>
                        </div>
                        <div class="form-group">
                            <label for="node_backhaul_1_scheduler" class="form-control-label">
                                Scheduler Backhaul 1
                            </label>
                            <select class="select2 form-control" id="node_backhaul_1_scheduler"
                                name="scheduler_backhaul_1" onchange="checkScheduler(id)">
                                @if($data['metro']->scheduler_backhaul_1 != '')
                                <option value="{{$data['metro']->scheduler_backhaul_1}}" selected>
                                    {{$data['metro']->scheduler_backhaul_1}}
                                </option>
                                @endif
                            </select>
                            <span id="node_backhaul_1_scheduler_lbl"></span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" style="background: #e3ebfd;    padding: 10px;" id="vcid_node_backhaul_2">
                    <div class="form-group">
                        <label for="service_description" class="form-control-label">
                            Description Backhaul 2
                        </label>
                        <input type="text" name="description_backhaul_2" id="description_backhaul_2"
                            class="form-control" value="{{ $data['metro']->description_backhaul_2 }}" required>
                        <span id="description_backhaul_2_lbl" class="not-available"></span>
                    </div>
                    <div class="form-group">
                        <label for="node_backhaul_2" class="form-control-label">
                            Node Backhaul 2
                        </label>
                        <input type="hidden" name="node_backhaul_2" id="node_backhaul_2"
                            value="{{ $data['metro']->node_backhaul_2 }}">
                        <select class="select2 form-control node" id="node_backhaul_2_name" name="node_backhaul_2_name">
                            @if($data['metro']->node_backhaul_2_name != '')
                            <option value="{{$data['metro']->node_backhaul_2_name}}" selected>
                                {{ $data['metro']->node_backhaul_2_name}}</option>
                            @endif
                        </select>
                        <span id="node_backhaul_2_lbl" class="not-available"></span>
                        <input id="node_backhaul_2_manufacture" name="node_backhaul_2_manufacture" type="hidden">
                    </div>
                    <div class="form-group ">
                        <label for="port_backhaul_2" class="form-control-label" id="port_backhaul_2_lbl_top">
                            Port backhaul 2
                        </label>
                        <input type="hidden" name="port_backhaul_2" id="hidden_port_backhaul_2"
                            value="{{ $data['metro']->port_backhaul_2 }}">
                        <input type="tel" id="input_port_backhaul_2" class="form-control port"
                            value="{{ $data['metro']->port_backhaul_2 }}">
                        <select class="select2 form-control select-port" id="select_port_backhaul_2">
                            @if($data['metro']->port_backhaul_2 != '')
                            <option value="{{$data['metro']->port_backhaul_2}}" selected>
                                {{$data['metro']->port_backhaul_2}}
                            </option>
                            @endif
                        </select>
                        <span id="port_backhaul_2_lbl"></span>
                    </div>
                    <div class="form-group">
                        <label for="vlan_backhaul_2" class="form-control-label">
                            VLAN backhaul 2
                        </label>
                        <input type="tel" name="vlan_backhaul_2" id="vlan_backhaul_2" class="form-control vlan"
                            value="{{ $data['metro']->vlan_backhaul_2 }}" onkeypress="allowNumbersOnly(event)" required>
                        <span id="vlan_backhaul_2_lbl"></span>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="form-control-label">
                                Install QOS?
                            </label>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control qos_install" id="qos_backhaul_2_install"
                                name="qos_backhaul_2_install">
                                @if($data['metro']->qos_backhaul_2 != '')
                                <option value="0">NO
                                </option>
                                <option value="1" selected>YES
                                </option>
                                @else
                                <option value="0" selected>NO
                                </option>
                                <option value="1">YES
                                </option>
                                @endif
                            </select>
                        </div>
                    </div>
                    <div id="div_qos_backhaul_2_install" @if($data['metro']->
                        qos_backhaul_2=='')style="display:none" @endif>
                        <div class="form-group">
                            <label for="qos_backhaul_2" class="form-control-label">
                                QOS Backhaul 2
                            </label>
                            <select class="select2 form-control qos" id="qos_backhaul_2" name="qos_backhaul_2">
                                @if($data['metro']->qos_backhaul_2 != '')
                                <option value="{{$data['metro']->qos_backhaul_2}}" selected>
                                    {{$data['metro']->qos_backhaul_2}}</option>
                                @endif
                            </select>
                            <span id="qos_backhaul_2_lbl"></span>
                        </div>
                        <div class="form-group">
                            <label for="node_backhaul_2_scheduler" class="form-control-label">
                                Scheduler Backhaul 2
                            </label>
                            <select class="select2 form-control" id="node_backhaul_2_scheduler"
                                name="scheduler_backhaul_2" onchange="checkScheduler(id)">
                                @if($data['metro']->scheduler_backhaul_2 != '')
                                <option value="{{$data['metro']->scheduler_backhaul_2}}" selected>
                                    {{$data['metro']->scheduler_backhaul_2}}
                                </option>
                                @endif
                            </select>
                            <span id="node_backhaul_2_scheduler_lbl"></span>
                        </div>
                    </div>
                </div>
            </div>
            <input type="hidden" id="url" value="{{ url('panel/metro/store') }}">
        </div>
        <div class="col-sm-2">
            <a href="#" class="btn btn-info" onclick="checkTask('{{ $data['metro']->task_id }}')" style="margin:10px"
                id="btn_check_task">Check Task</a>
            @if($data['metro']->task_id != "")
            <a href="#" class="btn btn-success" onclick="checkTaskId('{{ $data['metro']->task_id }}')"
                style="margin:10px" id="btn_check_status">Check Status</a>
            @endif
        </div>
    </div>
    <div class="modal fade" id="modal-plans" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="exampleModalLongTitle" style="color:#000">TASK PLAN</h3>
                </div>
                <div class="modal-body">
                    <div id="plans"></div>
                </div>
                <div class="modal-footer">
                    <a href="#" class="btn btn-success" onclick="confirmTask('{{ $data['metro']->task_id }}')"
                        style="margin:10px" id="btn_confirm_task">Confirm Task</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal" aria-label="Close">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </div>
    <script>
    checkTaskId($('#task_id').html());
    checkAll();
    select2AutoSuggest('#node_access_name', 'node');
    select2AutoSuggest('#node_backhaul_1_name', 'node');
    select2AutoSuggest('#node_backhaul_2_name', 'node');
    //select2Node('#qos_access', '#node_access_name', 'qos');
    //select2Node('#qos_backhaul_1', '#node_backhaul_1_name', 'qos');
    //select2Node('#qos_backhaul_2', '#node_backhaul_2_name', 'qos');
    $('.qos_install').on('change', function() {
        var name = $(this).attr('id');
        if ($(this).val() == 1) {
            $('#div_' + name).show();
        } else {
            $('#div_' + name).hide();
        }
    })
    $('#description_access').on('change', function() {
        checkDescription('description_access', 'description_access_lbl');
    })
    $('#description_backhaul_1').on('change', function() {
        checkDescription('description_backhaul_1', 'description_backhaul_1_lbl');
    })
    $('#description_backhaul_2').on('change', function() {
        checkDescription('description_backhaul_2', 'description_backhaul_2_lbl');
    })
    $('#vcid').on('change', function() {
        checkAccess();
        if ($('#node_backhaul_1_name').val() != "") {
            checkVcid('vcid', 'vcid_backhaul_1_lbl', 'vcid');
        }
        if ($('#node_backhaul_2_name').val() != "") {
            checkVcid('vcid', 'vcid_backhaul_2_lbl', 'vcid');
        }
    })
    $('#vsiname').on('change', function() {
        if ($('node_access').val() != "") {
            checkVcid('vcid', 'vcid_access_lbl', 'vsiname');
        }
        if ($('node_backhaul_1').val() != "") {
            checkVcid('vcid', 'vcid_backhaul_1_lbl', 'vsiname');
        }
        if ($('node_backhaul_2').val() != "") {
            checkVcid('vcid', 'vcid_backhaul_2_lbl', 'vsiname');
        }
    })
    $('.node').on('change', function() {
        var node_id = $(this).attr('id');
        var lbl = node_id.replace('name', 'lbl');
        var txt = node_id.replace('_name', '');
        checkNode(node_id, lbl, txt);

        var name = node_id.replace('node_', '').replace('_name', '');
        var port = "port_" + name;
        var vlan = "vlan_" + name;
        var portlbl = port + "_lbl";
        var vlanlbl = vlan + "_lbl";
        if (name != "access") {
            checkVcid('vcid', 'vcid_' + name + '_lbl', null);
        }
        checkQosBefore("qos_" + name, "qos_" + name + "_lbl", node_id);
    })

    $('.vlan').on('change', function() {
        var name = $(this).attr('id').replace('vlan_', '');
        console.log(name);
        checkInterface(name);
    })
    $('.qos').on('change', function() {
        var name = $(this).attr('id');
        var node_id = "node_" + name.replace("qos_", "") + "_name";
        checkQosBefore(name, name + "_lbl", node_id);
    })

    $('.port').on('change', function() {
        var name = $(this).attr('id').replace('port_', '').replace('input_', '');
        $('input[name=port_' + name + ']').val($(this).val());
        checkPort(name);
    })

    $('.select-port').on('change', function() {
        var name = $(this).attr('id').replace('port_', '').replace('select_', '');
        $('input[name=port_' + name + ']').val($(this).val());
        checkInterface(name);
    })
    </script>
</div>
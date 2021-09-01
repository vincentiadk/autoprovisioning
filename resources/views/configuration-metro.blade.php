<div class="card-body">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{ $data['title'] }} 
            </h4>
            Task ID : <input type="text" value="{{ $data['metro']->task_id }}" id="task_id" readonly="true" style="width:60%;font-size:14px">
            
        </div>
        <!--col-->
        <div class="col-sm-7">
            <a href="#" class="btn btn-info" onclick="checkTask({{ $data['metro']->task_id }})">Check Task</a>
            <a href="#" class="btn btn-success" onclick="confirmTask({{ $data['metro']->task_id }})">Confirm Task</a>
        </div>
        <!--col-->
    </div>
    <!--row-->

    <hr>
    <div class="row mt-4 mb-4">
    <input type="hidden" name="metro_list_id" id="metro_list_id"
                value="{{ $data['metro']->id ? $data['metro']->id : '' }}">
        <div class="col-sm-12">
            <div class="form-group">
                <label for="service_description" class="form-control-label">
                    Service Description
                </label>
                <input type="text" name="service_description" id="service_description" class="form-control" value="{{ $data['metro']->service_description }}">
            </div>
            <div class="form-group">
                <label for="access_description" class="form-control-label">
                    Access Description
                </label>
                <input type="text" name="access_description" id="access_description" class="form-control" value="{{ $data['metro']->access_description }}">
            </div>
            <div class="form-group">
                <label for="vcid" class="form-control-label">
                    VCID
                </label>
                <input type="text" name="vcid" id="vcid" class="form-control" value="{{ $data['metro']->vcid }}">
            </div>
            <div class="form-group">
                <div class="row">
                <div class="col-4">
                        <label for="vlan" class="form-control-label">
                            Node Access
                        </label>
                        <input type="tel" name="node_access" id="node_access" class="form-control" value="{{ $data['metro']->node_access }}"
                            onkeypress="allowNumbersOnly(event)">
                    </div>
                    <div class="col-4">
                        <label for="port_access" class="form-control-label">
                            Port Akses
                        </label>
                        <input type="tel" name="port_access" id="port_access" class="form-control" value="{{ $data['metro']->port_access }}">
                    </div>
                    <div class="col-4">
                        <label for="vlan_access" class="form-control-label">
                            VLAN
                        </label>
                        <input type="tel" name="vlan_access" id="vlan_access" class="form-control" value="{{ $data['metro']->vlan_access }}"
                            onkeypress="allowNumbersOnly(event)">
                    </div>
                </div>
            </div>

            <div class="form-group">

                <div class="row">
                    <div class="col-6">
                        <label for="node_backhaul_1" class="form-control-label">
                            Node Backhaul 1
                        </label>
                        <input type="text" name="node_backhaul_1" id="node_backhaul_1" class="form-control" value="{{ $data['metro']->node_backhaul_1 }}">
                    </div>
                    <div class="col-6">
                        <label for="node_backhaul_2" class="form-control-label">
                            Node Backhaul 2
                        </label>
                        <input type="text" name="node_backhaul_2" id="node_backhaul_2" class="form-control" value="{{ $data['metro']->node_backhaul_2 }}">
                    </div>
                </div>
            </div>

            <div class="form-group">

                <div class="row">
                    <div class="col-6">
                        <label for="port_backhaul_1" class="form-control-label">
                            Port Backhaul 1
                        </label>
                        <input type="tel" name="port_backhaul_1" id="port_backhaul_1" class="form-control" value="{{ $data['metro']->port_backhaul_1 }}">
                    </div>
                    <div class="col-6">
                        <label for="port_backhaul_2" class="form-control-label">
                            Port Backhaul 2
                        </label>
                        <input type="tel" name="port_backhaul_2" id="port_backhaul_2" class="form-control" value="{{ $data['metro']->port_backhaul_2 }}">
                    </div>
                </div>
            </div>
            <div class="form-group">

                <div class="row">
                    <div class="col-6">
                        <label for="vlan_backhaul_1" class="form-control-label">
                            VLAN Backhaul 1
                        </label>
                        <input type="tel" name="vlan_backhaul_1" id="vlan_backhaul_1" class="form-control" value="{{ $data['metro']->vlan_backhaul_1 }}">
                    </div>
                    <div class="col-6">
                        <label for="vlan_backhaul2" class="form-control-label">
                            VLAN Backhaul 2
                        </label>
                        <input type="tel" name="vlan_backhaul_2" id="vlan_backhaul_2" class="form-control" value="{{ $data['metro']->vlan_backhaul_2 }}">
                    </div>
                </div>
            </div>

            <input type="hidden" id="url" value="{{ url('panel/metro/store') }}">
        </div>
    </div>
    <script>
        function checkTask(task_id){
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
        function confirmTask(task_id){
            if(confirm("Apakah Anda yakin?")) {
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
    </script>
</div>
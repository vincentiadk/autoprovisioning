<div id="formCOnfig" class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Create VLAN
                </h4>
            </div>
            <!--col-->
            <div class="col-sm-7">

                <div class="btn-toolbar float-right" role="toolbar"
                    aria-label="@lang('labels.general.toolbar_btn_groups')">
                    <a href="{{ url('panel/configuration/form?config_id=' . $data['config_id'] . '&aLink=aGpon') }}" class="btn btn-warning ml-1 text-black"
                        data-toggle="tooltip" title="Back"><i class="ti-arrow-left"></i></a>
                </div>
                <!--btn-toolbar-->

            </div>
            <!--col-->
        </div>
        <!--row-->

        <hr>
            <div class="row mt-4 mb-4">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="vlan_id" class="form-control-label">
                                    VLAN ID
                                </label>
                                <input type="tel" name="vlan_id" id="vlan_id" class="form-control" onkeypress="allowNumbersOnly(event)"/>
                            </div>
                            <div class="col-6">
                                <label for="pir" class="form-control-label">
                                    VLAN Description
                                </label>
                                <input type="text" name="desc" id="desc" class="form-control"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="port" class="form-control-label">
                                    Port
                                </label>
                                <input type="tel" name="port" id="port" class="form-control" onkeypress="allowNumbersOnly(event)"/>
                            </div>
                        </div>
                    </div>
                    <!--form-group-->

                    <div class="form-group pull-right">
                        <button type="button" class="btn btn-md btn-info" id="generateConfigBtn">Generate Config</button>
                    </div>
                </div>
                <!--col-->
                <div class="col-sm-12 col-md-6">
                    <div class="generate-config" >
                        <div class="bg-gray-800 text-white p-3 rounded font-mono">
                            <div class="flex terminal-title">
                                <div class="flex terminal-button">
                                    <div class="rounded-full w-4 h-4 bg-red mr-2"></div>
                                    <div class="rounded-full w-4 h-4 bg-green mr-2"></div>
                                    <div class="rounded-full w-4 h-4 bg-yellow mr-2"></div>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm" onclick="copyText('generate-config')">Copy</button>
                            </div>
                            <div class="generate-config" role="alert" id="generate-config" contenteditable="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!--card-body-->
    <script>

    function allowNumbersOnly(e) {
        var code = (e.which) ? e.which : e.keyCode;
        if (code > 31 && (code < 46 || code > 57)) {
            e.preventDefault();
        }
    }

    function copyText(divID){
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
            alert("Config has been copied")
        }
    }

    function printGemMap(gponPort, ontNum, vlan, id){
        let gemMap = ''
        if(gponPort && ontNum && vlan){
            const vlans = vlan.split(',');
            vlans.forEach((val, index) => {
                gemMap += `service-port vlan ${val} gpon ${gponPort} ont ${ontNum} gemport ${id} multi-service <br>
                        user-vlan ${val} rx-cttr 96 tx-cttr 96 <br>`;
            });
        }
        return gemMap;
    }

    document.getElementById('generateConfigBtn').addEventListener('click', function() {
        const vlan_id = document.getElementById('vlan_id').value || `[vlan-id]`;
        const desc = document.getElementById('desc').value || `[vlan-description]`;
        const port = document.getElementById('port').value || `[port]`;


        const text = `vlan ${vlan_id} smart
        vlan ${vlan_id} description ${desc}
        port vlan ${vlan_id} ${port}`;

        const genCon = document.getElementById('generate-config');
        genCon.style.display = 'block';
        genCon.innerText = text;
        genCon.focus();
    })
</script>
</div>
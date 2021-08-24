<div class="card" id="formConfig">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Create Register ONT
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
                                <label for="port_fs" class="form-control-label">
                                    Port F/S
                                </label>
                                <input type="tel" name="port_fs" id="port_fs" class="form-control" onkeypress="allowNumbersOnly(event)"/>
                            </div>
                            <div class="col-6">
                                <label for="port_id" class="form-control-label">
                                    Port ID
                                </label>
                                <input type="tel" name="port_id" id="port_id" class="form-control" onkeypress="allowNumbersOnly(event)"/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="serial_number" class="form-control-label">
                                    Serial Number
                                </label>
                                <input type="text" name="serial_number" id="serial_number" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label for="lineprofile_name" class="form-control-label">
                                    Lineprofile Name
                                </label>
                                <input type="text" name="lineprofile_name" id="lineprofile_name" class="form-control" />
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-6">
                                <label for="srvprofile_name" class="form-control-label">
                                    SRV Profile Name
                                </label>
                                <input type="text" name="srvprofile_name" id="srvprofile_name" class="form-control" />
                            </div>
                            <div class="col-6">
                                <label for="desc" class="form-control-label">
                                    ONT Description
                                </label>
                                <input type="text" name="desc" id="desc" class="form-control" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-4">
                                <label for="ont_id" class="form-control-label">
                                    ONT ID
                                </label>
                                <input type="tel" name="ont_id" id="ont_id" class="form-control" onkeypress="allowNumbersOnly(event)"/>
                            </div>
                            <div class="col-4">
                                <label for="port_eth_ont" class="form-control-label">
                                    Port Eth ONT
                                </label>
                                <input type="tel" name="port_eth_ont" id="port_eth_ont" class="form-control" onkeypress="allowNumbersOnly(event)"/>
                            </div>
                            <div class="col-4">
                                <label for="vlan_id" class="form-control-label">
                                    VLAN ID
                                </label>
                                <input type="tel" name="vlan_id" id="vlan_id" class="form-control" onkeypress="allowNumbersOnly(event)"/>
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

    document.getElementById('generateConfigBtn').addEventListener('click', function() {
        const vlan_id = document.getElementById('vlan_id').value || `<port-F/S>`;
        const port_fs = document.getElementById('port_fs').value || `<vlan-id>`;
        const desc = document.getElementById('desc').value || `<ONT-description>`;
        const port_id = document.getElementById('port_id').value || `<port-id>`;
        const serial_number = document.getElementById('serial_number').value || `<serial-number>`;
        const srvprofile_name = document.getElementById('srvprofile_name').value || `<srvprofile-name>`;
        const ont_id = document.getElementById('ont_id').value || `<ont-id>`;
        const port_eth_ont = document.getElementById('port_eth_ont').value || `<port-eth-ont>`;
        const lineprofile_name = document.getElementById('lineprofile_name').value || `<lineprofile-name>`;


        const text = `config
        interface gpon ${port_fs}
        ont add ${port_id} sn-auth ${serial_number} omci ont-lineprofile-name ${lineprofile_name} ont-srvprofile-name ${srvprofile_name} desc ${desc}
        ont port native-vlan ${port_id} ${ont_id} eth ${port_eth_ont} vlan ${vlan_id} priority 4`;

        const genCon = document.getElementById('generate-config');
        genCon.style.display = 'block';
        genCon.innerText = text;
        genCon.focus();
    })
</script>
</div>

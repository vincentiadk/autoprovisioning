<div class="card-body">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                {{ $data['title'] }}
            </h4>
        </div>
        <!--col-->
        <div class="col-sm-7">
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
    <!--row-->
</div>
<div id="formConfig" class="card-body">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                Traffic Table
            </h4>
        </div>
        <!--col-->
        <div class="col-sm-7">

            <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
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
                        <label for="cir" class="form-control-label">
                            CIR
                        </label>
                        <input type="tel" name="cir" id="cir" class="form-control"
                            onkeypress="allowNumbersOnly(event)" />
                    </div>
                    <div class="col-6">
                        <label for="pir" class="form-control-label">
                            PIR
                        </label>
                        <input type="tel" name="pir" id="pir" class="form-control"
                            onkeypress="allowNumbersOnly(event)" />
                    </div>
                </div>
            </div>

            <div class="form-group">
                <div class="row">
                    <div class="col-6">
                        <label for="priority" class="form-control-label">
                            Priority
                        </label>
                        <input type="tel" name="priority" id="priority" class="form-control"
                            onkeypress="allowNumbersOnly(event)" />
                    </div>
                    <div class="col-6">
                        <label for="priority_policy" class="form-control-label">
                            Priority Policy
                        </label>
                        <input type="text" name="priority_policy" id="priority_policy" class="form-control" />
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
            <div class="generate-config">
                <div class="bg-gray-800 text-white p-3 rounded font-mono">
                    <div class="flex terminal-title">
                        <div class="flex terminal-button">
                            <div class="rounded-full w-4 h-4 bg-red mr-2"></div>
                            <div class="rounded-full w-4 h-4 bg-green mr-2"></div>
                            <div class="rounded-full w-4 h-4 bg-yellow mr-2"></div>
                        </div>
                        <button type="button" class="btn btn-primary btn-sm"
                            onclick="copyText('generate-config')">Copy</button>
                    </div>
                    <div class="generate-config" role="alert" id="generate-config" contenteditable="true">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 48 || code > 57)) {
        e.preventDefault();
    }
}

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
        alert("Config has been copied")
    }
}

function printGemMap(gponPort, ontNum, vlan, id) {
    let gemMap = ''
    if (gponPort && ontNum && vlan) {
        const vlans = vlan.split(',');
        vlans.forEach((val, index) => {
            gemMap += `service-port vlan ${val} gpon ${gponPort} ont ${ontNum} gemport ${id} multi-service <br>
                    user-vlan ${val} rx-cttr 96 tx-cttr 96 <br>`;
        });
    }
    return gemMap;
}

document.getElementById('generateConfigBtn').addEventListener('click', function() {
    const cir = document.getElementById('cir').value || `[cir]`;
    const pir = document.getElementById('pir').value || `[pir]`;
    const priority = document.getElementById('priority').value || `[priority]`;
    const priority_policy = document.getElementById('priority_policy').value || `[tag-in-package]`;


    const text =
        `traffic table ip cir ${cir} pir ${pir} priority ${priority} priority-policy ${priority_policy}`;

    const genCon = document.getElementById('generate-config');
    genCon.style.display = 'block';
    genCon.innerHTML = text;
    genCon.focus();
})
</script>
</div>
<div class="card" id="formConfig">
    <input type="hidden" id="url" value="{{ url('panel/ont/store') }}">
    <input type="hidden" name="olt_site_id" value="{{ $data['oltSite']->id }}">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    ONT Line Profile
                </h4>
            </div>
            <!--col-->
            <div class="col-sm-7">

                <div class="btn-toolbar float-right" role="toolbar"
                    aria-label="@lang('labels.general.toolbar_btn_groups')">
                    <a href="{{ url('panel/configuration/form?config_id=' . $data['config_id'] . '&aLink=aGpon') }}"
                        class="btn btn-warning ml-1 text-black" data-toggle="tooltip" title="Back"><i
                            class="ti-arrow-left"></i></a>
                </div>
                <!--btn-toolbar-->

            </div>
            <!--col-->
        </div>
        <!--row-->

        <hr>
        <div class="row mt-4 mb-4">
            <div class="col-sm-12 col-md-6">
                <div class="form-group row">
                    <label for="profile_id" class="col-md-4 form-control-label">
                        Profile ID
                    </label>
                    <div class="col-md-8">

                        <input type="text" name="profile_id" id="profile_id" class="form-control" list="dbaprops"
                            required value="{{old('profile_id')}}" />
                        <datalist id="dbaprops">
                            @foreach ($data['dba'] as $db)
                            <option>{{$db}}</option>
                            @endforeach
                        </datalist>
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->

                <div class="form-group row">
                    <label for="tcont_1" class="col-md-4 form-control-label">
                        Tcont 1
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="tcont_1" id="tcont_1" class="form-control" value="{{old('tcont_1')}}"
                            placeholder="example: dba-profile-id 99">
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->


                <div class="form-group row">
                    <label for="tcont_1" class="col-md-4 form-control-label">
                        Tcont 2
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="tcont_2" id="tcont_2" class="form-control" value="{{old('tcont_2')}}">
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->


                <div class="form-group row">
                    <label for="tcont_3" class="col-md-4 form-control-label">
                        Tcont 3
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="tcont_3" id="tcont_3" class="form-control" value="{{old('tcont_3')}}">
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->


                <div class="form-group row">
                    <label for="tcont_4" class="col-md-4 form-control-label">
                        Tcont 4
                    </label>
                    <div class="col-md-8">
                        <input type="text" name="tcont_4" id="tcont_4" class="form-control" value="{{old('tcont_4')}}">
                    </div>
                    <!--col-->
                </div>
                <!--form-group-->

                <div class="form-group pull-right">
                    <button type="input" class="btn btn-md btn-success ml-2">Create</button>
                    <button type="button" class="btn btn-md btn-info" id="generateConfigBtn"
                        data-olt="{{ $data['oltSite']->id }}">Generate
                        Config</button>
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
        <!--row-->
        <div class="row">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>Profile ID</td>
                            <td>Profile Name</td>
                            <td>VLAN T1</td>
                            <td>Dba Profile T1</td>

                            <td>VLAN T2</td>
                            <td>Dba Profile T2</td>

                            <td>VLAN T3</td>
                            <td>Dba Profile T3</td>

                            <td>VLAN T4</td>
                            <td>Dba Profile T4</td>

                            <td>Created By</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['ont'] as $d)
                        <tr>
                            <td>{{$d->profile_id}}</td>
                            <td>{{$d->profile_name}}</td>

                            <td>{{$d->vlan}}</td>
                            <td>{{$d->tcont_1}}</td>

                            <td>{{$d->vlan_2g}}</td>
                            <td>{{$d->tcont_2}}</td>

                            <td>{{$d->vlan_3g}}</td>
                            <td>{{$d->tcont_3}}</td>

                            <td>{{$d->vlan_4g}}</td>
                            <td>{{$d->tcont_4}}</td>

                            <td>{{$d->name}}</td>
                            <td>
                                <form action="{{ url('panel/ont/delete/' . $d->id) }}" method="post"
                                    id="formDelete">
                                    @csrf
                                    @method('delete')
                                    <button type="button" class="btn btn-md btn-info" onclick="generateConfig(this)"
                                        data-props="{{json_encode($d)}}" data-toggle="tooltip" data-placement="top"
                                        title="Generate Config"><i class="fa fa-sticky-note"></i></button>

                                    <a href='javascript:void(0)' data-toggle="tooltip" data-placement="top"
                                        title="Delete data" class="btn btn-danger"
                                        onclick="confirm('Are you sure you want to delete this data?') ? this.parentElement.submit() : ''">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--card-body-->
    <script>
    function generateConfig(e){
        const dataProps  = e.getAttribute('data-props');
        const data = JSON.parse(dataProps);
        const dataProps2  = document.getElementById('generateConfigBtn').getAttribute('data-olt');
        const dataOlt = JSON.parse(dataProps2);
        printConfig(data, dataOlt);
    }

    function printGemMap(tcont, vlan, id){
        let gemMap = ''
        if(tcont && vlan){
            const vlans = vlan.split(',');
            vlans.forEach((val, index) => {
                gemMap += `gem mapping ${id} ${index+1} vlan ${val} <br>`;
            });
        }
        return gemMap;
    }

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

    function printConfig(data, dataOlt){

        const tcont1Value = data.tcont_1? `tcont 1 ${data.tcont_1} <br>`:'';
        const tcont2Value = data.tcont_2? `tcont 2 ${data.tcont_2} <br>`:'';
        const tcont3Value = data.tcont_3? `tcont 3 ${data.tcont_3} <br>`:'';
        const tcont4Value = data.tcont_4? `tcont 4 ${data.tcont_4} <br>`:'';
        
        const gemAdd1Value = data.tcont_1? `gem add 1 eth tcont 1 <br>`:'';
        const gemAdd2Value = data.tcont_2? `gem add 2 eth tcont 2 <br>`:'';
        const gemAdd3Value = data.tcont_3? `gem add 3 eth tcont 3 <br>`:'';
        const gemAdd4Value = data.tcont_4? `gem add 4 eth tcont 4 <br>`:'';

        const gemMap1= printGemMap(data.tcont_1, dataOlt.vlan, 1);

        const gemMap2= printGemMap(data.tcont_2, dataOlt.vlan_2g, 2);

        const gemMap3= printGemMap(data.tcont_3, dataOlt.vlan_3g, 3);

        const gemMap4= printGemMap(data.tcont_4, dataOlt.vlan_4g, 4);

        const text = `<p>
                        config <br>
                        ont-lineprofile gpon profile-id ${data.profile_id} profile-name "${dataOlt.site_id}_${dataOlt.site_name}" <br>
                        ${tcont1Value}
                        ${tcont2Value}
                        ${tcont3Value}
                        ${tcont4Value}
                        ${gemAdd1Value}
                        ${gemAdd2Value}
                        ${gemAdd3Value}
                        ${gemAdd4Value}
                        ${gemMap1}
                        ${gemMap2}
                        ${gemMap3}
                        ${gemMap4}
                        commit <br>
                        quit
                     </p>`;
        const genCon = document.getElementById('generate-config');
        genCon.style.display = 'block';
        genCon.innerHTML = text;
        genCon.focus();
    }

    document.getElementById('generateConfigBtn').addEventListener('click', function() {
        const dataProps  = this.getAttribute('data-olt');
        const dataOlt = JSON.parse(dataProps);
        const tcont_1 = document.getElementById('tcont_1').value;
        const tcont_2 = document.getElementById('tcont_2').value;
        const tcont_3 = document.getElementById('tcont_3').value;
        const tcont_4 = document.getElementById('tcont_4').value;
        const profile_id = document.getElementById('profile_id').value;
        const data ={
            profile_id,
            tcont_1,
            tcont_2,
            tcont_3,
            tcont_4
        }
        printConfig(data, dataOlt)
    })
</script>
</div>
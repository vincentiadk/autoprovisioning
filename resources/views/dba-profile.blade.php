<div id="formConfig" class="card-body">
    <input type="hidden" id="url" value="{{ url('panel/dba-profile/store') }}">
    <input type="hidden" name="olt_site_id" value="{{ $data['oltSite']->id }}">
    <div class="row">
        <div class="col-sm-5">
            <h4 class="card-title mb-0">
                DBA Profile
            </h4>
        </div>
        <!--col-->
        <div class="col-sm-7">

            <div class="btn-toolbar float-right" role="toolbar" aria-label="@lang('labels.general.toolbar_btn_groups')">
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
                    <input type="tel" name="profile_id" id="profile_id" class="form-control"
                        value="{{old('profile_id')}}" required onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="profile_name" class="col-md-4 form-control-label">
                    Profile Name
                </label>
                <div class="col-md-8">
                    <input type="text" name="profile_name" id="profile_name" class="form-control"
                        value="{{old('profile_name')}}" placeholder="example: OAM-Service-TSEL-1M">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="tcont_type" class="col-md-4 form-control-label">
                    Tcont Type
                </label>
                <div class="col-md-8">
                    <select name="tcont_type" id="tcont_type" class="form-control">
                        <option value="type1">Type 1</option>
                        <option value="type2">Type 2</option>
                        <option value="type3">Type 3</option>
                        <option value="type4">Type 4</option>
                    </select>
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div id="result-type">
                <div class="form-group row">
                    <label for="fix_bw" class="col-md-4 form-control-label">
                        Fix BW(Mb)
                    </label>
                    <div class="col-md-8">
                        <input type="tel" name="fix_bw" id="fix_bw" class="form-control"
                            onkeypress="allowNumbersOnly(event)">
                    </div>
                </div>
            </div>
            <div class="form-group pull-right">
                <button type="input" class="btn btn-md btn-success ml-2" onclick="simpan()">Create</button>
                <button type="button" class="btn btn-md btn-info" id="generateConfigBtn">Generate
                    Config</button>
            </div>
        </div>
        <!--col-->
        <div class="col-sm-12 col-md-6">

            <div class="generate-config">
                <div class="bg-gray-800 text-white rounded font-mono p-3">
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
    <input type="hidden" id="url" value="{{ url('panel/dba-profile/store') }}">
    <div class="row">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <td>Profile ID</td>
                        <td>Profile Name</td>
                        <td>Tcont Type</td>
                        <td>Fix BW</td>
                        <td>Assure BW</td>
                        <td>Max BW</td>
                        <td>Created By</td>
                        <td>Action</td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['dba'] as $data)
                    <tr>
                        <td>{{$data->profile_id}}</td>
                        <td>{{$data->profile_name}}</td>
                        <td>{{$data->tcont_type}}</td>
                        <td>{{$data->fix_bw}}</td>
                        <td>{{$data->assure_bw}}</td>
                        <td>{{$data->max_bw}}</td>
                        <td>{{$data->name}}</td>
                        <td>
                            <form action="{{ url('panel/dba-profile/delete/' . $data->id)}}" method="post"
                                id="formDelete">
                                @csrf
                                @method('delete')
                                <button type="button" class="btn btn-md btn-info" onclick="generateConfig(this)"
                                    data-props="{{json_encode($data)}}" data-toggle="tooltip" data-placement="top"
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
    <script>
    function generateConfig(e) {
        const dataProps = e.getAttribute('data-props');
        const data = JSON.parse(dataProps);
        printConfig(data);
    }

    function allowNumbersOnly(e) {
        var code = (e.which) ? e.which : e.keyCode;
        if (code > 31 && (code < 46 || code > 57)) {
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

    function printConfig(data) {
        let typeValue = '';
        if (data.tcont_type === 'type1') {
            typeValue = `fix ${data.fix_bw}`;
        } else if (data.tcont_type === 'type2') {
            typeValue = `assure ${data.assure_bw}`;
        } else if (data.tcont_type === 'type3') {
            typeValue = `assure ${data.assure_bw} max ${data.max_bw}`;
        } else if (data.tcont_type === 'type4') {
            typeValue = `max ${data.max_bw}`;
        }

        const text =
            `<p>config <br>
                    dba-profile add profile-id ${data.profile_id} profile-name "${data.profile_name}" ${data.tcont_type} ${typeValue}</p>`;
        const genCon = document.getElementById('generate-config');
        genCon.style.display = 'block';
        genCon.innerHTML = text;
        genCon.focus();
    }

    document.getElementById('tcont_type').addEventListener('change', function() {
        const resHtml = document.getElementById('result-type');

        const assureBW = `<div class="form-group row">
                                <label for="assure_bw" class="col-md-4 form-control-label"> 
                                    Assure BW(Mb)
                                </label>
                                <div class="col-md-8">
                                <input type="tel" name="assure_bw" id="assure_bw" class="form-control" onkeypress="allowNumbersOnly(event)">
                                </div>
                            </div>`;

        const fixBW = `<div class="form-group row">
                            <label for="fix_bw" class="col-md-4 form-control-label"> 
                                Fix BW(Mb)
                            </label>
                            <div class="col-md-8">
                            <input type="tel" name="fix_bw" id="fix_bw" class="form-control" onkeypress="allowNumbersOnly(event)">
                            </div>
                        </div>`;
        const maxBW = `<div class="form-group row">
                            <label for="max_bw" class="col-md-4 form-control-label"> 
                                Max BW(Mb)
                            </label>
                            <div class="col-md-8">
                            <input type="tel" name="max_bw" id="max_bw" class="form-control" onkeypress="allowNumbersOnly(event)">
                            </div>
                        </div>`;

        if (this.value === 'type1') {
            resHtml.innerHTML = fixBW;
        } else if (this.value === 'type2') {
            resHtml.innerHTML = assureBW;
        } else if (this.value === 'type3') {
            resHtml.innerHTML = assureBW + maxBW;
        } else if (this.value === 'type4') {
            resHtml.innerHTML = maxBW;
        }
    });

    document.getElementById('generateConfigBtn').addEventListener('click', function() {
        const profile_id = document.getElementById('profile_id').value;
        const profile_name = document.getElementById('profile_name').value;
        const tcont_type = document.getElementById('tcont_type').value;

        const fixInput = document.getElementById('fix_bw');
        const fix_bw = fixInput ? fixInput.value : null;

        const assureInput = document.getElementById('assure_bw');
        const assure_bw = assureInput ? assureInput.value : null;


        const maxInput = document.getElementById('max_bw');
        const max_bw = maxInput ? maxInput.value : null;

        const data = {
            profile_id,
            profile_name,
            tcont_type,
            fix_bw,
            assure_bw,
            max_bw
        }

        printConfig(data)
    })
    </script>
</div>
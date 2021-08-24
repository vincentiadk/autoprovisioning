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
        <div class="col-sm-4 mb-2">
            <a href="{{ url('panel/dba-profile/show/' . $data['oltSite']->id . '?config_id=' . $data['config_id']) }}" class="btn btn-md btn-primary text-white page-gpon">Create DBA Profile</a>
        </div>
        <div class="col-sm-4 mb-2">
            <a href="{{ url('panel/traffic-table/show/' . $data['oltSite']->id . '?config_id=' . $data['config_id']) }}" class="btn btn-md btn-primary text-white page-gpon">Create Traffic Table</a>
        </div>
        <div class="col-sm-4 mb-2">
            <a href="{{ url('panel/ont/show/' . $data['oltSite']->id . '?config_id=' . $data['config_id']) }}" class="btn btn-md btn-primary text-white page-gpon">Create ONT Line Profile</a>
        </div>
        <div class="col-sm-4 mb-2">
            <a href="{{ url('panel/vlan/show/' . $data['oltSite']->id . '?config_id=' . $data['config_id']) }}" class="btn btn-md btn-primary text-white page-gpon">Create VLAN</a>
        </div>
        <div class="col-sm-4 mb-2">
            <a href="{{ url('panel/ont/register/' . $data['oltSite']->id . '?config_id=' . $data['config_id']) }}" class="btn btn-md btn-primary text-white page-gpon">Registrasi ONT</a>
        </div>
        <div class="col-sm-4 mb-2">
            <a href="{{ url('panel/service-port/show/' . $data['oltSite']->id . '?config_id=' . $data['config_id']) }}" class="btn btn-md btn-primary text-white page-gpon">Create Service PORT</a>
        </div>
    <!--row-->
</div>
<script>
function allowNumbersOnly(e) {
    var code = (e.which) ? e.which : e.keyCode;
    if (code > 31 && (code < 40 || code > 57)) {
        e.preventDefault();
    }
}
select2AutoSuggest('#hostname', 'olt');
</script>
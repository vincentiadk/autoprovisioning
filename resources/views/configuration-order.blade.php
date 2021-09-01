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
        <div class="col-sm-6">
            <input type="hidden" name="order_id" id="order_id" value="{{ $data['order']->id }}">
            <div class="form-group row">
                <label for="hostname" class="col-md-4 form-control-label">
                    Nama Costumer
                </label>

                <div class="col-md-8">
                    <input class="form-control" id="nama_costumer" type="text" name="nama_costumer"
                        value=" {{ $data['order']->nama_costumer }} ">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="uplink_port" class="col-md-4 form-control-label">
                    Nomor Order
                </label>
                <div class="col-md-8">
                    <input type="text" name="order_number" id="order_number" class="form-control"
                        value=" {{ $data['order']->order_number }} ">
                </div>
                <!--col-->
            </div>

            <div class="form-group row">
                <label for="site_id" class="col-md-4 form-control-label">
                    Site ID
                </label>
                <div class="col-md-8">
                    <input type="text" name="site_id" id="site_id" class="form-control" placeholder="example: CBN234"
                        value="{{$data['oltSite']->site_id}}" required>
                    <small>Format 3 huruf dan 3 angka</small>
                </div>
                <!--col-->

            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="site_name" class="col-md-4 form-control-label">
                    Site Name
                </label>
                <div class="col-md-8">
                    <input type="text" name="site_name" id="site_name" class="form-control"
                        value="{{$data['oltSite']->site_name}}" required>
                </div>
                <!--col-->
            </div>
            <div class="form-group row">
                <label for="bw" class="col-md-4 form-control-label">
                    Band Width
                </label>
                <div class="col-md-8">
                    <input type="text" name="bw" id="bw" class="form-control"
                        value="{{ $data['oltSite']->bw_order_total }} ">
                </div>
                <!--col-->
            </div>
            <!--form-group-->
            <input type="hidden" name="olt_site_id" id="olt_site_id"
                value="{{ $data['oltSite']->id ? $data['oltSite']->id : 0 }}">
            <div class="form-group row">
                <label for="hostname" class="col-md-4 form-control-label">
                    Hostname
                </label>

                <div class="col-md-8">
                    <select class="select2 form-control" id="hostname" name="hostname">
                        @if($data['oltSite']->oltList)
                        <option value="{{ $data['oltSite']->hostname }}" selected>
                            {{ $data['oltSite']->oltList->node_id .' '. $data['oltSite']->oltList->brand . ' ' . $data['oltSite']->oltList->node_ip . ' ' . $data['oltSite']->oltList->node_type }}
                        </option>
                        @endif
                    </select>
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="uplink_port" class="col-md-4 form-control-label">
                    Uplink Port
                </label>
                <div class="col-md-8">
                    <input type="text" name="uplink_port" id="uplink_port" class="form-control"
                        value="{{$data['oltSite']->uplink_port}}" required>
                </div>
                <!--col-->
            </div>
            <!--form-group-->
            <div class="form-group row">
                <label for="bw_order_oam" class="col-md-4 form-control-label">
                    BW Order OAM
                </label>
                <div class="col-md-8">
                    <input type="tel" name="bw_order_oam" id="bw_order_oam" class="form-control"
                        value="{{$data['oltSite']->bw_order_oam}}" maxlength="8" required
                        onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="bw_order_2g" class="col-md-4 form-control-label">
                    BW Order 2G
                </label>
                <div class="col-md-8">
                    <input type="tel" name="bw_order_2g" id="bw_order_2g" class="form-control"
                        value="{{$data['oltSite']->bw_order_2g}}" maxlength="8" onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="bw_order_3g" class="col-md-4 form-control-label">
                    BW Order 3G
                </label>
                <div class="col-md-8">
                    <input type="tel" name="bw_order_3g" id="bw_order_3g" class="form-control"
                        value="{{$data['oltSite']->bw_order_3g}}" maxlength="8" onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="bw_order_4g" class="col-md-4 form-control-label">
                    BW Order 4G
                </label>
                <div class="col-md-8">
                    <input type="tel" name="bw_order_4g" id="bw_order_4g" class="form-control"
                        value="{{$data['oltSite']->bw_order_4g}}" maxlength="8" onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

        </div>
        <!--col-->
        <div class="col-sm-6">

            <div class="form-group row">
                <label for="vlan" class="col-md-4 form-control-label">
                    OAM, Clock, Cplane:
                </label>
                <div class="col-md-8">
                    <input type="text" name="vlan" id="vlan" class="form-control" value="{{$data['oltSite']->vlan}}"
                        required onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="vlan_2g" class="col-md-4 form-control-label">
                    VLAN 2G
                </label>
                <div class="col-md-8">
                    <input type="text" name="vlan_2g" id="vlan_2g" class="form-control"
                        value="{{$data['oltSite']->vlan_2g}}" required onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="vlan_3g" class="col-md-4 form-control-label">
                    VLAN 3G
                </label>
                <div class="col-md-8">
                    <input type="text" name="vlan_3g" id="vlan_3g" class="form-control"
                        value="{{$data['oltSite']->vlan_3g}}" required onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->

            <div class="form-group row">
                <label for="vlan_4g" class="col-md-4 form-control-label">
                    VLAN 4G
                </label>
                <div class="col-md-8">
                    <input type="text" name="vlan_4g" id="vlan_4g" class="form-control"
                        value="{{$data['oltSite']->vlan_4g}}" required onkeypress="allowNumbersOnly(event)">
                </div>
                <!--col-->
            </div>
            <!--form-group-->
            <input type="hidden" id="url" value="{{ url('panel/olt-site/store') }}">

        </div>
        <!--col-->
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
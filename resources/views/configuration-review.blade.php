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
            <h4>Order</h4>
            <table class="table-responsive table-striped">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td>{{ $data['order'] ? $data['order']->nama_costumer : "" }}</td>
                    </tr>
                    <tr>
                        <td>No Order</td>
                        <td>:</td>
                        <td>{{ $data['order'] ? $data['order']->order_number : "" }}</td>
                    </tr>
                </tbody>
            </table>
            <hr />
            <h4>Metro</h4>
            <table class="table-responsive table-striped">
                <tbody>
                    <tr>
                        <td>Metro Akses</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Port Akses</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>VLAN</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Metro Backhaul 1</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Port Metro Blackhaul 1</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Metro Backhaul 2</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Port Metro Backhaul 2</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Description Port</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Service ID</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Costumer ID</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>Description Service</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>SDP IP ke Metro Backhaul 1</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>SDP IP ke Metro Backhaul 2</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>SDP IP ke Metro Akses</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-6">
            <h4>GPON</h4>
            <table class="table-responsive table-striped">
                <tbody>
                    <tr>
                        <td>Hostname</td>
                        <td>:</td>
                        <td>{{ $data['oltSite'] ? ($data['oltSite']->oltList ? $data['oltSite']->oltList->node_id ." ". $data['oltSite']->oltList->brand . " " .  $data['oltSite']->oltList->node_ip . " " . $data['oltSite']->oltList->node_type : "") : "" }}</td>
                    </tr>
                    <tr>
                        <td>Uplink Port</td>
                        <td>:</td>
                        <td>{{ $data['oltSite'] ? $data['oltSite']->uplink_port : "" }}</td>
                    </tr>
                    <tr>
                        <td>Site ID</td>
                        <td>:</td>
                        <td>{{ $data['oltSite'] ? $data['oltSite']->site_id : "" }}</td>
                    </tr>
                    <tr>
                        <td>Site Name</td>
                        <td>:</td>
                        <td>{{ $data['oltSite'] ? $data['oltSite']->site_name : "" }}</td>
                    </tr>
                    <tr>
                        <td>BW Order OAM</td>
                        <td>:</td>
                        <td>{{ $data['oltSite'] ? $data['oltSite']->bw_order_oam . " Mb": "0 Mb" }}</td>
                    </tr>
                    <tr>
                        <td>BW Order 2G</td>
                        <td>:</td>
                        <td>{{ $data['oltSite'] ? $data['oltSite']->bw_order_2g . " Mb": "0 Mb" }}</td>
                    </tr>
                    <tr>
                        <td>BW Order 3G</td>
                        <td>:</td>
                        <td>{{ $data['oltSite'] ? $data['oltSite']->bw_order_3g . " Mb": "0 Mb" }}</td>
                    </tr>
                    <tr>
                        <td>BW Order 4G</td>
                        <td>:</td>
                        <td>{{ $data['oltSite'] ? $data['oltSite']->bw_order_4g . " Mb": "0 Mb" }}</td>
                    </tr>
                    <tr>
                        <td>OAM, Clock, Cplane:</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>VLAN 2G</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>VLAN 3G</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>VLAN 4G</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <hr />
            <h4>ONT</h4>
            <table class="table-responsive table-striped">
                <tbody>
                    <tr>
                        <td>Nama</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>No Order</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!--col-->
</div>
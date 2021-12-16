<div id="myContent">
<!-- Content Wrapper. Contains page content -->
<div class="container-fluid dashboard-content">
    <!-- Main content -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{ $data['title'] }} </h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('panel/dashboard') }}" class="breadcrumb-link page">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Inbox</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="container-fluid">
                <div class="row parent">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <button class="btn btn-warning" onclick="refreshDatatable()"> <i class="fas fa-sync"></i> Refresh </button>
                                <a class="btn btn-primary page" href="{{ url('panel/configuration/form') }}"> <i class="fas fa-plus-circle"></i> Buat Konfigurasi </a>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-danger" id="validasi_element" style="display:none;">
                                    <ul id="validasi_content"></ul>
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered first" id="datatable_serverside"
                                        style="width:100%">
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>Nomor Order</th>
                                                <!--<th>Nama</th>
                                                <th>Site Name</th>
                                                <th>BW</th>-->
                                                <th>Metro</th>
                                                <th>GPON</th>
                                                <th>ONT</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.card -->
        </div>
    </div>
</div>
<div class="modal animated bounceInRight text-left " id="modal_configuration" data-backdrop="static" role="dialog"
        aria-labelledby="myModalLabel50" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="config_detail">
                    
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
<script>

var oTable = $('#datatable_serverside').DataTable({
    processing: true,
    serverSide: true,
    destroy: true,
    scrollX: true,
    order: [
        [0, 'desc']
    ],
    iDisplayInLength: 10,
    ajax: {
        url: '{{ url("panel/configuration/datatable") }}',
        data: {},
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        type: 'POST',
    }
});

function refreshDatatable(){
    oTable.ajax.reload();
}

function detailConfiguration(config_id) {
    $("#config_detail").load("{{url('panel/configuration')}}" + "/config-review?config_id=" + config_id);
    $('#modal_configuration').modal('show');
}
</script>
</div>
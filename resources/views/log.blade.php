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
                            <li class="breadcrumb-item active" aria-current="page">Logs</li>
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
                                                <th>User</th>
                                                <th>Description</th>
                                                <th>Subject</th>
                                                <th>Data</th>
                                                <th>Time</th>
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
    <div class="modal animated bounceInRight text-left" id="modal_confirmation" data-backdrop="static" role="dialog"
        aria-labelledby="myModalLabel50" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel50">Konfirmasi</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <h4>Anda yakin akan <span id="spanLock"></span>? </h4>
                    <p id="pLock" style="color:orange"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="btn_save_lock">Ya</button>
                    <button type="button" class="btn btn-danger" onclick="cancel()" id="btn_cancel_lock">Batal</button>
                </div>
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
        url: '{{ url("panel/logs/datatable") }}',
        data: {},
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        type: 'POST',
    },
    columns: [{
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
        {
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        },
    ]
});

function refreshDatatable(){
    oTable.ajax.reload();
}

</script>
</div>
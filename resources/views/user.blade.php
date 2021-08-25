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
                            <li class="breadcrumb-item active" aria-current="page">User</li>
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
                                <a  class="btn btn-primary page" href="{{ url('panel/user/show/0') }}"> <i class="fas fa-plus-circle"></i> Tambah User </a>
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
                                                <th>Nama</th>
                                                <th>No Telp</th>
                                                <th>Email</th>
                                                <th>LDAP</th>
                                                <th>NIK</th>
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
        url: '{{ url("panel/user/datatable") }}',
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
        {
            searchable: false,
            orderable: false,
            className: 'align-middle text-center'
        }
    ]
});

function refreshDatatable(){
    oTable.ajax.reload();
}
function disableUser(id) {
    getUser(id, 0);
    $('#modal_confirmation').modal('show');
}

function enableUser(id) {
    getUser(id, 1);
    $('#modal_confirmation').modal('show');
}

function getUser(id, type) {
    $.ajax({
        url: '{{ url("panel/select2/user") }}',
        type: 'POST',
        dataType: 'JSON',
        data: {
            id: id
        },
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        beforeSend: function() {
            loadingOpen('.content-wrapper');
            $('#validasi_element').hide();
            $('#validasi_content').html('');
        },
        success: function(response) {
            loadingClose('.content-wrapper');
            if (type == 1) {
                $('#spanLock').html('<b>mengaktifkan</b> User : ' + response.name);
                $('#pLock').html(
                    '*) Setelah diaktifakan, user dapat login ke dalam sistem.'
                );
                $('#btn_save_lock').attr('onclick', 'doDisableEnable(' + id + ', 1)');
            } else {
                $('#spanLock').html('<b>menonaktifkan</b> User : ' + response.name);
                $('#pLock').html(
                    '*) Setelah dinonaktifkan, user <b>tidak dapat</b> login ke dalam sistem.');
                $('#btn_save_lock').attr('onclick', 'doDisableEnable(' + id + ', 0)');
            }
        },
        error: function() {
            loadingClose('.content-wrapper');
            cancel();
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }
    })
}

function cancel() {
    $('#modal_confirmation').modal('hide');
}

function doDisableEnable(id, type) {
    if (type == 1) {
        var ajax_url = '{{ url("panel/user/activation") }}';
    } else {
        var ajax_url = '{{ url("panel/user/deactive") }}';
    }
    $.ajax({
        url: ajax_url,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        data: {
            id: id,
        },
        dataType: 'JSON',
        beforeSend: function() {
            loadingOpen('.modal-content');
            $('#validasi_element').hide();
            $('#validasi_content').html('');
        },
        success: function(response) {
            loadingClose('.modal-content');
            if (response.status == 200) {
                oTable.ajax.reload(null, false);
                Toast.fire({
                    icon: 'success',
                    title: response.message
                });
            } else if (response.status == 422) {
                Toast.fire({
                    icon: 'info',
                    title: 'Validasi'
                });
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: response.message
                });
            }
            $('#modal_confirmation').modal('hide');
        },
        error: function() {
            loadingClose('.modal-content');
            cancel();
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }
    })
}
</script>
</div>
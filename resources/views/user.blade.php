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
                            <!--<button class="btn btn-warning" onclick="refreshDatatable('DatatableUser')"> <i class="fas fa-sync"></i> Refresh </button>-->
                                <a  class="btn btn-primary page" href="{{ url('panel/user/show/0') }}"> <i class="fas fa-plus-circle"></i> Tambah User </a>
                            </div>
                            <div class="card-body">
                                <div class="alert alert-danger" id="validasi_element" style="display:none;">
                                    <ul id="validasi_content"></ul>
                                </div>
                                <div class="table-responsive">
                                    <datatable-user></datatable-user>
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



</div>
<template>
    <div class="container-fluid dashboard-content">
    <!-- Main content -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title" v-html="title"></h2>
               
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
                                    <datatable-metro></datatable-metro>
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
</template>
<script>
export default {
  data() {
    return {
      title: ""
    };
  },
  created() {
    let currentObj = this;
    axios.get("/panel/metro/get-title").then(function (response) {
      currentObj.title = response.data.title;
    });
  },
};
</script>
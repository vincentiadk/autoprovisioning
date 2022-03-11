<template>
  <!-- Content Wrapper. Contains page content -->
  <div class="container-fluid dashboard-content">
    <!-- Main content -->
    <div class="row">
      <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
        <div class="page-header">
          <h2 class="pageheader-title" v-html="title"></h2>
          <div class="page-breadcrumb">
            <nav aria-label="breadcrumb">
              <ol class="breadcrumb">
                <li class="breadcrumb-item">
                  <a href="/panel/dashboard" class="breadcrumb-link page"
                    >Dashboard</a
                  >
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                  Inbox
                </li>
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
                  <button class="btn btn-warning" onclick="refreshDatatable()">
                    <i class="fas fa-sync"></i> Refresh
                  </button>
                  <a
                    class="btn btn-primary page"
                    href="/panel/configuration/form"
                  >
                    <i class="fas fa-plus-circle"></i> Buat Konfigurasi
                  </a>
                </div>
                <div class="card-body">
                  <div
                    class="alert alert-danger"
                    id="validasi_element"
                    style="display: none"
                  >
                    <ul id="validasi_content"></ul>
                  </div>
                  <datatable-configuration></datatable-configuration>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div
      class="modal animated bounceInRight text-left"
      id="modal_configuration"
      data-backdrop="static"
      role="dialog"
      aria-labelledby="myModalLabel50"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button
              type="button"
              class="close"
              data-dismiss="modal"
              aria-label="Close"
            >
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body" id="config_detail"></div>
          <div class="modal-footer">
            <button
              type="button"
              class="btn btn-outline-light"
              data-dismiss="modal"
            >
              Tutup
            </button>
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
    axios.get("/panel/configuration/get-title").then(function (response) {
      currentObj.title = response.data.title;
      console.log(response);
    });
  },
};
</script>
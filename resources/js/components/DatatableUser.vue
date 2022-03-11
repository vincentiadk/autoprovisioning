<template>
  <!-- Content Wrapper. Contains page content -->

  <div class="table-responsive">
    <table
      class="table table-striped table-bordered first"
      id="datatable_serverside"
      style="width: 100%"
    >
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
</template>

<script type="application/javascript">
export default {
  data() {
    return {
      datatable: null,
    };
  },
  mounted() {
    vm.DatatableUser = this;
    let opts = {
      processing: true,
      serverSide: true,
      stateSave : true,
      ajax: {
        url: "/panel/user/datatable/",
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]')
            .content,
        },
        type: "POST",
      },
      columns: [
        {
          searchable: false,
          orderable: false,
          className: "align-middle text-center",
        },
        {
          searchable: false,
          orderable: false,
          className: "align-middle text-center",
        },
        {
          searchable: false,
          orderable: false,
          className: "align-middle text-center",
        },
        {
          searchable: false,
          orderable: false,
          className: "align-middle text-center",
        },
        {
          searchable: false,
          orderable: false,
          className: "align-middle text-center",
        },
        {
          searchable: false,
          orderable: false,
          className: "align-middle text-center",
        },
        {
          searchable: false,
          orderable: false,
          className: "align-middle text-center",
        },
      ],
    };
    this.datatable = $("#datatable_serverside").DataTable(opts);
  },
};
window.disableUser = function (id) {
  window.getUser(id, 0);
  $("#modal_confirmation").modal("show");
};

window.enableUser = function (id) {
  window.getUser(id, 1);
  $("#modal_confirmation").modal("show");
};

window.getUser = function (id, type) {
  $.ajax({
    url: "/panel/select2/user",
    type: "POST",
    dataType: "JSON",
    data: {
      id: id,
    },
    headers: {
      "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]')
        .content,
    },
    beforeSend: function () {
      loadingOpen(".content-wrapper");
      $("#validasi_element").hide();
      $("#validasi_content").html("");
    },
    success: function (response) {
      loadingClose(".content-wrapper");
      if (type == 1) {
        $("#spanLock").html("<b>mengaktifkan</b> User : " + response.name);
        $("#pLock").html(
          "*) Setelah diaktifakan, user dapat login ke dalam sistem."
        );
        $("#btn_save_lock").attr("onclick", "doDisableEnable(" + id + ", 1)");
      } else {
        $("#spanLock").html("<b>menonaktifkan</b> User : " + response.name);
        $("#pLock").html(
          "*) Setelah dinonaktifkan, user <b>tidak dapat</b> login ke dalam sistem."
        );
        $("#btn_save_lock").attr("onclick", "doDisableEnable(" + id + ", 0)");
      }
    },
    error: function () {
      loadingClose(".content-wrapper");
      window.cancel();
      Toast.fire({
        icon: "error",
        title: "Server Error!",
      });
    },
  });
};

window.cancel = function () {
  $("#modal_confirmation").modal("hide");
};

window.doDisableEnable = function (id, type) {
  if (type == 1) {
    var ajax_url = "/panel/user/activation";
  } else {
    var ajax_url = "/panel/user/deactive";
  }
  $.ajax({
    url: ajax_url,
    type: "POST",
    headers: {
      "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]')
        .content,
    },
    data: {
      id: id,
    },
    dataType: "JSON",
    beforeSend: function () {
      loadingOpen(".modal-content");
      $("#validasi_element").hide();
      $("#validasi_content").html("");
    },
    success: function (response) {
      loadingClose(".modal-content");
      if (response.status == 200) {
        //make a function to handle refresh data
        vm.DatatableUser.datatable.ajax.reload();
        Toast.fire({
          icon: "success",
          title: response.message,
        });
      } else if (response.status == 422) {
        Toast.fire({
          icon: "info",
          title: "Validasi",
        });
      } else {
        Toast.fire({
          icon: "warning",
          title: response.message,
        });
      }
      $("#modal_confirmation").modal("hide");
    },
    error: function () {
      loadingClose(".modal-content");
      cancel();
      Toast.fire({
        icon: "error",
        title: "Server Error!",
      });
    },
  });
};
</script>
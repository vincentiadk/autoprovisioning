<template>
  <div class="table-responsive">
    <table
      class="table table-striped table-bordered first"
      id="datatable_serverside"
      style="width: 100%"
    >
      <thead class="text-center">
        <tr>
          <th>No</th>
          <th>Nomor Order</th>
          <th>Metro</th>
          <th>GPON</th>
          <th>ONT</th>
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
    vm.DatatableConfiguration = this;
    let opts = {
      processing: true,
      serverSide: true,
      destroy: true,
      scrollX: true,
      stateSave: true,
      order: [[0, "desc"]],
      ajax: {
        url: "/panel/configuration/datatable/",
        headers: {
          "X-CSRF-TOKEN": document.head.querySelector('meta[name="csrf-token"]')
            .content,
        },
        type: "POST",
      },
    };
    this.datatable = $("#datatable_serverside").DataTable(opts);
  },
};

window.detailConfiguration = function (config_id) {
  $("#config_detail").load(
    "panel/configuration/config-review?config_id=" + config_id
  );
  $("#modal_configuration").modal("show");
};
</script>
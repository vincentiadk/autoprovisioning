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
          <th>Name</th>
          <th>IP</th>
          <th>Manufacture</th>
          <th>Area</th>
          <th>Group</th>
          <th>Aksi</th>
        </tr>
      </thead>
    </table>
  </div>
</template>
<script>
export default {
  data() {
    return {
      datatable: null,
    };
  },
  mounted() {
    vm.DatatableMetro = this;
    let opts = {
      processing: true,
      serverSide: true,
      destroy: true,
      scrollX: true,
      stateSave: true,
      order: [[0, "desc"]],
      iDisplayInLength: 10,
      ajax: {
        url: '/panel/metro/datatable',
        data: {},
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
function refreshDatatable() {
  oTable.ajax.reload();
}

function cancel() {
  $("#modal_confirmation").modal("hide");
}
</script>
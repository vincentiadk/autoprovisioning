<template>
  <div class="card-body">
    <div class="row">
      <div class="col-sm-5">
        <h4 class="card-title mb-0">
          {{ title }}
        </h4>
      </div>
    </div>
    <hr />
    <div class="row mt-4 mb-4">
      <div class="col-sm-6 haha">
        <input type="hidden" name="order_id" id="order_id" v-model="order.id" />
        <div class="form-group row">
          <label for="hostname" class="col-md-6 form-control-label">
            Nama Costumer
          </label>

          <div class="col-md-8">
            <input
              class="form-control"
              id="nama_costumer"
              type="text"
              name="nama_costumer"
              readonly="true"
              v-model="order.nama_costumer"
            />
          </div>
          <!--col-->
        </div>
        <!--form-group-->

        <div class="form-group row">
          <label for="uplink_port" class="col-md-6 form-control-label">
            Nomor Order
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="order_number"
              id="order_number"
              class="form-control"
              readonly="true"
              v-model="order.order_number"
            />
          </div>
          <!--col-->
        </div>
        <div class="form-group row">
          <label for="hostname" class="col-md-6 form-control-label">
            Select OLT Hostname
          </label>

          <div class="col-md-8">
            <select
              class="select2 form-control"
              id="hostname"
              name="hostname"
              v-model="oltSite.hostname"
            ></select>
          </div>
          <!--col-->
        </div>
        <!--form-group-->

        <div class="form-group row">
          <label for="uplink_port" class="col-md-6 form-control-label">
            Select OLT Uplink Port
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="uplink_port"
              id="uplink_port"
              class="form-control"
              v-model="oltSite.uplink_port"
              required
            />
          </div>
          <!--col-->
        </div>

        <div class="form-group row">
          <label for="ip_ont" class="col-md-6 form-control-label">
            IP ONT
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="ip_ont"
              id="ip_ont"
              class="form-control"
              v-model="oltSite.ip_ont"
              required
            />
          </div>
          <!--col-->
        </div>

        <div class="form-group row">
          <label for="ip_ont" class="col-md-6 form-control-label">
            Serial Number ONT
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="sn_ont"
              id="sn_ont"
              class="form-control"
              v-model="oltSite.sn_ont"
              required
            />
          </div>
          <!--col-->
        </div>
      </div>
      <div class="col-sm-6">
        <div class="form-group row">
          <label for="site_id" class="col-md-6 form-control-label">
            Site ID
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="site_id"
              id="site_id"
              readonly="true"
              class="form-control"
              placeholder="example: CBN234"
              v-model="oltSite.site_id"
              required
            />
            <small>Format 3 huruf dan 3 angka</small>
          </div>
          <!--col-->
        </div>
        <!--form-group-->

        <div class="form-group row">
          <label for="site_name" class="col-md-6 form-control-label">
            Site Name
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="site_name"
              id="site_name"
              class="form-control"
               readonly="true"
              v-model="oltSite.site_name"
              required
            />
          </div>
          <!--col-->
        </div>

        <div class="form-group row">
          <label for="bw" class="col-md-6 form-control-label">
            BW Order 
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="bw"
              id="bw"
              class="form-control"
              v-model="oltSite.bw_order_total"
            />
          </div>
          <!--col-->
        </div>
        <!--form-group-->
        <input
          type="hidden"
          name="olt_site_id"
          id="olt_site_id"
          v-model="oltSite.id"
        />

       
        <div class="form-group row">
          <label for="vlan" class="col-md-6 form-control-label">
            VLAN
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="vlan"
              id="vlan"
              class="form-control"
              v-model="oltSite.vlan"
              required
              onkeypress="allowNumbersOnly(event)"
            />
          </div>
          <!--col-->
        </div>
      </div>
      <div class="col-sm-12">
        <a
          href="#"
          class="btn btn-md btn-info"
          style="width: 70%; margin-left: 15%"
          id="btn_simpan"
          @click="save"
          >Save Configuration</a
        >
      </div>
      <div class="col-sm-12 row mt-4" v-if="oltSite.id != 0">
        <div class="col-sm-4 mb-2">
          <a
            id="dba_profile"
            class="btn btn-md btn-primary text-white page-gpon"
            @click="openGponPage(1)" style="width:70%"
          >
            Create DBA Profile
          </a>
        </div>
        <div class="col-sm-4 mb-2">
          <a
            id="traffic_table"
            class="btn btn-md btn-primary text-white page-gpon"
            @click="openGponPage(2)" style="width:70%"
          >
            Create Traffic Table
          </a>
        </div>
        <div class="col-sm-4 mb-2">
          <a
            id="ont"
            class="btn btn-md btn-primary text-white page-gpon"
            @click="openGponPage(3)" style="width:70%"
          >
            Create ONT Line Profile
          </a>
        </div>
        <div class="col-sm-4 mb-2">
          <a
            id="vlan"
            class="btn btn-md btn-primary text-white page-gpon"
            @click="openGponPage(4)" style="width:70%"
          >
            Create VLAN
          </a>
        </div>
        <div class="col-sm-4 mb-2">
          <a
            id="registrasi_ont"
            class="btn btn-md btn-primary text-white page-gpon"
            @click="openGponPage(5)" style="width:70%"
          >
            Registrasi ONT
          </a>
        </div>
        <div class="col-sm-4 mb-2">
          <a
            id="service_port"
            class="btn btn-md btn-primary text-white page-gpon"
            @click="openGponPage(6)" style="width:70%"
          >
            Create Service PORT
          </a>
        </div>
      </div>
      <!--col-->
    </div>
    <!--row-->
  </div>
</template>
<script>
export default {
  created() {
    let currentObj = this;
    axios
      .get(
        "/panel/configuration/config-order?config_id=" +
          currentObj.$parent.config_id
      )
      .then((response) => {
        if (response.data.oltSite.length != 0) {
          this.$parent.gponPage = 0;
          this.$parent.olt_site_id = response.data.oltSite.id;
          this.oltSite.id = response.data.oltSite.id;
          this.oltSite.site_name = response.data.oltSite.site_name;
          this.oltSite.bw_order_total = response.data.oltSite.bw_order_total;
          this.oltSite.uplink_port = response.data.oltSite.uplink_port;
          this.oltSite.vlan = response.data.oltSite.vlan;
          this.oltSite.ip_ont = response.data.oltSite.ip_ont;
          this.oltSite.sn_ont = response.data.oltSite.sn_ont;
          this.oltSite.host_name = response.data.oltSite.host_name;
          this.oltSite.site_id = response.data.oltSite.site_id;
        }
        this.url = $("#url").val();
        this.order.id = response.data.order.id;
        this.order.nama_costumer = response.data.order.nama_costumer;
        this.order.order_number = response.data.order.order_number;
        this.title = response.data.title;

        select2AutoSuggest("#hostname", "olt");
      });
  },
  data() {
    return {
      oltSite: {
        id: 0,
        site_name: null,
        bw_order_total: null,
        uplink_port: null,
        vlan: null,
        ip_ont: null,
        sn_ont: null,
        host_name: null,
        site_id: null,
      },
      order: {
        id: null,
        nama_costumer: null,
        order_number: null,
      },
      title: "",
      config_id: this.$parent.config_id,
      url: null,
      csrf: document.head.querySelector('meta[name="csrf-token"]').content,
    };
  },
  methods: {
    openGponPage(pageNum) {
      this.$parent.gponPage = pageNum;
    },
    save() {
      //e.preventDefault();
      var formData = new FormData($("#form_data")[0]);
      let currentObj = this;
      $.ajax({
        url: '/panel/olt-site/store',
        type: "POST",
        dataType: "JSON",
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
          "X-CSRF-TOKEN": currentObj.csrf,
        },
        beforeSend: function () {
          loadingOpen(".dashboard-wrapper");
          $("#validasi_content").html("");
        },
        success: function (response) {
          loadingClose(".dashboard-wrapper");
          if (response.status == 200) {
            if (typeof response.object !== "undefined") {
              $.each(response.object, function (key, value) {
                $("#" + key).val(value);
              });
            }
            currentObj.$parent.gponForm = true;
            Toast.fire({
              icon: "success",
              title: response.message,
            });
          } else if (response.status == 422) {
            $.each(response.error, function (i, val) {
              $("#validasi_content").append("<li>" + val + "</li>");
            });
            $("#modal_validation").modal("show");
          } else {
            simpanResponse = response;
            Toast.fire({
              icon: "warning",
              title: response.message,
            });
          }
        },
        error: function () {
          loadingClose(".dashboard-wrapper");
          Toast.fire({
            icon: "error",
            title: "Server Error!",
          });
        },
      });
    },
  },
};
</script>
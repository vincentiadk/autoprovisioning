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
      <div class="col-sm-12">
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
              v-model="order.order_number"
            />
          </div>
          <!--col-->
        </div>
        <div class="form-group row">
          <label for="site_id" class="col-md-6 form-control-label">
            Site ID
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="site_id"
              id="site_id"
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
              v-model="oltSite.site_name"
              required
            />
          </div>
          <!--col-->
        </div>

        <div class="form-group row">
          <label for="regional" class="col-md-6 form-control-label">
            Regional
          </label>
          <div class="col-md-8">
             <select v-model="order.regional" name="regional" class="form-control">
                <option>Pilih Regional</option>
                <option value="1">Regional 1</option>
                <option value="2">Regional 2</option>
                <option value="3">Regional 3</option>
                <option value="4">Regional 4</option>
                <option value="5">Regional 5</option>
                <option value="6">Regional 6</option>
                <option value="7">Regional 7</option>
            </select>
          </div>
          <!--col-->
        </div>
        <div class="form-group row">
          <label for="work_zone" class="col-md-6 form-control-label">
            Work Zone
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="work_zone"
              id="work_zone"
              class="form-control"
              v-model="order.work_zone"
              required
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
          >Save Order</a
        >
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
        "/panel/configuration/config-order?config_id=" + currentObj.$parent.config_id
      )
      .then((response) => {
        if(response.data.oltSite.length != 0){
          this.oltSite.id = response.data.oltSite.id;
          this.oltSite.site_name = response.data.oltSite.site_name;
          this.oltSite.site_id = response.data.oltSite.site_id;
          this.$parent.olt_site_id =  response.data.oltSite.id;
        }
        if(response.data.order.length != 0) {
          this.$parent.orderForm = true;
        }
        this.order.id = response.data.order.id;
        this.order.nama_costumer = response.data.order.nama_costumer;
        this.order.order_number = response.data.order.order_number;
        this.order.regional = response.data.order.regional;
        this.order.work_zone = response.data.work_zone;
        this.title = response.data.title;
      });
  },
  data() {
    return {
      oltSite: {
        id: 0,
        site_name: null,
        site_id: null,
      },
      order: {
        id: null,
        nama_costumer: null,
        order_number: null,
        work_zone: null,
        regional: null,
      },
      title: "",
      config_id: this.$parent.config_id,
      csrf: document.head.querySelector('meta[name="csrf-token"]').content,
    };
  },
  methods: {
    openOltPage(pageNum) {
      this.$parent.oltPage = pageNum;
    },
    save() {
      //e.preventDefault();
      var formData = new FormData($("#form_data")[0]);
      let currentObj = this;
      $.ajax({
        url: '/panel/order/store',
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
            currentObj.$parent.olt_site_id = response.oltSite.id;
            currentObj.$parent.config_id = response.config_id;
            currentObj.$parent.orderForm = true;
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
window.allowNumbersOnly = function (e) {
  var code = e.which ? e.which : e.keyCode;
  if (code > 31 && (code < 40 || code > 57)) {
    e.preventDefault();
  }
};
</script>
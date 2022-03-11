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
    <div class="steps">
      <ul id="progressbar">
        <li><a href="#" id="aOrder">Order Review</a></li>
        <li><a href="#" id="aMetro">Metro</a></li>
        <li><a href="#" id="aGpon">GPON</a></li>
        <li><a href="#" id="aOnt">ONT</a></li>
        <li><a href="#" id="aReview">Review</a></li>
      </ul>
    </div>
    <div class="row">
      <form id="form_data" class="col-md-12">
        <input
          type="hidden"
          id="config_id"
          v-model="config_id"
          name="config_id"
        />
        <input
          type="hidden"
          id="olt_site_id"
          v-model="olt_site_id"
          name="olt_site_id"
        />
        <div id="formConfig" class="card">
          <div v-if="step === 1">
            <order-form ref="orderform"></order-form>
          </div>
          <div v-if="step === 2">
            <metro-form ref="metroform"></metro-form>
          </div>
          <div v-if="step === 3">
            <div v-if="gponPage === 0">
              <gpon-form></gpon-form>
            </div>
            <div v-if="gponPage === 1">
              <gpon-dba-profile></gpon-dba-profile>
            </div>
            <div v-if="gponPage === 2">
              <gpon-traffic-table></gpon-traffic-table>
            </div>
            <div v-if="gponPage === 3">
              <gpon-ont-line-profile></gpon-ont-line-profile>
            </div>
            <div v-if="gponPage === 4">
              <gpon-vlan></gpon-vlan>
            </div>
            <div v-if="gponPage === 5">
              <gpon-registrasi-ont></gpon-registrasi-ont>
            </div>
            <div v-if="gponPage === 6">
              <gpon-services-ont></gpon-services-ont>
            </div>
          </div>
          <div v-if="step === 4">
            <ont-form> </ont-form>
          </div>
          <div v-if="step === 5">
            <review-form></review-form>
          </div>
        </div>
        <div class="form-group text-center">
          <button
            type="button"
            class="btn btn-md btn-primary"
            id="btn_prev"
            @click="prev"
          >
            Prev
          </button>

          <button
            type="button"
            class="btn btn-md btn-primary"
            id="btn_next"
            @click="next"
          >
            Next
          </button>
        </div>
      </form>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      step: 1,
      gponPage: 0,
      title: "",
      olt_site_id : "",
      config_id:
        window.getSearchParams("config_id") == undefined
          ? 0
          : window.getSearchParams("config_id"),
      order_id : "",
      metro_id : "",
      orderForm : false,
      gponForm : false,
      metroForm : false,
      ontForm: false,
    };
  },
  methods: {
    prev() {
      this.step--;
      if(this.step < 1){
        this.step = 1;
      }
    },
    next() {
      this.step++;
      switch(this.step){
        case 2 : //ke form metro
          if(! this.orderForm) {
             this.$fire({
                    title: "Error",
                    html: "Please complete Order Form",
                    type: "error",
                    timer: 5000,
                })
            this.step--;
          }
        break;

        case 3 : //ke form gpon
        //if(! this.metroForm) {
        if(! this.orderForm) {
          this.$fire({
                    title: "Error",
                    html: "Please complete Metro Configuration",
                    type: "error",
                    timer: 5000,
                })
          this.step--;
        } break;

        case 4 : //ke form ont
        if(! this.gponForm) {
           this.$fire({
                    title: "Error",
                    html: "Please complete GPON Configuration",
                    type: "error",
                    timer: 5000,
                })
          this.step--;
        } break;
        default : break;
      }
      if(this.step > 5){
        this.step = 5;
      }
    },
  },
};
</script>
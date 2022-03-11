<template>
  <div class="card-body">
    <div class="row">
      <div class="col-sm-12">
        <h4 class="card-title mb-0">
          {{ title }}
        </h4>
        Task ID : <span id="task_id" v-html="metro.task_id"></span>
      </div>
      <div id="div_status" class="status" v-html="metro.status"></div>
    </div>
    <!--row-->

    <hr />
    <div class="row mt-4 mb-4">
      <input
        type="hidden"
        name="metro_list_id"
        id="metro_list_id"
        v-model="metro.id"
      />
      <input
        id="node_manufacture"
        name="node_manufacture"
        type="hidden"
      />
      <div class="col-sm-10">
        <div class="form-group row">
          <div class="col-md-6">
            <label for="vcid" class="form-control-label" id="lblvcid">
              VCID
            </label>
            <input
              type="tel"
              name="vcid"
              id="vcid"
              class="form-control"
              v-model="metro.vcid"
              onkeypress="allowNumbersOnly(event)"
              required
            />
            <span id="vcid_access_lbl" class="not-available"></span><br />
            <span id="vcid_backhaul_1_lbl" class="not-available"></span><br />
            <span id="vcid_backhaul_2_lbl" class="not-available"></span>
          </div>
          <div class="col-md-6" id="div_vsiname">
            <label for="vsiname" class="form-control-label"> VSI Name </label>
            <input
              type="text"
              name="vsiname"
              id="vsiname"
              class="form-control"
              v-model="metro.vsiname"
              required
            />
            <span id="vsiname_access_lbl"></span><br />
            <span id="vsiname_backhaul_1_lbl"></span><br />
            <span id="vsiname_backhaul_2_lbl"></span>
          </div>
        </div>

        <div class="row">
          <div
            class="col-md-4"
            style="background: #cdf5fb; padding: 10px"
            id="vcid_node_access"
          >
            <div class="form-group">
              <label for="vlan" class="form-control-label"> Node Access </label>
              <input
                type="hidden"
                name="node_access"
                id="node_access"
                v-model="metro.node_access"
              />
              <select
                class="select2 form-control node"
                id="node_access_name"
                name="node_access_name"
                v-model="metro.node_access_name"
              ></select>
              <span id="node_access_lbl" class="not-available"></span>
              <input
                id="node_access_manufacture"
                name="node_access_manufacture"
                type="hidden"
              />
            </div>
            <div class="form-group">
              <label
                for="port_access"
                class="form-control-label"
                id="port_access_lbl_top"
              >
                Port access
              </label>
              <input
                type="hidden"
                v-model="metro.port_access"
                id="hidden_port_access"
                name="port_access"
              />
              <input
                type="tel"
                id="input_port_access"
                class="form-control port"
                onkeypress="allowChar(event, 'input_port_access')"
              />

              <select
                class="select2 form-control"
                id="select_port_access"
                onchange="checkAccess()"
              ></select>
              <span id="port_access_lbl" class="not-available"></span>
            </div>
            <div class="form-group">
              <label for="vlan_access" class="form-control-label">
                VLAN access
              </label>
              <input
                type="tel"
                name="vlan_access"
                id="vlan_access"
                class="form-control"
                v-model="metro.vlan_access"
                onkeypress="allowNumbersOnly(event)"
                required
                onchange="checkAccess()"
              />
              <span id="vlan_access_lbl" class="not-available"></span>
            </div>
            <div class="form-group">
              <label for="service_description" class="form-control-label">
                Description/Service Access
              </label>
              <textarea
                name="description_access"
                id="description_access"
                class="form-control"
                required
                v-model="metro.description_access"
              ></textarea>
              <span id="description_access_lbl" class="not-available"></span>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label class="form-control-label"> Install QOS? </label>
              </div>
              <div class="col-md-6">
                <select
                  class="form-control qos_install"
                  id="qos_access_install"
                  name="qos_access_install"
                  v-if="metro.qos_access == null"
                >
                  <option value="0" selected>NO</option>
                  <option value="1">YES</option>
                </select>
                <select
                  class="form-control qos_install"
                  id="qos_access_install"
                  name="qos_access_install"
                  v-else
                >
                  <option value="0">NO</option>
                  <option value="1" selected>YES</option>
                </select>
              </div>
            </div>
            <div id="div_qos_access_install" v-if="metro.qos_access !== null">
              <div class="form-group">
                <label for="qos_access" class="form-control-label">
                  QOS access
                </label>
                <select
                  class="form-control qos"
                  id="qos_access"
                  name="qos_access"
                  v-model="metro.qos_access"
                ></select>
                <span id="qos_access_lbl"></span>
              </div>
              <div class="form-group">
                <label for="node_access_scheduler" class="form-control-label">
                  Scheduler access
                </label>
                <select
                  class="select2 form-control"
                  id="node_access_scheduler"
                  name="scheduler_access"
                  v-model="metro.scheduler_access"
                  onchange="checkScheduler('node_access_scheduler')"
                ></select>
                <span id="node_access_scheduler_lbl"></span>
              </div>
            </div>
          </div>
          <div
            class="col-md-4"
            style="background: #bff3c8bb; padding: 10px"
            id="vcid_node_backhaul_1"
          >
            <div class="form-group">
              <label for="node_backhaul_1" class="form-control-label">
                Node Backhaul 1
              </label>
              <input
                type="hidden"
                name="node_backhaul_1"
                id="node_backhaul_1"
                v-model="metro.node_backhaul_1"
              />
              <select
                class="select2 form-control col-8 node"
                id="node_backhaul_1_name"
                name="node_backhaul_1_name"
                v-model="metro.node_backhaul_1_name"
              ></select>
              <span id="node_backhaul_1_lbl" class="not-available"></span>
              <input
                id="node_backhaul_1_manufacture"
                name="node_backhaul_1_manufacture"
                type="hidden"
              />
            </div>
            <div class="form-group">
              <label
                for="port_backhaul_1"
                class="form-control-label"
                id="port_backhaul_1_lbl_top"
              >
                Port backhaul 1
              </label>
              <input
                type="hidden"
                v-model="metro.port_backhaul_1"
                id="hidden_port_backhaul_1"
                name="port_backhaul_1"
              />
              <input
                type="tel"
                id="input_port_backhaul_1"
                class="form-control port"
                onkeypress="allowChar(event, 'input_port_backhaul_1')"
              />
              <select
                class="select2 form-control select-port"
                id="select_port_backhaul_1"
              ></select>
              <span id="port_backhaul_1_lbl"></span>
            </div>
            <div class="form-group">
              <label for="vlan_backhaul_1" class="form-control-label">
                VLAN backhaul 1
              </label>
              <input
                type="tel"
                name="vlan_backhaul_1"
                id="vlan_backhaul_1"
                class="form-control vlan"
                v-model="metro.vlan_backhaul_1"
                onkeypress="allowNumbersOnly(event)"
                required
              />
              <span id="vlan_backhaul_1_lbl"></span>
            </div>
            <div class="form-group">
              <label for="description_backhaul_1" class="form-control-label">
                Description/Service Backhaul 1
              </label>
              <textarea
                name="description_backhaul_1"
                id="description_backhaul_1"
                class="form-control"
                required
                v-model="metro.description_backhaul_1"
              ></textarea>
              <span id="description_backhaul_1_lbl"></span>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label class="form-control-label"> Install QOS? </label>
              </div>
              <div class="col-md-6">
                <select
                  class="form-control qos_install"
                  id="qos_backhaul_1_install"
                  name="qos_backhaul_1_install"
                  v-if="metro.qos_backhaul_1 !== null"
                >
                  <option value="0">NO</option>
                  <option value="1" selected>YES</option>
                </select>
                <select
                  class="form-control qos_install"
                  id="qos_backhaul_1_install"
                  name="qos_backhaul_1_install"
                  v-else
                >
                  <option value="0" selected>NO</option>
                  <option value="1">YES</option>
                </select>
              </div>
            </div>
            <div
              id="div_qos_backhaul_1_install"
              v-id="metro.qos_backhaul_1 != ''"
              style="display: none"
            >
              <div class="form-group">
                <label for="qos_backhaul_1" class="form-control-label">
                  QOS Backhaul 1
                </label>
                <select
                  class="select2 form-control qos"
                  id="qos_backhaul_1"
                  name="qos_backhaul_1"
                ></select>
                <span id="qos_backhaul_1_lbl"></span>
              </div>
              <div class="form-group">
                <label
                  for="node_backhaul_1_scheduler"
                  class="form-control-label"
                >
                  Scheduler Backhaul 1
                </label>
                <select
                  class="select2 form-control"
                  id="node_backhaul_1_scheduler"
                  name="scheduler_backhaul_1"
                  onchange="checkScheduler('node_backhaul_1_scheduler')"
                ></select>
                <span id="node_backhaul_1_scheduler_lbl"></span>
              </div>
            </div>
          </div>
          <div
            class="col-md-4"
            style="background: #e3ebfd; padding: 10px"
            id="vcid_node_backhaul_2"
          >
            <div class="form-group">
              <label for="node_backhaul_2" class="form-control-label">
                Node Backhaul 2
              </label>
              <input
                type="hidden"
                name="node_backhaul_2"
                id="node_backhaul_2"
                v-model="metro.node_backhaul_2"
              />
              <select
                class="select2 form-control node"
                id="node_backhaul_2_name"
                name="node_backhaul_2_name"
              ></select>
              <span id="node_backhaul_2_lbl" class="not-available"></span>
              <input
                id="node_backhaul_2_manufacture"
                name="node_backhaul_2_manufacture"
                type="hidden"
              />
            </div>
            <div class="form-group">
              <label
                for="port_backhaul_2"
                class="form-control-label"
                id="port_backhaul_2_lbl_top"
              >
                Port backhaul 2
              </label>
              <input
                type="hidden"
                name="port_backhaul_2"
                id="hidden_port_backhaul_2"
                v-model="metro.port_backhaul_2"
              />
              <input
                type="tel"
                id="input_port_backhaul_2"
                class="form-control port"
                onkeypress="allowChar(event, 'input_port_backhaul_2')"
              />
              <select
                class="select2 form-control select-port"
                id="select_port_backhaul_2"
              ></select>
              <span id="port_backhaul_2_lbl"></span>
            </div>
            <div class="form-group">
              <label for="vlan_backhaul_2" class="form-control-label">
                VLAN backhaul 2
              </label>
              <input
                type="tel"
                name="vlan_backhaul_2"
                id="vlan_backhaul_2"
                class="form-control vlan"
                v-model="metro.vlan_backhaul_2"
                onkeypress="allowNumbersOnly(event)"
                required
              />
              <span id="vlan_backhaul_2_lbl"></span>
            </div>
            <div class="form-group">
              <label for="description_backhaul_2" class="form-control-label">
                Description/Service Backhaul 2
              </label>
              <textarea
                name="description_backhaul_2"
                id="description_backhaul_2"
                class="form-control"
                required
                v-model="metro.description_backhaul_2"
              ></textarea>
              <span id="description_backhaul_2_lbl"></span>
            </div>
            <div class="form-group row">
              <div class="col-md-6">
                <label class="form-control-label"> Install QOS? </label>
              </div>
              <div class="col-md-6">
                <select
                  class="form-control qos_install"
                  id="qos_backhaul_2_install"
                  name="qos_backhaul_2_install"
                  v-if="metro.qos_backhaul_2 === null"
                >
                  <option value="0" selected>NO</option>
                  <option value="1">YES</option>
                </select>
                <select
                  class="form-control qos_install"
                  id="qos_backhaul_2_install"
                  name="qos_backhaul_2_install"
                  v-else
                >
                  <option value="0">NO</option>
                  <option value="1" selected>YES</option>
                </select>
              </div>
            </div>
            <div
              id="div_qos_backhaul_2_install"
              v-if="metro.qos_backhaul_2 !== null"
            >
              <div class="form-group">
                <label for="qos_backhaul_2" class="form-control-label">
                  QOS Backhaul 2
                </label>
                <select
                  class="select2 form-control qos"
                  id="qos_backhaul_2"
                  name="qos_backhaul_2"
                ></select>
                <span id="qos_backhaul_2_lbl"></span>
              </div>
              <div class="form-group">
                <label
                  for="node_backhaul_2_scheduler"
                  class="form-control-label"
                >
                  Scheduler Backhaul 2
                </label>
                <select
                  class="select2 form-control"
                  id="node_backhaul_2_scheduler"
                  name="scheduler_backhaul_2"
                  onchange="checkScheduler('node_backhaul_2_scheduler')"
                ></select>
                <span id="node_backhaul_2_scheduler_lbl"></span>
              </div>
            </div>
          </div>
        </div>
        <div class="row col-md-12">
          <a
            href="#"
            class="btn btn-md btn-info"
            style="width: 70%; margin-left: 15%"
            id="btn_simpan"
            >Save Configuration</a
          >
        </div>
        <input type="hidden" id="url" value="/panel/metro/store" />
      </div>
      <div class="col-sm-2">
        <a
          href="#"
          class="btn btn-info"
          onclick="checkTask()"
          style="margin: 10px"
          id="btn_check_task"
          >Check Task</a
        >

        <a
          href="#"
          class="btn btn-success"
          onclick="checkTaskId()"
          style="margin: 10px"
          id="btn_check_status"
          v-if="metro.task_id !== null"
          >Check Status</a
        >
      </div>
    </div>
    <div
      class="modal fade"
      id="modal-plans"
      tabindex="-1"
      role="dialog"
      aria-labelledby="exampleModalLongTitle"
      aria-hidden="true"
    >
      <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h3
              class="modal-title"
              id="exampleModalLongTitle"
              style="color: #000"
            >
              TASK PLAN
            </h3>
          </div>
          <div class="modal-body">
            <div id="plans"></div>
          </div>
          <div class="modal-footer">
            <a
              href="#"
              class="btn btn-success"
              onclick="confirmTask()"
              style="margin: 10px"
              id="btn_confirm_task"
              >Confirm Task</a
            >
            <button
              type="button"
              class="btn btn-default"
              data-dismiss="modal"
              aria-label="Close"
            >
              Close
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  created() {
    console.log("metro form called");
    this.bindFunction();
  },
  data() {
    return {
      csrf: document.head.querySelector('meta[name="csrf-token"]').content,
      metro: {
        id: null,
        description_access: null,
        description_backhaul_1: null,
        description_backhaul_2: null,
        port_backhaul_1: null,
        port_backhaul_2: null,
        port_access: null,
        vlan_backhaul_1: null,
        vlan_backhaul_2: null,
        vlan_access: null,
        node_backhaul_1: null,
        node_backhaul_2: null,
        node_access: null,
        node_backhaul_1_name: null,
        node_backhaul_2_name: null,
        node_access_name: null,
        scheduler_backhaul_1: null,
        scheduler_backhaul_2: null,
        scheduler_access: null,
        qos_backhaul_1: null,
        qos_backhaul_2: null,
        qos_access: null,
        vcid: null,
        vsiname: null,
        status: null,
        task_id: null,
      },
      title: "",
      config_id: "",
      first: true,
    };
  },
  methods: {
    save() {
      e.preventDefault();
      let currentObj = this;
      if ($("#description_access").val() == "") {
        setUnavailable(
          "description_access_lbl",
          "description_access",
          "Please entry description access"
        );
      }
      if ($("#description_backhaul_1").val() == "") {
        setUnavailable(
          "description_backhaul_1_lbl",
          "description_backhaul_1",
          "Please entry description backhaul 1"
        );
      }
      if ($("#description_backhaul_2").val() == "") {
        setUnavailable(
          "description_backhaul_2_lbl",
          "description_backhaul_2",
          "Please entry description backhaul 2"
        );
      }
      if ($("#vcid").val() == "") {
        setUnavailable("vcid_access_lbl", "vcid", "Please entry VCID/VSI ID");
        setAvailable("vcid_backhaul_1_lbl", "vcid", "");
        setAvailable("vcid_backhaul_2_lbl", "vcid", "");
      }
      if (
        $("#vsiname").val() == "" &&
        $("#node_manufacture").val() == "HUAWEI"
      ) {
        setUnavailable(
          "vsiname_access_lbl",
          "vsiname",
          "Please entry VSI Name"
        );
        setAvailable("vsiname_backhaul_1_lbl", "vsiname", "");
        setAvailable("vsiname_backhaul_2_lbl", "vsiname", "");
      }
      if ($("#node_access_name").val() == null) {
        setUnavailable(
          "node_access_lbl",
          "node_access_name",
          "Please select node access"
        );
      }
      if (
        $("#node_manufacture").val() == "HUAWEI" &&
        $("#select_port_access").val() == null
      ) {
        setUnavailable(
          "port_access_lbl",
          "select_port_access",
          "Please select port access"
        );
      }
      if (
        $("#node_manufacture").val() == "ALCATEL-LUCENT" &&
        $("#input_port_access").val() == null
      ) {
        setUnavailable(
          "port_access_lbl",
          "input_port_access",
          "Please entry port access"
        );
      }
      if ($("#node_backhaul_1_name").val() == null) {
        setUnavailable(
          "node_backhaul_1_lbl",
          "node_backhaul_1_name",
          "Please select node backhaul 1"
        );
      }
      if ($("#node_backhaul_2_name").val() == null) {
        setUnavailable(
          "node_backhaul_2_lbl",
          "node_backhaul_2_name",
          "Please select node backhaul 2"
        );
      }
      if ($("#vlan_access").val() == "") {
        setUnavailable(
          "vlan_access_lbl",
          "vlan_access",
          "Please entry VLAN access"
        );
      }
      if ($("#hidden_port_access").val() == "") {
        setUnavailable(
          "port_access_lbl",
          "input_port_access",
          "Please entry port access"
        );
      }
      var url = $("#url").val();
      var formData = new FormData($("#form_data")[0]);
      var mvar = "";
      $("#validasi_content").empty();
      $("span.not-available").each(function () {
        $("#validasi_content").append("<li>" + $(this).html() + "</li>");
        mvar += $(this).html();
      });
      if (mvar != "") {
        $("#modal_validation").modal("show");
      }
      if (mvar == "") {
        $.ajax({
          url: url,
          type: "POST",
          dataType: "JSON",
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          headers: {
            "X-CSRF-TOKEN": this.csrf,
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
              currentObj.bindValue(response);
              currentObj.$parent.metroForm = true;
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
      }
    },
    bindValue(response) {
      if(response.data.metro.id != "") {
        this.$parent.metroForm = true;
      }
      this.metro.id = response.data.metro.id;
      this.metro.description_access = response.data.metro.description_access;
      this.metro.description_backhaul_1 =
        response.data.metro.description_backhaul_1;
      this.metro.description_backhaul_2 =
        response.data.metro.description_backhaul_2;
      this.metro.port_backhaul_1 = response.data.metro.port_backhaul_1;
      this.metro.port_backhaul_2 = response.data.metro.port_backhaul_2;
      this.metro.port_access = response.data.metro.port_access;
      $("#input_port_access").val(response.data.metro.port_access);
      $("#input_port_backhaul_1").val(response.data.metro.port_backhaul_1);
      $("#input_port_backhaul_2").val(response.data.metro.port_backhaul_2);
      this.metro.vlan_backhaul_1 = response.data.metro.vlan_backhaul_1;
      this.metro.vlan_backhaul_2 = response.data.metro.vlan_backhaul_2;
      this.metro.vlan_access = response.data.metro.vlan_access;
      this.metro.node_backhaul_1 = response.data.metro.node_backhaul_1;
      this.metro.node_backhaul_2 = response.data.metro.node_backhaul_2;
      this.metro.node_access = response.data.metro.node_access;
      this.metro.node_backhaul_1_name =
        response.data.metro.node_backhaul_1_name;
      this.metro.node_backhaul_2_name =
        response.data.metro.node_backhaul_2_name;
      this.metro.node_access_name = response.data.metro.node_access_name;
      this.metro.scheduler_backhaul_1 =
        response.data.metro.scheduler_backhaul_1;
      this.metro.scheduler_backhaul_2 =
        response.data.metro.scheduler_backhaul_2;
      this.metro.scheduler_access = response.data.metro.scheduler_access;
      this.metro.qos_backhaul_1 = response.data.metro.qos_backhaul_1;
      this.qos_backhaul_2 = response.data.metro.qos_backhaul_2;
      this.metro.qos_access = response.data.metro.qos_access;
      this.metro.vcid = response.data.metro.vcid;
      this.metro.vsiname = response.data.metro.vsiname;
      this.metro.status = response.data.metro.status;
      this.metro.task_id = response.data.metro.task_id;
      var $newOption = $("<option selected='selected'></option>")
        .val(response.data.metro.node_access_name)
        .text(response.data.metro.node_access_name);
      var $newOption2 = $("<option selected='selected'></option>")
        .val(response.data.metro.node_backhaul_1_name)
        .text(response.data.metro.node_backhaul_1_name);
      var $newOption3 = $("<option selected='selected'></option>")
        .val(response.data.metro.node_backhaul_2_name)
        .text(response.data.metro.node_backhaul_2_name);
      $("#node_access_name").append($newOption).trigger("change");
      $("#node_backhaul_1_name").append($newOption2).trigger("change");
      $("#node_backhaul_2_name").append($newOption3).trigger("change");

      var $newOption4 = $("<option selected='selected'></option>")
        .val(response.data.metro.port_access)
        .text(response.data.metro.port_access);
      var $newOption5 = $("<option selected='selected'></option>")
        .val(response.data.metro.port_backhaul_1)
        .text(response.data.metro.port_ackhaul_2);
      var $newOption6 = $("<option selected='selected'></option>")
        .val(response.data.metro.port_backhaul_2)
        .text(response.data.metro.port_backhaul_2);
      $("#select_port_access").append($newOption4).trigger("change");
      $("#select_port_backhaul_1").append($newOption5).trigger("change");
      $("#select_port_backhaul_2").append($newOption6).trigger("change");

      var $newOption7 = $("<option selected='selected'></option>")
        .val(response.data.metro.qos_access)
        .text(response.data.metro.qos_access);
      var $newOption8 = $("<option selected='selected'></option>")
        .val(response.data.metro.qos_backhaul_1)
        .text(response.data.metro.qos_backhaul_1);
      var $newOption9 = $("<option selected='selected'></option>")
        .val(response.data.metro.qos_backhaul_2)
        .text(response.data.metro.qos_backhaul_2);

      //$("#qos_access").append($newOption7).trigger("change");
      //$("#qos_backhaul_1").append($newOption8).trigger("change");
      //$("#qos_backhaul_2").append($newOption9).trigger("change");

      var $newOption10 = $("<option selected='selected'></option>")
        .val(response.data.metro.scheduler_access)
        .text(response.data.metro.scheduler_access);
      var $newOption11 = $("<option selected='selected'></option>")
        .val(response.data.metro.scheduler_backhaul_1)
        .text(response.data.metro.scheduler_backhaul_1);
      var $newOption12 = $("<option selected='selected'></option>")
        .val(response.data.metro.scheduler_backhaul_2)
        .text(response.data.metro.scheduler_backhaul_2);
      //$("#scheduler_access").append($newOption10).trigger("change");
      //$("#scheduler_backhaul_1").append($newOption11).trigger("change");
      //$("#scheduler_backhaul_2").append($newOption12).trigger("change");
    },
    bindFunction() {
      let currentObj = this;
      axios
        .get(
          "/panel/configuration/config-metro?config_id=" + currentObj.$parent.config_id
        )
        .then((response) => {
          $("#btn_simpan").on("click", function () {
            currentObj.save();
          });
          if (
            currentObj.$parent.config_id != 0 &&
            response.data.metro.task_id != ""
          ) {
            checkTaskEvery5sec();
            checkAll();
          }
          select2AutoSuggest("#node_access_name", "node");
          select2AutoSuggest("#node_backhaul_1_name", "node");
          select2AutoSuggest("#node_backhaul_2_name", "node");

          $(".qos_install").on("change", function () {
            var name = $(this).attr("id");
            if ($(this).val() == 1) {
              $("#div_" + name).show();
            } else {
              $("#div_" + name).hide();
            }
          });
          $("#description_access").on("change", function () {
            checkDescription("description_access", "description_access_lbl");
          });
          $("#description_backhaul_1").on("change", function () {
            checkDescription(
              "description_backhaul_1",
              "description_backhaul_1_lbl"
            );
          });
          $("#description_backhaul_2").on("change", function () {
            checkDescription(
              "description_backhaul_2",
              "description_backhaul_2_lbl"
            );
          });
          $("#vcid").on("change", function () {
            checkAccess();
            checkBackhaul(1, $(this).attr("id"));
            checkBackhaul(2, $(this).attr("id"));
          });
          $("#vsiname").on("change", function () {
            checkAccess();
            checkBackhaul(1, $(this).attr("id"));
            checkBackhaul(2, $(this).attr("id"));
          });
          $(".node").on("change", function () {
            var node_id = $(this).attr("id");
            var lbl = node_id.replace("name", "lbl");
            var txt = node_id.replace("_name", "");
            checkNode(node_id, lbl, txt);

            var name = node_id.replace("node_", "").replace("_name", "");
            var port = "port_" + name;
            var vlan = "vlan_" + name;
            var portlbl = port + "_lbl";
            var vlanlbl = vlan + "_lbl";

            checkQosBefore("qos_" + name, "qos_" + name + "_lbl", node_id);
          });

          $(".vlan").on("change", function () {
            var name = $(this).attr("id").replace("vlan_", "");
            if (name.includes("backhaul")) {
              checkBackhaul(name.split("_")[1], $(this).attr("id"));
            } else {
              checkAccess();
            }
          });
          $(".qos").on("change", function () {
            var name = $(this).attr("id");
            var node_id = "node_" + name.replace("qos_", "") + "_name";
            checkQosBefore(name, name + "_lbl", node_id);
          });

          $(".port").on("change", function () {
            console.log("tes change port");
            var name = $(this)
              .attr("id")
              .replace("port_", "")
              .replace("select_", "")
              .replace("input_", "");
            $("input[name=port_" + name + "]").val($(this).val());
            checkPort(name, $(this).attr("id"));
          });

          $(".select-port").on("change", function () {
            var name = $(this)
              .attr("id")
              .replace("port_", "")
              .replace("select_", "")
              .replace("input_", "");
            $("input[name=port_" + name + "]").val($(this).val());
            checkPort(name, $(this).attr("id"));
          });
          currentObj.bindValue(response);
        });
    },
  },
};
window.checkQosBefore = function(id, lbl, node) {
    var name = id.replace('qos_', '');
    var qosType = "";
    if (id.includes('access')) {
        qosType = "access";
    } else if (id.includes('backhaul_1')) {
        qosType = "backhaul 1";
    } else {
        qosType = "bakhaul 2";
    }
    var manufacture = $('#node_' + name + '_manufacture').val();
    if ($('#qos_' + name + '_install').val() == 1) {
        $.ajax({
            url: "panel/metro/check-qos" + '?node=' + $('#' + node).val() +
                '&qos=' + $('#' + id).val() +
                '&manufacture=' + manufacture,
            contentType: 'application/json',
            dataType: 'json',
            beforeSend: function() {
                var div = '<div class="loading-select" id="div_' + id + '"></div>';
                $('#' + id).prev().prev().append(div);
            },
            success: function(response) {
                if (response.status == 200) {
                    setAvailable(lbl, id, response.message);
                } else {
                    setUnavailable(lbl, id, "Qos " + qosType + " not available");
                }
            },
            complete: function() {
                $('#div_' + id).remove();
            }
        });
        setAvailable(lbl, id, "");
    }
}

window.checkBackhaul1Access = function() {
    if ($("#node_access_name").val() == $('#node_backhaul_1_name').val()) {
        if ($('#node_manufacture').val() == 'HUAWEI') {
            port2 = $("#select_port_backhaul_1").val();
            port = $("#select_port_access").val();
        } else {
            port2 = $("#input_port_backhaul_1").val();
            port = $("#input_port_access").val();
        }
        if (port2 == port) {
            return false;
        }
    }
    return true;
}

window.checkBackhaul1Backhaul2 = function() {
    if ($("#node_backhaul_1_name").val() == $('#node_backhaul_2_name').val()) {
        if ($('#node_manufacture').val() == 'HUAWEI') {
            port = $("#select_port_backhaul_1").val();
            port2 = $("#select_port_backhaul_2").val();
        } else {
            port = $("#input_port_backhaul_1").val();
            port2 = $("#input_port_backhaul_2").val();
        }
        if (port2 == port) {
            return false;
        }
    }
    return true;
}

window.checkBackhaul2Access = function() {
    if ($("#node_backhaul_2_name").val() == $('#node_access_name').val()) {
        if ($('#node_manufacture').val() == 'HUAWEI') {
            port = $("#select_port_backhaul_2").val();
            port2 = $("#select_port_access").val();
        } else {
            port = $("#input_port_backhaul_2").val();
            port2 = $("#input_port_access").val();
        }
        if (port2 == port) {
            return false;
        }
    }
    return true;
}

window.checkPortValue = function() {
    var cBackhaul1Backhaul2 = checkBackhaul1Backhaul2();
    var cBackhaul1Access = checkBackhaul1Access();
    var cBackhaul2Access = checkBackhaul2Access();
    if ($('#node_manufacture').val() == 'HUAWEI') {
        setAvailable("port_backhaul_2_lbl", "select_port_backhaul_2", "Port backhaul 2 available");
        setAvailable("port_backhaul_1_lbl", "select_port_backhaul_1", "Port backhaul 1 available");
        setAvailable("port_access_lbl", "select_port_access", "Port access available");
    } else {
        setAvailable("port_backhaul_2_lbl", "input_port_backhaul_2", "Port backhaul 2 available");
        setAvailable("port_backhaul_1_lbl", "input_port_backhaul_1", "Port backhaul 1 available");
        setAvailable("port_access_lbl", "input_port_access", "Port access available");
    }

    if (!cBackhaul1Backhaul2) {
        if ($('#node_manufacture').val() == 'HUAWEI') {
            setUnavailable("port_backhaul_2_lbl", "select_port_backhaul_2",
                "Port backhaul 2 can not be same as port backhaul 2");
            setUnavailable("port_backhaul_1_lbl", "select_port_backhaul_1",
                "Port backhaul 1 can not be same as port backhaul 2");
        } else {
            setUnavailable("port_backhaul_2_lbl", "input_port_backhaul_2",
                "Port backhaul 2 can not be same as port backhaul 1");
            setUnavailable("port_backhaul_1_lbl", "input_port_backhaul_1", "Port backhaul 1 can not be same as port backhaul 2");
        }
    }
    if (!cBackhaul1Access) {
        if ($('#node_manufacture').val() == 'HUAWEI') {
            setUnavailable("port_access_lbl", "select_port_access", "Port access can not be same as port backhaul 1");
            setUnavailable("port_backhaul_1_lbl", "select_port_backhaul_1",
                "Port backhaul 1 can not be same as port access");
        } else {
            setUnavailable("port_access_lbl", "input_port_access", "Port access can not be same as port backhaul 1");
            setUnavailable("port_backhaul_1_lbl", "input_port_backhaul_1",
                "Port backhaul 1 can not be same as port access");
        }
    }
    if (!cBackhaul2Access) {
        if ($('#node_manufacture').val() == 'HUAWEI') {
            setUnavailable("port_backhaul_2_lbl", "select_port_backhaul_2",
                "Port backhaul 2 can not be same as port access");
            setUnavailable("port_access_lbl", "select_port_access", "Port access can not be same as port backhaul 2");
        } else {
            setUnavailable("port_backhaul_2_lbl", "input_port_backhaul_2",
                "Port backhaul 2 can not be same as port access");
            setUnavailable("port_access_lbl", "input_port_access", "Port access can not be same as port backhaul 2");
        }
    }
}

window.checkPort = function(name, id) {
    var port = $('#'+id).val(),
        backhaul = "false",
        node = '';
    if (name.includes("backhaul")) {
        backhaul = "true";
    }


    $.ajax({
        url: "/panel/metro/check-port" + '?port=' + port +
            '&name=' + $("#node_" + name + '_name').val() + '&backhaul=' + backhaul,
        dataType: 'json',
        beforeSend: function() {
            $('#select_port_' + name).addClass('loading');
            $('#input_port_' + name).addClass('loading');
        },
        success: function(response) {
            if (response.status == 200) {
                if (response.parent != port) {
                    $('#port_' + name + '_lbl_top').html('Port ' + name.replace("_", " ") + ' : ' + port +
                        ' is a member of ' + response.parent)
                } else {
                    $('#port_' + name + '_lbl_top').html('Port ' + name.replace("_", " "));
                }

                $("#select_port_" + name).val(response.parent);
                $("#input_port_" + name).val(response.parent);
                $("#hidden_port_" + name).val(response.parent);
            } else {
                $('#port_' + name + '_lbl_top').html('Port ' + name.replace("_", " "));
                $("#hidden_port_" + name).val(port);
            }
        },
        complete: function() {
            $('#select_port_' + name).removeClass('loading');
            $('#input_port_' + name).removeClass('loading');
            checkPortValue();
        }
    });
}
window.checkBackhaul = function(sec, id) {
    var manufacture = $('#node_manufacture').val();
    var port = "";
    var vlan = $('#vlan_backhaul_' + sec).val();
    var vcid = $('#vcid').val();
    var node = $('#node_backhaul_' + sec + '_name').val();
    var description = $('#description_backhaul_' + sec).val();
    if (manufacture == "HUAWEI") {
        port = $('#select_port_backhaul_' + sec).val();
    } else {
        port = $('#input_port_backhaul_' + sec).val();
    }
    $('#hidden_port_backhaul_' + sec).val(port);
    if (port == "") {
        setOptional('port_backhaul_' + sec + '_lbl', 'input_port_backhaul_' + sec, "Please entry port backhaul " + sec);
        setOptional('port_backhaul_' + sec + '_lbl', 'select_port_backhaul_' + sec, "Please entry port backhaul " +
            sec);
    }
    if (vlan == "") {
        setOptional('vlan_backhaul_' + sec + '_lbl', 'vlan_backhaul_' + sec, "Please entry VLAN backhaul " + sec);
    }
    if (vlan.length < 3 && vlan != "") {
        setUnavailable('vlan_backhaul_' + sec + '_lbl', 'vlan_backhaul_' + sec, "VLAN backhaul " + sec +
            " min 3 characters");
    }
    if (vcid == "") {
        setOptional('vcid_backhaul_' + sec + '_lbl', 'vcid', "Please entry VCID/VSI ID backhaul " + sec);
    }
    if (vcid.length < 4) {
        setUnavailable('vcid_backhaul_' + sec + '_lbl', 'vcid', "VCID/VSI ID backhaul " + sec + " min 4 characters");
    }
    if (node == "" || node == null) {
        setUnavailable('vcid_backhaul_' + sec + '_lbl', 'vcid', "Please select node backhaul " + sec);
        setUnavailable('node_backhaul_' + sec + '_lbl', 'node_backhaul_' + sec + '_name',
            "Please select node backhaul " + sec);
    }
    if (description == "") {
        setUnavailable('description_backhaul_' + sec + '_lbl', 'description_backhaul_' +
            sec, "Please entry description/service backhaul " + sec);
    }
    if (description.length < 6 && description != "") {
        setUnavailable('description_backhaul_' + sec + '_lbl', 'description_backhaul_' +
            sec, "Description/service backhaul " + sec + " min 6 characters");
    }

    var div = '<div class="loading-select" id="div_' + id + '"></div>';
    $.ajax({
        url: "/panel/metro/check-backhaul" + '?name=' + node +
            '&vlan=' + $('#vlan_backhaul_' + sec).val() +
            '&port=' + port +
            '&vcid=' + $('#vcid').val() +
            '&vsiname=' + $('#vsiname').val() +
            '&manufacture=' + manufacture,
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
            //$('#' + id).prev().prev().append(div);
        },
        success: function(response) {
            if (node != "") {
                if (manufacture == "HUAWEI") {
                    var vcidLbl = "VSI ID";
                } else {
                    var vcidLbl = "VCID";
                }
                var msgVcid = vcidLbl + " backhaul " + sec;
                if (response.statusVcid != 200 && vcid != "" && vcid.length > 3 && (node == "" || node ==
                        null)) {
                    setAvailable('vcid_backhaul_' + sec + '_lbl', 'vcid', vcidLbl + " backhaul " + sec +
                        " available");
                } else if (response.statusVcid == 200 && vcid != "" && vcid.length > 3 && (node == "" ||
                        node == null)) {
                    msgVcid += " configured ";
                    setAvailable('vcid_backhaul_' + sec + '_lbl', 'vcid', msgVcid);
                }

                if (response.statusPort == 200 && port != "") {
                    //if (response.vcid == vcid) {
                    setAvailable('port_backhaul_' + sec + '_lbl', 'input_port_backhaul_' + sec,
                        "Port and VLAN " + response
                        .interface + " already configured with " + vcidLbl + " = " + response.vcid);
                    setAvailable('port_backhaul_' + sec + '_lbl', 'select_port_backhaul_' + sec,
                        "Port and VLAN " + response
                        .interface + " already configured with " + vcidLbl + " = " + response.vcid);
                    setAvailable('vcid_backhaul_' + sec + '_lbl', 'vcid', msgVcid + " configured with " +
                        response.interface);
                    $('#vcid').val(response.vcid);

                    if (manufacture == 'HUAWEI') {
                        $('#vsiname').val(response.vsiname);
                        setAvailable('vsiname_backhaul_' + sec + '_lbl', 'vsiname', "VSI NAME backhaul " +
                            sec + " found");
                    }
                    //checkAccess();
                } else if (response.statusPort != 200 && port != "") {
                    setAvailable('port_backhaul_' + sec + '_lbl', 'input_port_backhaul_' + sec,
                        "Port backhaul " + sec + " available");
                    setAvailable('port_backhaul_' + sec + '_lbl', 'select_port_backhaul_' + sec,
                        "Port backhaul " + sec + " available");

                    if (vcid != "" && vcid.length >= 4) {
                        setAvailable('vcid_backhaul_' + sec + '_lbl', 'vcid', msgVcid + " available");
                        setAvailable('vsiname_backhaul_' + sec + '_lbl', 'vsiname', "VSI NAME backhaul " +
                            sec + " available");
                    }
                }
                if (response.statusVlan == 200 && vlan != "" && vlan.length > 2) {
                    setAvailable('vlan_backhaul_' + sec + '_lbl', 'vlan_backhaul_' + sec, "Port and VLAN " +
                        response.interface +
                        " already configured with " + vcidLbl + " = " + response.vcid);
                    if (response.description_subinterface != "") {
                        $('#description_backhaul_' + sec).val(response.description_subinterface);
                        setAvailable("description_backhaul_" + sec + "_lbl", "description_backhaul_" + sec,
                            "Description/service backhaul " + sec + " OK");
                    } else {
                        $('#description_backhaul_' + sec).val("TELKOMSEL NODE-B " + vlan);
                        setAvailable("description_backhaul_" + sec + "_lbl", "description_backhaul_" + sec,
                            "New description/service backhaul " + sec + " OK");
                    }
                } else if (response.statusVlan != 200 && vlan != "" && vlan.length > 2) {
                    setAvailable('vlan_backhaul_' + sec + '_lbl', 'vlan_backhaul_' + sec,
                        "VLAN access available");
                    $('#description_backhaul_' + sec).val("TELKOMSEL NODE-B " + vlan);
                    setAvailable("description_backhaul_" + sec + "_lbl", "description_backhaul_" + sec,
                        "New description/service backhaul " + sec + " OK");
                }
            }
            // $('#div_'+id).parent().remove();
        },
        complete: function(response) {
            if (response.responseJSON.vcid != vcid && vcid != "" && response.responseJSON.statusVlan ==
                200) {
                Toast.fire({
                    icon: 'warning',
                    title: 'VCID/VSI ID' + ' access changed from ' + vcid + ' to ' + response
                        .responseJSON.vcid
                });
            }
            if($('#node_manufacture') == "HUAWEI"){
                checkPort("backhaul_" + sec, "select_port_backhaul_" + sec);
            } else {
                checkPort("backhaul_" + sec, "input_port_backhaul_" + sec);
            }
        }
    });
}

window.checkAccess = function() {
    var manufacture = $('#node_manufacture').val();
    var port = "";
    var vlan = $('#vlan_access').val();
    var vcid = $('#vcid').val();
    var node = $('#node_access_name').val();
    if (manufacture == "HUAWEI") {
        port = $('#select_port_access').val();
    } else {
        port = $('#input_port_access').val();
    }
    $('#hidden_port_access').val(port);
    if (port == "") {
        setUnavailable('port_access_lbl', 'input_port_access', "Please entry port access");
        setUnavailable('port_access_lbl', 'select_port_access', "Please entry port access");
    }
    if (vlan == "") {
        setUnavailable('vlan_access_lbl', 'vlan_access', "Please entry VLAN access");
    }
    if (vlan.length < 3) {
        setUnavailable('vlan_access_lbl', 'vlan_access', "VLAN access min 3 characters");
    }
    if (vcid == "") {
        setUnavailable('vcid_access_lbl', 'vcid', "Please entry VCID/VSI ID access");
    }
    if (vcid.length < 4) {
        setUnavailable('vcid_access_lbl', 'vcid', "VCID/VSI ID access min 4 characters");
    }
    if (node == "" || node == null) {
        setUnavailable('vcid_access_lbl', 'vcid', "Please select node access");
        setUnavailable('node_access_lbl', 'node_access_name', "Please select node access");
    }

    $.ajax({
        url: "/panel/metro/check-access" + '?name=' + node +
            '&vlan=' + $('#vlan_access').val() +
            '&port=' + port +
            '&vcid=' + $('#vcid').val() +
            '&vsiname=' + $('#vsiname').val() +
            '&manufacture=' + manufacture,
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
            //    var div = '<div class="loading-select" id="div_' + id + '"></div>';
            //    $('#' + id).prev().prev().append(div);
        },
        success: function(response) {
            if (node != "") {
                if (manufacture == "HUAWEI") {
                    var vcidLbl = "VSI ID";
                } else {
                    var vcidLbl = "VCID";
                }
                if (response.statusVcid != 200 && vcid != "" && vcid.length > 3) {
                    setAvailable('vcid_access_lbl', 'vcid', "New " + vcidLbl + " access");
                } else if (response.statusVcid == 200 && vcid != "" && vcid.length > 3) {
                    var msgVcid = vcidLbl + " access already configured with " + response.interfaces.total +
                        " interfaces";
                    if (response.statusPort == 200) {
                        msgVcid += ", Port " + port + " and VLAN " + vlan + " not available";
                    } else {
                        msgVcid += ", Port " + port + " and VLAN " + vlan + " available";
                    }
                }

                if (response.statusPort == 200 && port != "") {
                    if (response.vcid == vcid) {
                        setUnavailable('port_access_lbl', 'input_port_access', "Port and VLAN " + response
                            .interface + " already configured with entered " + vcidLbl + " = " +
                            response.vcid + ", please use different VCID or PORT");
                        setUnavailable('port_access_lbl', 'select_port_access', "Port and VLAN " + response
                            .interface + " already configured with entered " + vcidLbl + " = " +
                            response.vcid + ", please use different VCID or PORT");
                        setUnavailable('vcid_access_lbl', 'vcid', msgVcid);
                    } else {
                        setAvailable('port_access_lbl', 'input_port_access', "Port and VLAN " + response
                            .interface + " already configured with " + vcidLbl + " = " + response.vcid);
                        setAvailable('port_access_lbl', 'select_port_access', "Port and VLAN " + response
                            .interface + " already configured with " + vcidLbl + " = " + response.vcid);
                        setAvailable('vcid_access_lbl', 'vcid', msgVcid);
                    }
                } else if (response.statusPort != 200 && port != "") {
                    setAvailable('port_access_lbl', 'input_port_access', "Port access available");
                    setAvailable('port_access_lbl', 'select_port_access', "Port access available");
                    setAvailable('vcid_access_lbl', 'vcid', msgVcid);
                }
                if (response.statusVlan == 200 && vlan != "" && vlan.length > 2) {
                    if (response.vcid == vcid) {
                        setUnavailable('vlan_access_lbl', 'vlan_access', "Port and VLAN " + response
                            .interface +
                            " already configured with entered " + vcidLbl + " = " + vcid +
                            ", please use different VCID or VLAN!");
                    } else {
                        setAvailable('vlan_access_lbl', 'vlan_access', "Port and VLAN " + response
                            .interface +
                            " already configured with " + response.vcid);
                    }
                } else if (response.statusVlan != 200 && vlan != "" && vlan.length > 2) {
                    setAvailable('vlan_access_lbl', 'vlan_access', "VLAN access available");
                }
                if (response.description_subinterface != "" && (response.vcid != vcid)) {
                    $('#description_access').val("TELKOMSEL NODE-B ACCESS");
                    setAvailable("description_access_lbl", "description_access",
                        "New description/service access");
                } else if (response.description_subinterface != "" && (response.vcid == vcid)) {
                    $('#description_access').val(response.description_subinterface);
                    setAvailable("description_access_lbl", "description_access",
                        "Description/service access OK");
                } else {
                    $('#description_access').val("TELKOMSEL NODE-B ACCESS");
                    setAvailable("description_access_lbl", "description_access",
                        "New description/service access");
                }
            }
        },
        complete: function() {
            if($('#node_manufacture') == "HUAWEI"){
                checkPort("access", "select_port_access");
            } else {
                checkPort("access", "input_port_access");
            }
        }
    });
}
window.checkNode = function(id, lbl, textbox, oldScheduler = '') {
    var name = id.replace('_name', '').replace('node_', '');
    $.ajax({
        url: "/panel/metro/check-node" + '?name=' + $('#' + id).val(),
        contentType: 'application/json',
        dataType: 'json',
        beforeSend: function() {
            var div = '<div class="loading-select" id="div_' + id + '"></div>';
            $('#' + id).prev().prev().append(div);
        },
        success: function(response) {
            if (response.status == 200) {
                if ($('#node_manufacture').val() == "") {
                    $('#node_manufacture').val(response.manufacture);
                }
                if ($('#node_manufacture').val() == response.manufacture) {
                    setAvailable(lbl, id, "IP : " + response.ip + ", manufacture : " + response
                        .manufacture);
                    $('#' + textbox).val(response.ip);

                    $('#' + id.replace('name', '') + 'manufacture').val(response.manufacture);

                    if (response.manufacture == "HUAWEI") {
                        $('#select_port_' + name).show();
                        select2Node('#select_port_' + name, '#node_' + name + '_name', 'port-huawei',
                            response
                            .manufacture);
                        $('#input_port_' + name).hide();
                        $('#node_' + name + '_scheduler').hide();
                        $('#node_' + name + '_scheduler').val('');
                        $('#div_vsiname').show();
                        $('#lblvcid').text('VSI ID');
                    } else {
                        $('#select_port_' + name).hide();
                        $('#input_port_' + name).show();
                        $('#node_' + name + '_scheduler').show();
                        $('#node_' + name + '_scheduler').val();
                        $('#div_vsiname').hide();
                        $('#vsiname').val('');
                        $('#lblvcid').text('VCID');
                    }
                    $('#port_' + name + '_lbl_top').html('Port ' + name.replace("_", " "));
                    select2Node('#qos_' + name, '#node_' + name + '_name', 'qos', response.manufacture);
                } else {
                    setUnavailable(lbl, id, "Cannot choose diferent manufacture!");
                    $('#select_port_' + name).hide();
                    $('#port_' + name).hide();
                    $('#' + textbox).val('');
                    $('#' + id.replace('name', '') + 'manufacture').val('');
                }
            } else {
                setUnavailable(lbl, id, "Node " + name + " unavailable");
                $('#select_port_' + name).hide();
                $('#port_' + name).hide();
                $('#' + textbox).val('');
                $('#' + id.replace('name', '') + 'manufacture').val('');
            }
            if ($('#' + id.replace('name', 'scheduler')).val() != "") {
                loadScheduler($('#' + id).val(), id.replace('name', 'scheduler'), oldScheduler);
            } else {
                loadScheduler($('#' + id).val(), id.replace('name', 'scheduler'));
            }
            if (name == "access") {
                checkAccess();    
            } else {
                checkBackhaul(name.split("_")[1], id);
            }
            //checkport(name);
        },
        complete: function() {
            $('#div_' + id).remove();
        }
    });
}
window.checkDescription = function(id, lbl) {
    $('#' + id).addClass('loading');
    var name = id.replace('description_', '');
    if ($('#' + id).val().length < 6) {
        setUnavailable(lbl, id, "Description Min 6 character");
    } else {
        setAvailable(lbl, id, "Description " + name + " OK");
    }
    $('#' + id).removeClass('loading');
}
window.checkAll = function() {
    $('#div_vsiname').hide();
    $('#select_port_access').hide();
    $('#select_port_backhaul_1').hide();
    $('#select_port_backhaul_2').hide();
    if ($('#div_status').text().includes("submitted") || $('#div_status').text().includes("pending")) {
        checkNode("node_access_name", "node_access_lbl", "node_access");
        checkNode("node_backhaul_1_name", "node_backhaul_1_lbl", "node_backhaul_1");
        checkNode("node_backhaul_2_name", "node_backhaul_2_lbl", "node_backhaul_2");
    }
}
window.loadScheduler = function(node, id, oldScheduler = '') {
    var div = '<div class="loading-select" id="div_' + id + '"></div>';
    $('#' + id).prev().append(div);
    $.ajax({
        url: "/panel/select2/scheduler" + '?node=' + node,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            $('#' + id + ' option').remove();
            var option = "";
            for (var i = 0; i < response.length; i++) {
                option += "<option value='" + response[i].name + "'>" + response[i].name + "</option>";
            }
            $('#' + id).append(option);
            if (oldScheduler != '') {
                $('#' + id).val(oldScheduler);
            }
            checkScheduler(id);
            $('#div_' + id).remove();
        }
    });
}

window.confirmTask = function() {
    var task_id = $('#task_id').text();
    if (confirm("Apakah Anda yakin?")) {
        $.ajax({
            url: "/panel/metro/confirm-task" + '?task_id=' + task_id,
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                alert('confirmed!');
            }
        });
    }
}
window.checkTask = function() {
    var task_id = $('#task_id').text();
    $.ajax({
        url: "/panel/metro/check-task" + '?task_id=' + task_id,
        contentType: 'application/json',
        dataType: 'json',
        success: function(response) {
            var message = "<div class='row'>";
            for (var i = 0; i < response.length; i++) {
                message += '<div class="col-md-4">' +
                    '<div class="flex terminal-title">' +
                    '<div class="flex terminal-button">' +
                    '<div class="rounded-full w-4 h-4 bg-red mr-2"></div>' +
                    '<div class="rounded-full w-4 h-4 bg-green mr-2"></div>' +
                    '<div class="rounded-full w-4 h-4 bg-yellow mr-2"></div>' + response[i].node +
                    '</div></div>';
                message += response[i].plan[0].replace(/\n/g, '<br />');
                message += "</div><br/>";

            }
            message += "</div>";
            $('#plans').html(message);
            $('#modal-plans').modal('show');
        }
    });
}
window.checkScheduler = function(id) {
    if ($('#' + id).val() != '') {
        setAvailable(id + '_lbl', id, "Scheduler is set");
    } else {
        setOptional(id + '_lbl', id, "Please choose a scheduler");
    }
}

window.checkTaskId = function() {
    var task_id = $('#task_id').text();
    if ($('#task_id').text().trim() == '') {

        $('#btn_confirm_task').hide();
        $('#btn_check_task').hide();
    } else {
        $.ajax({
            url: "/panel/metro/status-task" + '?task_id=' + task_id,
            contentType: 'application/json',
            dataType: 'json',
            success: function(response) {
                $('#div_status').html(response.status);
                if (response.status != 'submitted' && response.status != 'pending') {
                    $('input').attr('readonly', true);
                    $('textarea').attr('readonly', true);
                    $('.select2').attr('disabled', true);
                } else {
                    $('#btn_confirm_task').show();
                }
                $('#btn_check_task').show();
            }
        })

    }
}
window.select2Node = function(selector, node, controller, manufacture = 'ALCATEL-LUCENT') {
    $(selector).select2({
        placeholder: '-- Pilih --',
        minimumInputLength: 2,
        cache: true,
        theme: 'bootstrap4',
        ajax: {
            url: '/panel/select2' + '/' + controller + '?manufacture=' + manufacture,
            type: 'GET',
            dataType: 'JSON',
            //delay: 250,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            data: function(params) {
                var query = {
                    search: params.term,
                    manufacture: manufacture,
                    node: $(node).val(),
                }
                return query;
            },
            processResults: function(data) {
                return {
                    results: data.items
                }
            }
        }
    });
}
window.checkTaskEvery5sec = function() {
    checkTaskId();
    if ($('#div_status').text() != "closed" && $('#div_status').text() != "submitted" && $('#div_status').text() !=
        "pending") {
        setTimeout(checkTaskEvery5sec, 5000);
    }
}
</script>
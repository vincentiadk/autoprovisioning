<template>
  <div class="card-body">
    <input type="hidden" id="url" value="/panel/dba-profile/store" />
    <input type="hidden" name="olt_site_id" v-model="olt_site_id" />
    <div class="row">
      <div class="col-sm-5">
        <h4 class="card-title mb-0">DBA Profile</h4>
      </div>
      <!--col-->
      <div class="col-sm-7">
        <div
          class="btn-toolbar float-right"
          role="toolbar"
          aria-label="@lang('labels.general.toolbar_btn_groups')"
        >
          <a
            href="#"
            @click="back"
            class="btn btn-warning ml-1 text-black"
            data-toggle="tooltip"
            title="Back"
            ><i class="ti-arrow-left"></i
          ></a>
        </div>
        <!--btn-toolbar-->
      </div>
      <!--col-->
    </div>
    <!--row-->

    <hr />
    <div class="row mt-4 mb-4">
      <div class="col-sm-12 col-md-6">
        <div class="form-group row">
          <label for="profile_id" class="col-md-4 form-control-label">
            Profile ID
          </label>
          <div class="col-md-8">
            <input
              type="tel"
              name="profile_id"
              id="profile_id"
              class="form-control"
              v-model="dbaProfile.profile_id"
              onkeypress="allowNumbersOnly(event)"
            />
          </div>
          <!--col-->
        </div>
        <!--form-group-->

        <div class="form-group row">
          <label for="profile_name" class="col-md-4 form-control-label">
            Profile Name
          </label>
          <div class="col-md-8">
            <input
              type="text"
              name="profile_name"
              id="profile_name"
              class="form-control"
              v-model="dbaProfile.profile_name"
              placeholder="example: OAM-Service-TSEL-1M"
            />
          </div>
          <!--col-->
        </div>
        <!--form-group-->

        <div class="form-group row">
          <label for="tcont_type" class="col-md-4 form-control-label">
            Tcont Type
          </label>
          <div class="col-md-8">
            <select
              name="tcont_type"
              id="tcont_type"
              class="form-control"
              v-model="dbaProfile.tcont_type"
            >
              <option value="type1">Type 1</option>
              <option value="type2">Type 2</option>
              <option value="type3">Type 3</option>
              <option value="type4">Type 4</option>
            </select>
          </div>
          <!--col-->
        </div>
        <!--form-group-->

        <div id="result-type">
          <div class="form-group row">
            <label for="fix_bw" class="col-md-4 form-control-label">
              Fix BW(Mb)
            </label>
            <div class="col-md-8">
              <input
                type="tel"
                name="fix_bw"
                id="fix_bw"
                class="form-control"
                v-model="dbaProfile.fix_bw"
                onkeypress="allowNumbersOnly(event)"
              />
            </div>
          </div>
        </div>
        <div class="form-group pull-right">
           <button
            type="button"
            class="btn btn-md btn-success"
            @click="save"
          >
            Save Config
          </button>
          <button
            type="button"
            class="btn btn-md btn-info"
            @click="generateConfig"
          >
            Generate Config
          </button>
        </div>
      </div>
      <!--col-->
      <div class="col-sm-12 col-md-6">
        <div class="generate-config">
          <div class="bg-gray-800 text-white rounded font-mono p-3">
            <div class="flex terminal-title">
              <div class="flex terminal-button">
                <div class="rounded-full w-4 h-4 bg-red mr-2"></div>
                <div class="rounded-full w-4 h-4 bg-green mr-2"></div>
                <div class="rounded-full w-4 h-4 bg-yellow mr-2"></div>
              </div>
              <button
                type="button"
                class="btn btn-primary btn-sm"
                onclick="copyText('generate-config')"
              >
                Copy
              </button>
            </div>
            <div
              class="generate-config"
              role="alert"
              id="generate-config"
              contenteditable="true"
            ></div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <td>Profile ID</td>
              <td>Profile Name</td>
              <td>Tcont Type</td>
              <td>Fix BW</td>
              <td>Assure BW</td>
              <td>Max BW</td>
              <td>Created By</td>
              <td>Action</td>
            </tr>
          </thead>
          <tbody v-for="dba_profile in dba">
            <tr>
              <td>{{ dba_profile.profile_id }}</td>
              <td>{{ dba_profile.profile_name }}</td>
              <td>{{ dba_profile.tcont_type }}</td>
              <td>{{ dba_profile.fix_bw }}</td>
              <td>{{ dba_profile.assure_bw }}</td>
              <td>{{ dba_profile.max_bw }}</td>
              <td>{{ dba_profile.name }}</td>
              <td>
                <form
                  action="delete()"
                  method="post"
                  id="formDelete"
                >
                  <button
                    type="button"
                    class="btn btn-md btn-info"
                    onclick="generateConfig(this)"
                    data-props="json_encode(data)"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Generate Config"
                  >
                    <i class="fa fa-sticky-note"></i>
                  </button>

                  <a
                    href="javascript:void(0)"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="Delete data"
                    class="btn btn-danger"
                    onclick="confirm('Are you sure you want to delete this data?') ? this.parentElement.submit() : ''"
                  >
                    <i class="fa fa-trash"></i>
                  </a>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  created() {
    axios
      .get(
        "/panel/dba-profile/show/" +
          this.$parent.olt_site_id +
          "?config_id=" +
          this.$parent.config_id
      )
      .then((response) => {
        this.dba = response.data.dba;
      }); 
  },
  data() {
    return {
      csrf: document.head.querySelector('meta[name="csrf-token"]').content,
      dba: [],
      dbaProfile: {
        id: 0,
        profile_id: null,
        profile_name: null,
        tcont_type: null,
        fix_bw: null,
        assure_bw: null,
        max_bw: null,
      },
      title: "",
      config_id: this.$parent.config_id,
      url: null,
      olt_site_id: this.$parent.olt_site_id,
    };
  },
  methods: {
    save() {
      let currentObj = this;
      var formData = new FormData($("#form_data")[0]);
      currentObj.url = $('#url').val();
      $.ajax({
        url: currentObj.url,
        contentType: 'application/json',
        dataType: 'json',
        type: "POST",
        data: formData,
        cache: false,
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
            currentObj.dba.unshift(response.object.dba);
            //currentObj.bindValue(response);
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
    back(){
        this.$parent.gponPage = 0;
    },
    clear() {
      this.dbaProfile.id = 0;
      this.dbaProfile.profile_id = null;
      this.dbaProfile.profile_name = null;
      this.dbaProfile.tcont_type = null;
      this.dbaProfile.fix_bw = null;
      this.dbaProfile.assure_bw = null;
      this.dbaProfile.max_bw = null;
    },
    generateConfig(){
      let currentObj = this;
      currentObj.printConfig(currentObj.dbaProfile);
    },
    printConfig(data){
       let typeValue = "";
        if (data.tcont_type === "type1") {
          typeValue = `fix ${data.fix_bw}`;
        } else if (data.tcont_type === "type2") {
          typeValue = `assure ${data.assure_bw}`;
        } else if (data.tcont_type === "type3") {
          typeValue = `assure ${data.assure_bw} max ${data.max_bw}`;
        } else if (data.tcont_type === "type4") {
          typeValue = `max ${data.max_bw}`;
        }

        const text = `<p>config <br>
                          dba-profile add profile-id ${data.profile_id} profile-name "${data.profile_name}" ${data.tcont_type} ${typeValue}</p>`;
        const genCon = document.getElementById("generate-config");
        genCon.style.display = "block";
        genCon.innerHTML = text;
        genCon.focus();
    }
  },
};
</script>
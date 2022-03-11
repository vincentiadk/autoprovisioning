<template>
  <div class="card" id="formConfig">
    <input type="hidden" id="url" value="/panel/ont/store" />
    <input type="hidden" name="olt_site_id" v-model="olt_site_id" />
    <div class="card-body">
      <div class="row">
        <div class="col-sm-5">
          <h4 class="card-title mb-0">ONT Line Profile</h4>
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
                type="text"
                name="profile_id"
                id="profile_id"
                class="form-control"
                list="dbaprops"
                required
                v-model="profile_id"
              />
              <datalist id="dbaprops" v-for="dbaprofile in dba">
                <option>{{ dbaprofile }}</option>
              </datalist>
            </div>
            <!--col-->
          </div>
          <!--form-group-->

          <div class="form-group row">
            <label for="tcont_1" class="col-md-4 form-control-label">
              Tcont 1
            </label>
            <div class="col-md-8">
              <input
                type="text"
                name="tcont_1"
                id="tcont_1"
                class="form-control"
                v-model="tcont_1"
                placeholder="example: dba-profile-id 99"
              />
            </div>
            <!--col-->
          </div>
          <!--form-group-->

          <div class="form-group row">
            <label for="tcont_1" class="col-md-4 form-control-label">
              Tcont 2
            </label>
            <div class="col-md-8">
              <input
                type="text"
                name="tcont_2"
                id="tcont_2"
                class="form-control"
                v-model="tcont_2"
              />
            </div>
            <!--col-->
          </div>
          <!--form-group-->

          <div class="form-group row">
            <label for="tcont_3" class="col-md-4 form-control-label">
              Tcont 3
            </label>
            <div class="col-md-8">
              <input
                type="text"
                name="tcont_3"
                id="tcont_3"
                class="form-control"
                v-model="tcont_3"
              />
            </div>
            <!--col-->
          </div>
          <!--form-group-->

          <div class="form-group row">
            <label for="tcont_4" class="col-md-4 form-control-label">
              Tcont 4
            </label>
            <div class="col-md-8">
              <input
                type="text"
                name="tcont_4"
                id="tcont_4"
                class="form-control"
                v-model="tcont_4"
              />
            </div>
            <!--col-->
          </div>
          <!--form-group-->

          <div class="form-group pull-right">
            <button type="input" class="btn btn-md btn-success ml-2">
              Create
            </button>
            <button
              type="button"
              class="btn btn-md btn-info"
              id="generateConfigBtn"
            >
              Generate Config
            </button>
          </div>
        </div>
        <!--col-->
        <div class="col-sm-12 col-md-6">
          <div class="generate-config">
            <div class="bg-gray-800 text-white p-3 rounded font-mono">
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
      <!--row-->
      <div class="row">
        <div class="table-responsive">
          <table class="table table-hover">
            <thead>
              <tr>
                <td>Profile ID</td>
                <td>Profile Name</td>
                <td>VLAN T1</td>
                <td>Dba Profile T1</td>

                <td>VLAN T2</td>
                <td>Dba Profile T2</td>

                <td>VLAN T3</td>
                <td>Dba Profile T3</td>

                <td>VLAN T4</td>
                <td>Dba Profile T4</td>

                <td>Created By</td>
                <td>Action</td>
              </tr>
            </thead>
            <tbody v-for="d in ont">
              <tr>
                <td>{{ d.profile_id }}</td>
                <td>{{ d.profile_name }}</td>

                <td>{{ d.vlan }}</td>
                <td>{{ d.tcont_1 }}</td>

                <td>{{ d.vlan_2g }}</td>
                <td>{{ d.tcont_2 }}</td>

                <td>{{ d.vlan_3g }}</td>
                <td>{{ d.tcont_3 }}</td>

                <td>{{ d.vlan_4g }}</td>
                <td>{{ d.tcont_4 }}</td>

                <td>{{ d.name }}</td>
                <td>
                  <form
                    action="/panel/ont/delete/"
                    method="post"
                    id="formDelete"
                  >
                    <button
                      type="button"
                      class="btn btn-md btn-info"
                      onclick="generateConfig(this)"
                      data-props="json_encode(d)"
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
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  data() {
    return {
      dba: [],
      ont: [],
      profile_id: null,
      tcont_1: null,
      tcont_2: null,
      tcont_3: null,
      tcont_4: null,
      olt_site_id: this.$parent.olt_site_id,
    };
  },
  methods: {
    back(){
        this.$parent.gponPage = 0;
    },
    generateConfig(){
      
    }
  },
};
</script>
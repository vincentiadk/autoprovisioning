<template>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-sm-5">
          <h4 class="card-title mb-0">Create VLAN</h4>
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
              class="btn btn-warning ml-1 text-black"
              data-toggle="tooltip"
              title="Back"
              ><i class="ti-arrow-left" @click="back"></i
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
          <div class="form-group">
            <div class="row">
              <div class="col-6">
                <label for="vlan_id" class="form-control-label">
                  VLAN ID
                </label>
                <input
                  type="tel"
                  name="vlan_id"
                  id="vlan_id"
                  class="form-control"
                  onkeypress="allowNumbersOnly(event)"
                  v-model="vlan_id"
                />
              </div>
              <div class="col-6">
                <label for="pir" class="form-control-label">
                  VLAN Description
                </label>
                <input type="text" name="desc" id="desc" class="form-control" v-model="description" />
              </div>
            </div>
          </div>

          <div class="form-group">
            <div class="row">
              <div class="col-6">
                <label for="port" class="form-control-label"> Port </label>
                <input
                  type="tel"
                  name="port"
                  id="port"
                  class="form-control"
                  onkeypress="allowNumbersOnly(event)"
                  v-model="port"
                />
              </div>
            </div>
          </div>
          <!--form-group-->

          <div class="form-group pull-right">
            <button
              type="button"
              class="btn btn-md btn-info"
              id="generateConfigBtn"
              @click="save"
            >
              Save Config
            </button>
          </div>
          <div class="form-group pull-right">
            <button
              type="button"
              class="btn btn-md btn-info"
              id="generateConfigBtn"
              @click="generateConfig"
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
    </div>
    <!--card-body-->
  </div>
</template>
    <script>
export default {
    data() {
        return {
            vlan_id:null,
            description:null,
            port:null
        }
    },
  methods: {
    back(){
        this.$parent.gponPage = 0;
    },
    save() {},
    generateConfig() {
        const text = `vlan ${this.vlan_id} smart
        vlan ${this.vlan_id} description ${this.description}
        port vlan ${this.vlan_id} ${this.port}`;

        const genCon = document.getElementById('generate-config');
        genCon.style.display = 'block';
        genCon.innerText = text;
        genCon.focus();
    }
  },
};

</script>
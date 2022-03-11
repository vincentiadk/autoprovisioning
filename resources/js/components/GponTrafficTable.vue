<template>
  <div class="card-body">
    <div class="row">
      <div class="col-sm-5">
        <h4 class="card-title mb-0">Traffic Table</h4>
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
            @click="back"
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
        <div class="form-group">
          <div class="row">
            <div class="col-6">
              <label for="cir" class="form-control-label"> CIR </label>
              <input
                type="tel"
                name="cir"
                id="cir"
                class="form-control"
                onkeypress="allowNumbersOnly(event)"
                 v-model="cir"
              />
            </div>
            <div class="col-6">
              <label for="pir" class="form-control-label"> PIR </label>
              <input
                type="tel"
                name="pir"
                id="pir"
                class="form-control"
                onkeypress="allowNumbersOnly(event)"
                 v-model="pir"
              />
            </div>
          </div>
        </div>

        <div class="form-group">
          <div class="row">
            <div class="col-6">
              <label for="priority" class="form-control-label">
                Priority
              </label>
              <input
                type="tel"
                name="priority"
                id="priority"
                class="form-control"
                onkeypress="allowNumbersOnly(event)"
                v-model="priority"
              />
            </div>
            <div class="col-6">
              <label for="priority_policy" class="form-control-label">
                Priority Policy
              </label>
              <input
                type="text"
                name="priority_policy"
                id="priority_policy"
                class="form-control"
                v-model="priority_policy"
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
</template>
<script>
export default {
  data(){
    return {
      cir : null,
      pir : null,
      priority : null,
      priority_policy : null,
      olt : {}
    }
  },
  created() {
    axios
      .get(
        "/panel/traffic-table/show/" +
          this.$parent.olt_site_id +
          "?config_id=" +
          this.$parent.config_id
      )
      .then((response) => {
        this.olt = response.data.oltSite;
      }); 
  },
  methods: {
    back(){
        this.$parent.gponPage = 0;
    },
    generateConfig() {
      const text =
          `traffic table ip cir ${this.cir} pir ${this.pir} priority ${this.priority} priority-policy ${this.priority_policy}`;

      const genCon = document.getElementById('generate-config');
      genCon.style.display = 'block';
      genCon.innerHTML = text;
      genCon.focus();
    },
    save(){}
  },
};
</script>
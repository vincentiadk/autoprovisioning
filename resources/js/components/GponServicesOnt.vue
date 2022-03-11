<template>
    <div class="card" id="formConfig">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-5">
                <h4 class="card-title mb-0">
                    Service Port
                </h4>
            </div>
            <!--col-->
            <div class="col-sm-7">

                <div class="btn-toolbar float-right" role="toolbar"
                    aria-label="@lang('labels.general.toolbar_btn_groups')">
                    <a href="#" @click="back" class="btn btn-warning ml-1 text-black"
                        data-toggle="tooltip" title="Back"><i class="ti-arrow-left"></i></a>
                </div>
                <!--btn-toolbar-->

            </div>
            <!--col-->
        </div>
        <!--row-->

        <hr>
            <div class="row mt-4 mb-4">
                <div class="col-sm-12 col-md-5">
                    <div class="form-group row">
                        <label for="profile_id" class="col-md-4 form-control-label">
                            GPON Port
                        </label>
                        <div class="col-md-8">
                            <input type="text" name="gpon_port" id="gpon_port" class="form-control"
                                required v-model="gpon_port" />
                        </div>
                        <!--col-->
                    </div>
                    <!--form-group-->

                    <div class="form-group row">
                        <label for="ont_number" class="col-md-4 form-control-label">
                            ONT Number
                        </label>
                        <div class="col-md-8">
                            <input type="text" name="ont_number" id="ont_number" class="form-control"
                                v-model="ont_number" >
                        </div>
                        <!--col-->
                    </div>
                    <!--form-group-->

                    <div class="form-group pull-right">
                        <button type="button" class="btn btn-md btn-info" id="generateConfigBtn"
                        @click="generateConfig"
                            >Generate
                            Config</button>
                    </div>
                </div>
                <!--col-->
                <div class="col-sm-12 col-md-7">
                    <div class="generate-config" >
                        <div class="bg-gray-800 text-white p-5 rounded font-mono">
                            <div class="flex terminal-title">
                                <div class="flex terminal-button">
                                    <div class="rounded-full w-4 h-4 bg-red mr-2"></div>
                                    <div class="rounded-full w-4 h-4 bg-green mr-2"></div>
                                    <div class="rounded-full w-4 h-4 bg-yellow mr-2"></div>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm" onclick="copyText('generate-config')">Copy</button>
                            </div>
                            <div class="generate-config" role="alert" id="generate-config" contenteditable="true">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

</div>
</template>
<script>
export default{
    data() {
        return {
            gpon_port : null,
            ont_number : null,
            olt : {},
        }
    },
    created() {
    axios
      .get(
        "/panel/service-port/show/" +
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
        save(){

        },
        generateConfig(){

            const sp1= this.printGemMap(this.gpon_port, this.ont_number, this.olt.vlan, 1);
            const sp2= this.printGemMap(this.gpon_port, this.ont_number, this.olt.vlan_2g, 2);
            const sp3= this.printGemMap(this.gpon_port, this.ont_number, this.olt.vlan_3g, 3);
            const sp4= this.printGemMap(this.gpon_port, this.ont_number, this.olt.vlan_3g, 4);

            const text = `${sp1}
                            ${sp2}
                            ${sp3}
                            ${sp4}
                        `;

            const genCon = document.getElementById('generate-config');
            genCon.style.display = 'block';
            genCon.innerHTML = text;
            genCon.focus();
        },
        printGemMap(gponPort, ontNum, vlan, id){
        let gemMap = ''
        if(gponPort && ontNum && vlan){
            const vlans = vlan.split(',');
            vlans.forEach((val, index) => {
                gemMap += `service-port vlan ${val} gpon ${gponPort} ont ${ontNum} gemport ${id} multi-service <br>
                        user-vlan ${val} rx-cttr 96 tx-cttr 96 <br>`;
            });
        }
        return gemMap;
    }
    }
}
</script>
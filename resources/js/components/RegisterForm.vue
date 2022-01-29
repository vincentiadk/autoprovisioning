<template>
  <div class="container">
    <form @submit="formSubmit">
      <div class="row">
        <img src="/assets/static/images/logo_horizontal.svg" />
      </div>
      <div class="row">
        <h4>Account</h4>
        <div class="input-group input-group-icon">
          <input
            type="text"
            placeholder="Full Name"
            v-model="nama"
            required
            minlength="6"
          />
          <div class="input-icon"><i class="fa fa-user"></i></div>
        </div>
        <div class="input-group input-group-icon">
          <input
            type="email"
            placeholder="Email Adress"
            v-model="email"
            required
          />
          <div class="input-icon"><i class="fa fa-envelope"></i></div>
        </div>
        <div class="input-group input-group-icon">
          <input
            type="password"
            placeholder="Password"
            v-model="password"
            required
            minlength="6"
          />
          <div class="input-icon"><i class="fa fa-key"></i></div>
        </div>
        <div class="input-group input-group-icon">
          <input
            type="password"
            placeholder="Password Confirmation"
            v-model="password_confirmation"
            required
            minlength="6"
          />
          <div class="input-icon"><i class="fa fa-key"></i></div>
        </div>
        <div class="input-group input-group-icon">
          <input
            type="number"
            placeholder="Phone Number"
            v-model="phone_number"
            maxlength="12"
            minlength="9"
            required
          />
          <div class="input-icon" style="margin: 0px; color: black">+ 62</div>
        </div>
        <div class="input-group input-group-icon">
          <input
            type="number"
            placeholder="NIK"
            v-model="nik"
            required
            maxlength="8"
            minlength="6"
          />
          <div class="input-icon"><i class="fa fa-address-card"></i></div>
        </div>
        <div class="input-group">
          <select v-model="regional" required>
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
      </div>
      <div class="row">
        <h4>Terms and Conditions</h4>
        <div class="input-group">
          <input type="checkbox" id="terms" required />
          <label for="terms"
            >I accept the
            <span @click="openToc" style="color: red"
              >terms and conditions</span
            >
            for signing up to this service, and hereby confirm I have read the
            privacy policy.</label
          >
        </div>
      </div>
      <div class="row">
        <button class="btn btn-primary" style="width: 100%">Register</button>
        <div class="sso">
          <router-link class="page" to="/login" style="text-align: center"
            >or Login</router-link
          >
        </div>
      </div>
    </form>
  </div>
</template>
<script>
export default {
  mounted() {
    console.log("register mounted");
  },
  data() {
    return {
      nama: "",
      email: "",
      password: "",
      password_confirmation: "",
      phone_number: "",
      nik: "",
      regional: "",
      csrf: document.head.querySelector('meta[name="csrf-token"]').content,
    };
  },

  methods: {
    resetInput(){
      this.nama = "";
      this.email = "";
      this.password = "";
      this.password_confirmation = "";
      this.phone_number = "";
      this.nik = "";
      this.regional = "";
    },
    formSubmit(e) {
      e.preventDefault();
      let currentObj = this;
      axios
        .post("/register", {
          nama: this.nama,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          phone_number: this.phone_number,
          nik: this.nik,
          regional: this.regional,
          _token: this.csrf,
        })
        .then(function (response) {
          if (response.data.status == 200) {
            currentObj.resetInput();
            currentObj.$parent.showDialog(
              "success",
              "Register Success",
              "Please check your email for activation",
              0
            );
          } else if (response.data.status == 422) {
            let error = "<ul>";
            $.each(response.data.error, function (i, val) {
              error += "<li>" + val + "</li>";
            });
            error += "</ul>";
            currentObj.$parent.showDialog(
              "warning",
              "Check your input!",
              error,
              30000
            );
          } else {
            currentObj.$parent.showDialog(
              "error",
              "Register Failed",
              "Server Error!",
              10000
            );
          }
        })
        .catch(function (error) {
          currentObj.output = error;
        });
    },
    openToc(e) {
      e.preventDefault();
      let currentObj = this;
      let toc = "";
      axios.get("/toc").then((response) => {
        toc = response.data;
        currentObj.$parent.$fire({
          title: "GENERAL TERM OF USE PROVISIONING SERVICE TELKOMSEL",
          html: toc,
          type: "info",
          width: "80%",
          customClass: {
            title: "modal-title",
            content: "modal-content",
          },
          allowOutsideClick: false
        });
      });
    },
  },
};
</script>
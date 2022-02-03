<template>
  <div class="container">
    <form @submit="formSubmit">
      <div class="row">
        <img src="/assets/static/images/logo_horizontal.svg" />
      </div>
      <div class="row">
        <h4>Log In</h4>
        <div class="input-group input-group-icon">
          <input type="hidden" name="_token" :value="csrf" />
          <input
            type="text"
            placeholder="Username / Email"
            v-model="username"
            required
          />
          <div class="input-icon"><i class="fa fa-user"></i></div>
        </div>
        <div class="input-group input-group-icon">
          <input
            type="password"
            placeholder="Password"
            v-model="password"
            required
          />
          <div class="input-icon"><i class="fa fa-key"></i></div>
        </div>
      </div>
      <div class="row">
        <button class="btn btn-primary" style="width: 100%" >Login</button>
        <div class="sso">
          <router-link class="page" to="/register" style="text-align:center">Don't have an account? Register here.</router-link>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
export default {

  data() {
    return {
      username: "",
      password: "",
      csrf: document.head.querySelector('meta[name="csrf-token"]').content,
    };
  },

  methods: {
    formSubmit(e) {
      e.preventDefault();
      let currentObj = this;
      axios
        .post("/login", {
          username: this.username,
          password: this.password,
          _token: this.csrf,
        })
        .then(function (response) {
          if (response.data.status == 200) {
            let a = document.createElement("a");
            a.target = "_self";
            a.href = response.data.url;
            a.click();
          } else if (response.data.status == 422) {
            currentObj.$parent.showDialog(
              "warning",
              response.data.message,
              "",
              30000
            );
          } else {
            currentObj.$parent.showDialog(
              "error",
              "Error",
              "Server Error. Please contact server administrator.",
              30000
            );
          }
        })
        .catch(function (error) {
          currentObj.output = error;
        });
    },
  },
};
</script>
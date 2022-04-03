<template>
  <div class="navbar">
    <div class="logo">
      <h2><a href="/">Logo</a></h2>
    </div>
    <nav>
      <ul>
          <li v-if="success===1"><a @click="redirect(username)">ACCOUNT</a></li>
          <li v-if="success===1"><a @click="logout()">LOGOUT</a></li>
          <li v-if="success===0"><a @click="redirect('register')">START</a></li>
          <li v-if="success===0"><a @click="redirect('login')">LOGIN</a></li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
    data: function () {
        return {
            success: 0,
            username: "",
            csrf: document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        };
    },
  methods: {
      redirect: function (params) {
        window.location.href = "/" + params;
      },
      logout: function () {
          axios.post('/api/logout', {
              token: this.csrf
          })
              .then((response) => {
                  location.href = "/";
              })
              .catch(function (error) {
                  console.log(error);
              });
      },
      checkIfLogged: function () {
          axios
              .post("/api/checkLogged", {
                  token: this.csrf,
              })
              .then((response) => {
                  if (response.data.success === 1) {
                      this.success = response.data.success;
                      this.username = response.data.username;
                  }
              })
              .catch(function (error) {
                  console.log(error);
              });
      },
  },
  mounted() {
    this.checkIfLogged();
  },
};
</script>

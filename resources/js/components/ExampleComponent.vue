<template>
  <div class="container">
    <div class="home">
      <h1>Free site to learn language!</h1>
      <div class="buttons">
        <button @click="redirect('register')">START</button>
        <button @click="redirect('login')">LOGIN</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  methods: {
    redirect: function (params) {
      window.location.href = "/" + params;
    },
    checkIfLogged: function () {
      axios
        .post("/api/checkLogged", {
          token: this.csrf,
        })
        .then((response) => {
          console.log(response.data);
          if (response.data.success === 1) {
            this.success = response.data.success;
            this.userName = response.data.username;
            window.location.href = "/" + this.userName;
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

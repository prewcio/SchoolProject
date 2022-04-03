<template>
  <div class="container">
    <div class="home">
      <h1>Free site to learn language!</h1>
      <div class="buttons">
          <button @click="redirect('register')" v-if="success===0">START</button>
          <button @click="redirect('login')" v-if="success===0">LOGIN</button>
          <button @click="redirect(userName)" v-if="success===1">ACCOUNT</button>
          <button @click="logout()" v-if="success===1">LOGOUT</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data: function (){
    return{
        success: 0,
        userName: "",
        csrf: document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute("content"),
    }
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
          console.log(response.data.success);
          if (response.data.success === 1) {
            this.success = response.data.success;
            this.userName = response.data.username;
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

<template>
  <div class="container test" v-if="this.success === 1">
    <div class="exeTest">
      <div v-if="this.currentUrl === '/' + this.userName + '/exercise'">
        <h1>Exercises</h1>
      </div>
      <div v-else-if="this.currentUrl === '/' + this.userName + '/test'">
        <h1>Tests</h1>
      </div>
      <div v-else>
        <h1>Select Page</h1>
        <button @click="redirect('exercise')">Exercise</button>
        <button @click="redirect('test')">Test</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ExerTest",
  data: function () {
    return {
      success: 0,
      currentUrl: "",
      userName: "",
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
  mounted() {
    this.checkIfLogged();
    this.currentUrl = window.location.pathname;
  },
  methods: {
    redirect: function (params) {
      console.log("/" + params);
      window.location.href = "/" + this.userName + "/" + params;
    },
    checkIfLogged: function () {
      axios
        .post("/api/checkLogged", {
          token: this.csrf,
        })
        .then((response) => {
          console.log(response.data);
          if (response.data.success === 0) {
            window.location.href = "/login";
          } else {
            this.success = response.data.success;
            console.log(this.success);
            this.userName = response.data.username;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>

<template>
  <div class="container">
    <div class="bg">
      <div class="form">
        <form @submit.prevent="loginForm" v-if="logreg === '/login'">
          <h1>Logowanie</h1>
          <input type="text" placeholder="Login" name="login" v-model="login" />
          <input
            type="password"
            placeholder="Password"
            name="password"
            v-model="password"
          />
          <input type="submit" value="Zaloguj" />
          <p style="color: red" v-if="error === 1">Konto nie istnieje</p>
          <p style="color: red" v-if="error === 2">Błędny login lub hasło</p>
          <p style="color: red" v-if="error===3">Tym Pawłem to idź kablować</p>
          <p style="color: red" v-if="error===4">Domsky kopsnij cssa (TSI 2k20-2k21)</p> 
          <p style="color: red" v-if="error===5">Ten to tylko się przykleja żeby ocenkę za darmo dostać</p> 
        </form>
        <form @submit.prevent="registerForm" v-if="logreg === '/register'">
          <h1>Rejestracja</h1>
          <input type="text" name="login" placeholder="Login" v-model="login" />
          <input
            type="email"
            name="email"
            placeholder="E-mail"
            v-model="email"
          />
          <input
            type="password"
            name="password"
            placeholder="Password"
            v-model="password"
          />
          <input type="submit" value="Zarejestruj" />
        </form>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "LogReg",
  data: function () {
    return {
      error: 0,
      success: 0,
      logreg: "/register",
      email: "",
      password: "",
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
  mounted() {
    // this.checkIfLogged();
    var currentUrl = window.location.pathname;
    this.logreg = currentUrl;
  },
  methods: {
    async loginForm() {
      const res = await fetch("/api/loginCheck", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          login: this.login,
          password: this.password,
          token: this.csrf,
        }),
      });
      const data = await res.json();
      this.error = data.error;
      if(this.login==="PawelBartosiewicz"){
          this.error = 3;
      } else if(this.login==="Domsky"){
          this.error = 4;
      } else if(this.login==="Jeremi"){
          this.error = 5;
      }
      this.success = data.success;
      if (this.success === 1) {
        window.location.href = "/" + data.username;
      }
    },
    checkIfLogged: function () {
      axios
        .post("/api/checkLogged", {
          token: this.csrf,
        })
        .then((response) => {
          if (response.data.success == 1) {
            window.location.href = "/" + data.username;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
    async registerForm() {
      const res = await fetch("/api/registerCheck", {
        method: "POST",
        headers: { "Content-Type": "application/json" },
        body: JSON.stringify({
          login: this.login,
          email: this.email,
          password: this.password,
          token: this.csrf,
        }),
      });
      const data = await res.json();
      this.error = data.error;
      this.success = data.success;
      if (this.success === 1) {
        // window.location.href = "/account";
      }
    },
  },
};
</script>

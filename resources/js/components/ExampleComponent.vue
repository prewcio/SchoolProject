<template>
  <div class="container">
    <div class="home">
      <h1>Darmowy, ciekawy i skuteczny sposób na naukę języka!</h1>
      <button @click="redirect('register')">Rozpocznij</button>
      <button @click="redirect('login')">Mam juz konto</button>
    </div>
  </div>
</template>

<script>
export default {
  methods:{
    redirect: function (params) {
        window.location.href = "/"+params;
    },
      checkIfLogged: function (){
          axios.post('/api/checkLogged', {
              'token': this.csrf
          })
              .then((response) => {
                  console.log(response.data)
                  if(response.data.success===1){
                      this.success=response.data.success;
                      this.userName = response.data.username;
                      window.location.href = "/"+this.userName;
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

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
    }
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>

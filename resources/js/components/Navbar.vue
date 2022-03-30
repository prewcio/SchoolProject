<template>
  <div class="navbar">
    <div class="logo">
      <h1>Logo</h1>
    </div>
    <nav>
      <ul>
        <li><a @click="redirect('register')">Rozpocznij</a></li>
        <li><a @click="redirect('login')">Mam juz konto</a></li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  methods: {
    redirect: function (params) {
      window.location.href = "/" + params;
    },
  },
  mounted() {
    console.log("Component mounted.");
  },
};
</script>

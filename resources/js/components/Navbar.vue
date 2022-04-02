<template>
  <div class="navbar">
    <div class="logo">
      <h2><a href="/">Logo</a></h2>
    </div>
    <nav>
      <ul>
        <li><a @click="redirect('register')">START</a></li>
        <li><a @click="redirect('login')">LOGIN</a></li>
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

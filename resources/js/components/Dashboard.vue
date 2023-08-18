<template>
  <div class="container mt-2">
    <div class="row">
      <div class="col-12">
        <div class="card shadow-sm">
          <div class="card-header">
            <h3>Dashboard</h3>
          </div>
          <div class="card-body">
            <p class="mb-0">
              You are logged in as <b>{{ name }}</b>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "dashboard",
  data() {
    return {
      isLoggedIn: null,
      name: null,
    };
  },
  mounted() {
    const token = localStorage.getItem("jwt");
    if (token) {
      this.isLoggedIn = token;
      this.name = localStorage.getItem("name");
    }
  },
  beforeRouteEnter(to, from, next) {
    if (!localStorage.getItem("jwt")) {
      return next("login");
    }
    next();
  },
};
</script>

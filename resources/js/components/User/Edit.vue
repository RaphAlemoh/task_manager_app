<template>
  <div>
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              Update User
              <router-link :to="{ name: 'users' }" class="float-right"
                >Back</router-link
              >
            </div>

            <div class="card-body">
              <form @submit.prevent="updateUser">
                <div class="form-group row">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >User Description</label
                  >

                  <div class="col-md-6">
                    <input
                      id="name"
                      v-model="form.name"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>
                </div>

                <div class="form-group row">
                  <label
                    for="email"
                    class="col-md-4 col-form-label text-md-right"
                    >E-Mail Address</label
                  >

                  <div class="col-md-6">
                    <input
                      id="email"
                      type="email"
                      class="form-control"
                      name="email"
                      required
                      autocomplete="email"
                      v-model="form.email"
                    />
                  </div>
                </div>

                <div class="form-group row">
                  <label
                    for="password"
                    class="col-md-4 col-form-label text-md-right"
                    >Password</label
                  >

                  <div class="col-md-6">
                    <input
                      id="password"
                      type="password"
                      class="form-control"
                      name="password"
                      v-model="form.password"
                      required
                      autocomplete="new-password"
                    />
                  </div>
                </div>

                <div class="col-md-6 mt-2">
                  <select
                    v-model="form.role_id"
                    name="role"
                    class="form-control"
                    aria-label="Default select example"
                  >
                    <option
                      v-for="role in roles"
                      :key="role.id"
                      :value="role.id"
                    >
                      {{ role.name }}
                    </option>
                  </select>
                </div>

                <div class="form-group row mb-0 mt-4">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                      Update User
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

  <script>
export default {
  data() {
    return {
      roles: [],
      form: {
        name: "",
        email: "",
        password: "",
        role_id: "",
      },
    };
  },
  created() {
    this.getRoles();
    this.getUser();
  },
  methods: {
    getUser() {
      axios
        .get("/api/users/" + this.$route.params.id)
        .then((res) => {
          this.form = res.data.data;
        })
        .catch((error) => {
          console.log(console.error);
        });
    },
    getRoles() {
      axios
        .get("/api/roles")
        .then((res) => {
          this.roles = res.data;
        })
        .catch((error) => {
          console.log(console.error);
        });
    },
    updateUser() {
      axios
        .put("/api/users/" + this.$route.params.id, {
          name: this.form.name,
        })
        .then((res) => {
          this.$router.push({ name: "users" });
        })
        .catch((error) => {
          console.log(console.error);
        });
    },
  },
};
</script>

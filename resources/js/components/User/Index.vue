<template>
  <div>
    <div class="container mt-2">
      <div class="row">
        <div class="col-12">
          <div
            class="d-sm-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Users</h1>

            <div class="row justify-content-end">
              <div class="col-md-12">
                <router-link
                  :to="{ name: 'create_user' }"
                  class="btn btn-primary mb-2"
                  >Create User</router-link
                >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card mx-auto">
              <div v-if="showMessage">
                <div class="alert alert-success">
                  {{ message }}
                </div>
              </div>
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <form>
                      <div class="form-row align-items-center">
                        <div class="col">
                          <input
                            type="search"
                            name="search"
                            class="form-control mb-2"
                            id="inlineFormInput"
                            placeholder="Search User"
                          />
                        </div>
                        <div class="col">
                          <button type="submit" class="btn btn-primary mb-2">
                            Search
                          </button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <table class="table">
                  <thead>
                    <tr>
                      <th scope="col">#Id</th>
                      <th scope="col">Username</th>
                      <th scope="col">Email</th>
                      <th scope="col">Manage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="user in users" :key="user.id">
                      <th scope="row">#{{ user.id }}</th>
                      <td>{{ user.name }}</td>
                      <td>{{ user.email }}</td>
                      <td>
                        <router-link
                          :to="{
                            name: 'edit_user',
                            params: { id: user.id }
                            }"
                          class="btn btn-success"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-danger"
                          @click="deleteUser(user.id)"
                        >
                          Delete
                        </button>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>
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
      users: [],
      showMessage: false,
      message: "",
      search: null,
    };
  },
  watch: {
    search() {
      this.getUsers();
    },
  },
  created() {
    this.getUsers();
  },
  methods: {
    getUsers() {
      axios
        .get("/api/users", {
          params: {
            search: this.search,
          },
        })
        .then((res) => {
          this.users = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteUser(id) {
      axios.delete("api/users/" + id).then((res) => {
        this.showMessage = true;
        this.message = res.data;
        this.getUsers();
      });
    },
  },
};
</script>


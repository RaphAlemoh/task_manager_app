<template>
  <div>
    <div class="container mt-2">
      <div class="row">
        <div class="col-12">
          <!-- Page Heading -->
          <div
            class="d-flex align-items-center justify-content-between mb-4"
          >
            <h1 class="h3 mb-0 text-gray-800">Teams</h1>
            <div class="row justify-content-end">
              <div class="col-md-12">
                <router-link
                  :to="{ name: 'create_team' }"
                  class="btn btn-primary mb-2"
                  >Create Team</router-link
                >
              </div>
            </div>
          </div>
          <div class="row">
            <div class="card mx-auto">
              <div v-if="showMessage">
                <div class="alert alert-success">{{ message }}</div>
              </div>
              <div class="card-header">
                <div class="row">
                  <div class="col">
                    <form>
                      <div class="form-row align-items-center">
                        <div class="col">
                          <input
                            type="search"
                            v-model.lazy="search"
                            class="form-control mb-2"
                            placeholder="Search for a team"
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
                      <th scope="col">Name</th>
                      <th scope="col">Manage</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr v-for="team in teams" :key="team.id">
                      <th scope="row">#{{ team.id }}</th>
                      <td>{{ team.name }}</td>
                      <td>
                        <router-link
                          :to="{
                            name: 'edit_team',
                            params: { id: team.id },
                          }"
                          class="btn btn-success"
                          >Edit</router-link
                        >
                        <button
                          class="btn btn-danger"
                          @click="deleteTeam(team.id)"
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
      teams: [],
      showMessage: false,
      message: "",
      search: null,
    };
  },
  watch: {
    search() {
      this.getTeams();
    },
  },
  created() {
    this.getTeams();
  },
  methods: {
    getTeams() {
      axios
        .get("/api/teams", {
          params: {
            search: this.search,
          },
        })
        .then((res) => {
          this.teams = res.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteTeam(id) {
      axios.delete("api/teams/" + id).then((res) => {
        this.showMessage = true;
        this.message = res.data;
        this.getTeams();
      });
    },
  },
};
</script>


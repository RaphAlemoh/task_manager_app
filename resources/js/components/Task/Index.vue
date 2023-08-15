<template>
  <div>
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Tasks</h1>
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
                      placeholder="Search for a task"
                    />
                  </div>
                  <div class="col">
                    <button type="submit" class="btn btn-primary mb-2">
                      Search
                    </button>
                  </div>
                  Team
                  <div class="col mb-4" v-if="teams && teams.length > 0">
                    <select
                      v-model="selectedTeam"
                      name="team"
                      class="form-control"
                      aria-label="Default select example"
                    >
                      <option
                        v-for="team in teams"
                        :key="team.id"
                        :value="team.id"
                      >
                        {{ team.name }}
                      </option>
                    </select>
                  </div>
                </div>
              </form>
            </div>
            <div>
              <router-link
                :to="{ name: 'create_task' }"
                class="btn btn-primary mb-2"
                >Create Task</router-link
              >
            </div>
          </div>
        </div>
        <div class="card-body">
          <table class="table">
            <thead>
              <tr>
                <th scope="col">#Id</th>
                <th scope="col">Description</th>
                <th scope="col">User</th>
                <th scope="col">Team</th>
                <th scope="col">Manage</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="task in tasks" :key="task.id">
                <th scope="row">#{{ task.id }}</th>
                <td>{{ task.text }}</td>
                <td>{{ (task.user != '' ) ? task.user.name :"-" }}</td>
                <td>{{ (task.team != null ) ? task.team.name :"-" }}</td>
                <td>
                  <router-link
                    :to="{
                      name: 'edit_task',
                      params: { id: task.id },
                    }"
                    class="btn btn-success"
                    >Edit</router-link
                  >
                  <button
                    class="btn btn-danger"
                    @click="deleteTask(task.id)"
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
</template>

<script>
export default {
  data() {
    return {
      tasks: [],
      showMessage: false,
      message: "",
      search: null,
      selectedTeam: null,
      teams: [],
    };
  },
  watch: {
    search() {
      this.getTasks();
    },
    selectedTeam() {
      this.getTasks();
    },
  },
  created() {
    this.getTasks();
    this.getTeams();
  },
  methods: {
    getTasks() {
      axios
        .get("/api/tasks", {
          params: {
            search: this.search,
            team_id: this.selectedTeam,
          },
        })
        .then((res) => {
          this.tasks = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getTeams() {
      axios
        .get("/api/teams")
        .then((res) => {
          this.teams = res.data.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    deleteTask(id) {
      axios.delete("api/tasks/" + id).then((res) => {
        this.showMessage = true;
        this.message = res.data;
        this.getTasks();
      });
    },
  },
};
</script>

<style></style>

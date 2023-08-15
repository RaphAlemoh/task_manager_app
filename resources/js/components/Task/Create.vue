<template>
  <div>
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              Create Task
              <router-link :to="{ name: 'tasks' }" class="float-right"
                >Back</router-link
              >
            </div>

            <div class="card-body">
              <form @submit.prevent="storeTask">
                <div class="form-group row">
                  <label
                    for="first_name"
                    class="col-md-4 col-form-label text-md-right"
                    >Title</label
                  >

                  <div class="col-md-6">
                    <input
                      id="first_name"
                      v-model="form.text"
                      type="text"
                      class="form-control"
                      required
                    />
                  </div>
                </div>

                <div class="form-group row">
                  <label
                    for="team"
                    class="col-md-4 col-form-label text-md-right"
                    >Team</label
                  >

                  <div class="col-md-6">
                    <select
                      v-model="form.team_id"
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
                <div class="form-group row mb-0 mt-4">
                  <div class="col-md-6 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                      Create
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
      teams: [],
      form: {
        text: "",
        team_id: "",
      },
    };
  },
  created() {
    this.getTeams();
  },
  methods: {
    getTeams() {
      axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
          .get("/api/teams")
          .then((res) => {
            this.teams = res.data.data;
          })
          .catch((error) => {
            console.log(console.error);
          });
      });
    },
    storeTask() {
      axios.get("/sanctum/csrf-cookie").then((response) => {
        axios
          .post("/api/tasks", {
            text: this.form.text,
            team_id: this.form.team_id,
          })
          .then((res) => {
            this.$router.push({ name: "tasks" });
          })
          .catch((error) => {
            console.log(console.error);
          });
      });
    },
  },
};
</script>
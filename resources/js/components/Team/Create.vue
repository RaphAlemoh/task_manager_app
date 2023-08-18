<template>
  <div>
    <div class="container mt-2">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card">
            <div class="card-header">
              Create Team
              <router-link :to="{ name: 'teams' }" class="float-right"
                >Back</router-link
              >
            </div>

            <div class="card-body">
              <form @submit.prevent="storeTeam">
                <div class="form-group row">
                  <label
                    for="name"
                    class="col-md-4 col-form-label text-md-right"
                    >Team Name</label
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
        name: "",
      },
    };
  },
  created() {
    this.getTeams();
  },
  methods: {
    getTeams() {
      axios
        .get("/api/teams")
        .then((res) => {
          this.teams = res.data.data;
        })
        .catch((error) => {
          console.log(console.error);
        });
    },
    storeTeam() {
      axios
        .post("/api/teams", {
          name: this.form.name,
        })
        .then((res) => {
          this.$router.push({ name: "teams" });
        })
        .catch((error) => {
          console.log(console.error);
        });
    },
  },
};
</script>

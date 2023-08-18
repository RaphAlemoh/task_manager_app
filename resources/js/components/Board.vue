<template>
  <div class="container">
    <div class="row justify-content-center">
      <draggable
        v-model="teams"
        tag="transition-group"
        :component-data="{ name: 'fade' }"
      >
        <template #item="{ element }">
          <div>{{ element.name }}</div>
        </template>
        <template #header>
          <!-- <button @click="addNew(index)">Add</button> -->
        </template>
        <template #footer>
          <!-- <button @click="addPeople">Add</button> -->
        </template>
      </draggable>
    </div>
  </div>
</template>

<style scoped>
.card {
  border: 0;
  border-radius: 0.5rem;
}
.transit-1 {
  transition: all 1s;
}
.small-card {
  padding: 1rem;
  background: #f5f8fa;
  margin-bottom: 5px;
  border-radius: 0.25rem;
}
.card-body-dark {
  background-color: #ccc;
}
textarea {
  overflow: visible;
  outline: 1px dashed black;
  border: 0;
  padding: 6px 0 2px 8px;
  width: 100%;
  height: 100%;
  resize: none;
}
</style>

<script>
import Draggable from "vuedraggable";
export default {
  components: {
    Draggable,
  },
  data() {
    return {
      teams: [],
      editingTask: null,
      list: [
          { name: 'John', id: 1 },
          { name: 'Joao', id: 2 },
          { name: 'Jean', id: 3 },
          { name: 'Gerard', id: 4 },
        ],
    };
  },
  methods: {
    addNew(id) {
      let user_id = 1;
      let name = "New task";
      let team_id = this.teams[id].id;
      let order = this.teams[id].tasks.length;

      axios
        .post("api/tasks", { user_id, name, order, team_id })
        .then((response) => {
          this.teams[id].tasks.push(response.data.data);
        });
    },
    loadTasks() {
      this.teams.map((team) => {
        axios.get(`api/team/${team.id}/tasks`).then((response) => {
          team.tasks = response.data;
        });
      });
    },
    changeOrder(data) {
      let toTask = data.to;
      let fromTask = data.from;
      let task_id = data.item.id;
      let team_id = fromTask.id == toTask.id ? null : toTask.id;
      let order = data.newIndex == data.oldIndex ? false : data.newIndex;

      if (order !== false) {
        axios
          .patch(`api/tasks/${task_id}`, { order, team_id })
          .then((response) => {
            // Do anything you want here
          });
      }
    },
    endEditing(task) {
      this.editingTask = null;
      axios
        .patch(`api/tasks/${task.id}`, { name: task.name })
        .then((response) => {
          // You can do anything you wan't here.
        });
    },

    editTask(task) {
      this.editingTask = task;
    },
  },
  mounted() {
    let token = localStorage.getItem("jwt");
    axios.defaults.headers.common["Content-Type"] = "application/json";
    axios.defaults.headers.common["Authorization"] = "Bearer " + token;

    axios.get("api/teams").then((response) => {
      response.data.forEach((data) => {
        this.teams.push({
          id: data.id,
          name: data.name,
          tasks: [],
        });
      });
      this.loadTasks();
    });
  },
  computed: {
    // dragOptions() {
    //   return {
    //     animation: 1,
    //     group: "description",
    //     ghostClass: "ghost",
    //   };
    // },
  },
  beforeRouteEnter(to, from, next) {
    if (!localStorage.getItem("jwt")) {
      return next("login");
    }
    next();
  },
};
</script>

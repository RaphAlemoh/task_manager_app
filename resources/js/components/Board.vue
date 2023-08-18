<template>
  <div class="container mt-2">
    <div class="row justify-content-end">
      <div class="col-md-6">
        <form>
          <div class="input-group mb-3">
            <input
              type="search"
              v-model.lazy="search"
              class="form-control"
              aria-label="Text input with dropdown button"
            />
            <button
              class="btn btn-outline-secondary dropdown-toggle"
              type="button"
              data-bs-toggle="dropdown"
              aria-expanded="false"
            >
              Teams
            </button>
            <div v-if="teams && teams.length > 0">
              <ul
                class="dropdown-menu dropdown-menu-end"
                v-for="team in teams"
                :key="team.id"
                :value="team.id"
              >
                <li><a class="dropdown-item" href="#">{{ team.name }}</a></li>
              </ul>
            </div>
          </div>
        </form>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-md-12">
        <div class="row">
          <draggable
            v-model="teams"
            tag="transition-group"
            :component-data="{ name: 'fade' }"
            :item-key="id"
            :options="dragOptions"
          >
            <template #item="{ element, index }">
              <div class="col-md-4">
                <div class="card">
                  <div class="card-header">
                    <h4 class="card-title">{{ element.name }}</h4>
                  </div>
                  <div class="card-body card-body-dark">
                    <div class="transit-1">
                      <draggable
                        v-model="element.tasks"
                        tag="transition-group"
                        :component-data="{ name: 'fade' }"
                        :item-key="element.id"
                        :options="dragOptions"
                        @end="changeOrder"
                      >
                        <template #item="{ element }">
                          <div>
                            <div class="small-card">
                              <textarea
                                v-if="element === editingTask"
                                class="text-input"
                                @keyup.enter="endEditing(element)"
                                @blur="endEditing(task)"
                                v-model="element.name"
                              ></textarea>
                              <label
                                for="checkbox"
                                v-if="element !== editingTask"
                                @dblclick="editTask(element)"
                                >{{ element.name }}</label
                              >
                              <div class="form-gorup mb-2">
                                <label>Image</label
                                ><span class="text-danger"> *</span>
                                <input
                                  type="file"
                                  class="form-control mb-2"
                                  v-on:change="onChange"
                                />

                                <div v-if="img">
                                  <img
                                    v-bind:src="imgPreview"
                                    width="100"
                                    height="100"
                                  />
                                </div>
                              </div>
                            </div>
                          </div>
                        </template>
                      </draggable>
                    </div>
                    <div class="small-card">
                      <h5 class="text-center" @click="addNew(index)">
                        + Add new card
                      </h5>
                    </div>
                  </div>
                </div>
              </div>
            </template>
            <template #header>
              <div class="small-card-append">
                <h5 class="text-center">Ellipsis Kanban Board</h5>
              </div>
            </template>
            <template #footer>
              <div class="small-card-append mt-2">
                <h5 class="text-center">Be Organized!</h5>
              </div>
            </template>
          </draggable>
        </div>
      </div>
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

.small-card h5:hover {
  color: green;
  cursor: pointer;
}

.small-card-append {
  padding: 1rem;
  background: #91bddb;
  margin-bottom: 2px;
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
      img: "",
      editingTask: null,
      imgPreview: null,
      search: null,
      selectedTeam: null,
    };
  },
  methods: {
    onChange(e) {
      this.img = e.target.files[0];
      let reader = new FileReader();
      reader.addEventListener(
        "load",
        function () {
          this.imgPreview = reader.result;
        }.bind(this),
        false
      );

      if (this.img) {
        if (/\.(jpe?g|png|gif)$/i.test(this.img.name)) {
          reader.readAsDataURL(this.img);
        }
      }
    },
    addNew(id) {
      let name = "New task";
      let team_id = this.teams[id].id;
      let order = this.teams[id].tasks.length;
      axios
        .post("api/tasks", { name, order, team_id })
        .then((response) => {
          this.teams[id].tasks.push(response.data.data);
        })
        .catch((error) => {
          console.log(error);
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
    dragOptions() {
      return {
        animation: 1,
        group: "description",
        ghostClass: "ghost",
      };
    },
  },
  beforeRouteEnter(to, from, next) {
    if (!localStorage.getItem("jwt")) {
      return next("login");
    }
    next();
  },
};
</script>

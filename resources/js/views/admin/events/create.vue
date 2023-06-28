<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <File
        title="Image"
        field="data.thumb"
        mime="img"
        fileClassName="data.image"
        :req="true"
      />
      <v-select-container field="data.category_id" :req="true" title="Category">
        <v-select
          v-model="data.category_id"
          label="title"
          :reduce="(obj) => obj.id"
          :options="categories"
          placeholder="--Select One--"
          :closeOnSelect="true"
          :req="true"
        ></v-select>
      </v-select-container>
      <Input
        v-model="data.title"
        field="data.title"
        title="Title"
        :req="true"
      />

      <Input
        v-model="data.venue"
        field="data.venue"
        title="Venue"
        :req="false"
      />
      <date-picker
        id="date3"
        field="data.start_date"
        name="start_date"
        v-model="data.start_date"
        title="Start Date"
        placeholder="Start Date"
        :req="true"
        col="3"
      ></date-picker>
      <date-picker
        id="date4"
        field="data.end_date"
        name="end_date"
        v-model="data.end_date"
        title="End Date"
        placeholder="End Date"
        :req="true"
        col="3"
      ></date-picker>
      <Input
        v-model="data.highlighted_text"
        field="data.highlighted_text"
        title="Highlighted Text"
      />

      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        req
        col="2"
      />

      <Radio
        v-model="data.status"
        field="data.status"
        title="Status"
        :list="[
          { value: 'active', title: 'Active' },
          { value: 'deactive', title: 'Deactive' },
        ]"
        :req="true"
        col="2"
      />

      <div class="col-12 mb-3">
        <button
          v-if="data.event_schedules.length == 0"
          type="button pull-right"
          style="padding: 1px 6px !important; min-width: 10px"
          @click.prevent="
            data.event_schedules.push({
              schedule_date: '',
              schedule_time: '',
              title: '',
              description: '',
              status: 'active',
            })
          "
          class="btn btn-info ms-2 mt-3"
        >
          Add Schedule <i class="fa fa-plus"></i>
        </button>

        <div
          class=""
          v-for="(schedule, index) in data.event_schedules"
          :key="index"
        >
          <fieldset>
            <legend>Event Schedule ({{ index + 1 }})</legend>

            <div class="row">
              <date-picker
                :id="'event' + `${index}`"
                :name="`event_schedules[${index}][schedule_date]`"
                v-model="schedule.schedule_date"
                title="Schedule Date"
                placeholder="Schedule Date"
                col="3"
                field="schedule.schedule_date"
              ></date-picker>

              <div class="col-2 mb-3">
                <div class="form-element">
                  <label for="">Schedule Time</label>
                  <input
                    type="time"
                    class="from-control"
                    :name="`event_schedules[${index}][schedule_time]`"
                    v-model="schedule.schedule_time"
                  />
                </div>
              </div>
              <div class="col-2 mb-3">
                <div class="form-element">
                  <label for="">Title</label>
                  <input
                    type="text"
                    class="from-control"
                    placeholder="Enter title"
                    :name="`event_schedules[${index}][title]`"
                    v-model="schedule.title"
                  />
                </div>
              </div>
              <div class="col-2 mb-3">
                <label for="">Status</label><br />
                <div class="form-check form-check-inline mt-3">
                  <input
                    type="radio"
                    class="form-check-input"
                    :name="`event_schedules[${index}][status]`"
                    v-model="schedule.status"
                    :id="'active' + { index }"
                    value="active"
                  /><label :for="'active' + { index }">Active</label>
                </div>
                <div class="form-check form-check-inline">
                  <input
                    type="radio"
                    class="form-check-input"
                    :id="'deactive' + { index }"
                    v-model="schedule.status"
                    :name="`event_schedules[${index}][status]`"
                    value="deactive"
                  /><label :for="'deactive' + { index }">Deactive</label>
                </div>
              </div>
              <!-- add and remove button -->
              <div class="col-2 mt-3">
                <!-- minus button -->
                <button
                  style="padding: 1px 6px !important; min-width: 10px"
                  type="button"
                  @click.prevent="data.event_schedules.splice(index, 1)"
                  v-if="Object.keys(data.event_schedules).length > 1"
                  class="btn btn-danger mt-3"
                >
                  <i class="fa fa-minus"></i>
                </button>
                <!-- plus button -->
                <button
                  type="button"
                  style="padding: 1px 6px !important; min-width: 10px"
                  @click.prevent="
                    data.event_schedules.push({
                      schedule_date: '',
                      schedule_time: '',
                      title: '',
                      description: '',
                      status: 'active',
                    })
                  "
                  class="btn btn-info ms-2 mt-3"
                >
                  <i class="fa fa-plus"></i>
                </button>
              </div>
              <div class="col-12 mb-3">
                <div class="form-element">
                  <label for="">Description</label>
                  <textarea
                    class="form-control"
                    placeholder="Enter description"
                    v-model="schedule.description"
                    :name="`event_schedules[${index}][description]`"
                    rows="3"
                  ></textarea>
                </div>
              </div>
            </div>
          </fieldset>
        </div>
      </div>
      <div class="col-12 mb-3">
        <label class="form-label">Description</label>
        <div class="col-12">
          <editor v-model="data.description" />
        </div>
      </div>
      <div class="col-12 mb-3">
        <label class="form-label">Meta Keywords(Optional)</label>
        <v-select
          taggable
          multiple
          name="meta_tag"
          v-model="data.meta_tag"
          no-drop
        ></v-select>
      </div>
      <div class="col-12 mb-3">
        <div class="form-element">
          <label for="" class="form-label">Meta Description(Optional)</label>
          <textarea
            name="meta_description"
            v-model="data.meta_description"
            class="form-control"
            id=""
            cols="30"
            rows="3"
          ></textarea>
        </div>
      </div>
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
import Editor from "../../../components/Form/CKEditor";

// define model name
const model = "events";

export default {
  components: { Editor },
  data() {
    return {
      model: model,
      data: {
        thumb: "",
        sorting: 0,
        status: "active",
        meta_tag: [],
        event_schedules: [
          {
            // schedule_date: new Date().toISOString().slice(0, 10),
            schedule_date: "",
            schedule_time: "",
            title: "",
            description: "",
            status: "active",
          },
        ],
      },
      image: { thumb: "" },
      categories: [],
    };
  },

  provide() {
    return {
      validate: this.validation,
      data: () => this.data,
      image: this.image,
    };
  },
  methods: {
    submit: function (e) {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
        // If there is an error
        if (error > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
          return false;
        }

        // If there is no error
        if (res) {
          var form = document.getElementById("form");
          var formData = new FormData(form);
          formData.append(
            "description",
            this.data.description ? this.data.description : ""
          );
          formData.append("meta_tag", this.data.meta_tag);
          formData.append("category_id", this.data.category_id);
          if (this.data.id) {
            this.update(this.model, formData, this.data.id, true);
          } else {
            this.store(this.model, formData);
          }
        }
      });
    },
    getEventCategory() {
      axios.get(`get-category/${this.model}`).then((res) => {
        this.categories = res.data;
      });
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create");
      this.get_sorting("Events");
    }
    this.getEventCategory();
  },

  // validation rule for form
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.category_id": function (value = null) {
      return Validator.value(value).required("Category is required");
    },
    "data.thumb": function (value = null) {
      return Validator.value(value)
        .required("Image is required")
        .custom(function () {
          if (!value.type) {
            return false;
          }
          if (!Validator.isEmpty(value)) {
            var type = value.type;
            if (
              type == "image/jpg" ||
              type == "image/jpeg" ||
              type == "image/png"
            ) {
            } else {
              return "Image must be of type .jpg.jpeg.png";
            }
          }
        })
        .custom(function () {
          if (!Validator.isEmpty(value)) {
            var size = value.size;
            if (size > 409600) {
              return "File must be smaller than 400 kb";
            }
          }
        });
    },
    "data.start_date": function (value = null) {
      return Validator.value(value).required("Start date is required");
    },
    "data.end_date": function (value = null) {
      return Validator.value(value).required("End date is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
    },
  },
};
</script>
<style scoped>
fieldset {
  border: 1px solid #cacbcd;
  padding: 6px 10px;
}

fieldset legend {
  width: 10%;
  padding: 0px 7px;
  background: #fff;
  font-size: 16px;
  float: none;
  font-weight: bold;
}
</style>

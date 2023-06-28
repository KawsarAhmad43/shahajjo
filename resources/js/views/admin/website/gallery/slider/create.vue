<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <Input
        v-model="data.title"
        field="data.title"
        title="Title"
        placeholder="Home page slider"
        class="col-lg-9"
        :req="true"
      />

      <!------------ Single Input ------------>
      <v-select-container title="Position" class="col-lg-3">
        <select
          v-model="data.position"
          class="form-select shadow-none"
          aria-label="Default select example"
          required
        >
          <template v-for="(position, index) in sliderPosition" :key="index">
            <option value="" v-if="index === 0">-- Select --</option>
            <option :value="position">
              {{ position }}
            </option>
          </template>
        </select>
      </v-select-container>

      <!------------ Single Input ------------>
      <Input
        type="number"
        v-model="data.width"
        field="data.position"
        title="Image width (PX)"
        placeholder="ex: 1028"
        class="col-lg-4"
        :req="true"
      />

      <!------------ Single Input ------------>
      <Input
        type="number"
        v-model="data.height"
        field="data.position"
        title="Image height (PX)"
        placeholder="ex: 720"
        class="col-lg-4"
        :req="true"
      />

      <Input
        type="number"
        title="Max (Image files)"
        field="data.max_image"
        v-model="data.max_image"
        class="col-lg-4"
        :req="true"
        col="2"
      />

      <Input
        type="number"
        title="Sorting"
        placeholder="512"
        field="data.sorting"
        v-model="data.sorting"
        :req="true"
        col="2"
      />

      <Radio
        v-model="data.status"
        field="data.status"
        title="Status"
        :list="[
          { value: 'active', title: 'Active' },
          { value: 'draft', title: 'draft' },
        ]"
        :req="true"
        col="3"
      />
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "slider";

import Editor from "../../../../../components/Form/CKEditor";

export default {
  components: { Editor },

  data() {
    return {
      model: model,
      data: { status: "active", position: "" },
      image: { slider: "" },
      positions: [],
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
        }

        // If there is no error
        if (res) {
          var form = document.getElementById("form");
          var formData = new FormData(form);

          if (this.data.id) {
            this.update(this.model, this.data, this.data.slug);
          } else {
            this.store(this.model, this.data);
          }
        }
      });
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create");
      this.get_sorting("Website-Gallery-Slider");
    }
  },

  // validation rule for form
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.position": function (value = null) {
      return Validator.value(value).required("Position is required");
    },
    "data.height": function (value = null) {
      return Validator.value(value).required("Image heigt is required");
    },
    "data.width": function (value = null) {
      return Validator.value(value).required("Image width is required");
    },
    "data.max_image": function (value = null) {
      return Validator.value(value).required("Max image file is required");
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

<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <v-select-container
        field="data.module_name"
        :req="true"
        title="Module name"
      >
        <v-select
          v-model="data.module_name"
          label="name"
          :reduce="(obj) => obj.value"
          :options="modules"
          placeholder="--Select One--"
          :closeOnSelect="true"
        ></v-select>
      </v-select-container>
      <Input
        v-model="data.title"
        field="data.title"
        title="Title"
        :req="true"
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
        col="3"
      />
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "category";

export default {
  data() {
    return {
      model: model,
      data: { status: "active" },
      modules: [
        { name: "Notice", value: "notice" },
        { name: "Events", value: "events" },
        { name: "News", value: "news" },
      ],
    };
  },
  provide() {
    return {
      validate: this.validation,
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
          if (this.data.id) {
            this.update(this.model, this.data, this.data.id);
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
    }
  },

  // validation rule for form
  validators: {
    "data.module_name": function (value = null) {
      return Validator.value(value)
        .required("Title is required")
        .maxLength(190);
    },
    "data.title": function (value = null) {
      return Validator.value(value)
        .required("Title is required")
        .maxLength(190);
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
    },
  },
};
</script>

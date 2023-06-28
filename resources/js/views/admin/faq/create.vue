<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <Input
        v-model="data.question"
        field="data.question"
        title="Question"
        :req="true"
        col="12"
      />
      <div class="col-12 mb-3">
        <label class="form-label">Answer</label>
        <div class="col-12">
          <editor v-model="data.answer" />
        </div>
      </div>
      <Input
        title="Sorting"
        v-model="data.sorting"
        field="data.sorting"
        :req="true"
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
      ></Radio>
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
import Editor from "../../../components/Form/CKEditor";

// define model name
const model = "faq";

export default {
  components: { Editor },
  data() {
    return {
      model: model,
      data: { status: "active" },
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
      this.get_sorting("Faq");
    }
  },

  // validation rule for form
  validators: {
    "data.question": function (value = null) {
      return Validator.value(value).required("Question is required");
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status is required");
    },
  },
};
</script>

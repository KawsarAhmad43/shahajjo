<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <Input v-model="data.name" field="data.name" title="Name" :req="false" />
      <Input
        v-model="data.email"
        field="data.email"
        title="Email"
        :req="false"
      />
      <Input
        v-model="data.subject"
        field="data.subject"
        title="Subject"
        :req="false"
      />
      <div class="col-12 mb-3">
        <label class="form-label">Message</label>
        <div class="col-12"><editor v-model="data.message" /></div>
      </div>
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
import Editor from "../../../components/Form/CKEditor";

// define model name
const model = "contacts";

export default {
  components: { Editor },
  data() {
    return {
      model: model,
      data: {},
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
          var form = document.getElementById("form");
          var formData = new FormData(form);
          formData.append("message", this.data.message);
          if (this.data.id) {
            this.update(this.model, formData, this.data.id);
          } else {
            this.store(this.model, formData);
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
  validators: {},
};
</script>

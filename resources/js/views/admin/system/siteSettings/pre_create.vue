<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <Input
        title="Title"
        field="data.title"
        v-model="data.title"
        :req="true"
      />
      <!------------ Single Input ------------>
      <Input
        title="Short Title"
        field="data.short_title"
        v-model="data.short_title"
        :req="true"
      />
      <!------------ Single Input ------------>
      <File
        title="Logo"
        field="data.logo"
        mime="img"
        :req="true"
        fileClassName="file1"
      />
      <!------------ Single Input ------------>
      <File
        title="Logo Small"
        field="data.logo_small"
        mime="img"
        fileClassName="file2"
      />
      <!------------ Single Input ------------>
      <File
        title="Favicon Logo"
        field="data.favicon"
        mime="img"
        fileClassName="file3"
      />
      <!------------ Single Input ------------>
      <Input
        title="Contact Email"
        field="data.contact_email"
        v-model="data.contact_email"
        type="email"
        :req="false"
      />
      <!------------ Single Input ------------>
      <Input
        title="Feedback Email"
        field="data.feedback_email"
        v-model="data.feedback_email"
        type="email"
        :req="false"
      />
      <!------------ Single Input ------------>
      <Input
        title="Mobile One"
        field="data.mobile1"
        v-model="data.mobile1"
        type="number"
        :req="false"
      />
      <!------------ Single Input ------------>
      <Input
        title="Mobile Two"
        field="data.mobile2"
        v-model="data.mobile2"
        type="number"
        :req="false"
      />
      <!------------ Single Input ------------>
      <Input
        title="Address"
        field="data.address"
        v-model="data.address"
        :req="false"
      />
      <Input
        title="Web"
        field="data.web"
        v-model="data.web"
        type="url"
        :req="false"
        col="6"
      />
      <div class="w-100 my-2"></div>
      <Input
        title="Developed By"
        field="data.developed_by"
        v-model="data.developed_by"
        :req="false"
        col="6"
      />
      <Input
        title="Developed By URL"
        field="data.developed_by_url"
        v-model="data.developed_by_url"
        type="url"
        :req="false"
        col="6"
      />
      <Input
        title="Facebook"
        field="data.fb"
        v-model="data.fb"
        type="url"
        :req="false"
      />
      <Input
        title="Twitter"
        field="data.tw"
        v-model="data.tw"
        type="url"
        :req="false"
      />
      <Input
        title="Linkedin"
        field="data.ln"
        v-model="data.ln"
        type="url"
        :req="false"
      />
      <Input
        title="Youtube"
        field="data.yt"
        v-model="data.yt"
        type="url"
        :req="false"
      />
      <Textarea
        title="Map"
        field="data.map"
        v-model="data.map"
        :req="false"
        col="12"
      />
    </div>

    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "siteSetting";

export default {
  data() {
    return {
      model: model,
      data: { logo: "", logo_small: "", favicon: "" },
      image: {},
    };
  },
  provide() {
    return {
      validate: this.validation,
      data: this.data,
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

          this.store(this.model, formData);
        }
      });
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, "edit", "Site Setting");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, "create", "Site Setting");
    }
  },

  // validation rule for form
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.short_title": function (value = null) {
      return Validator.value(value).required("Short Title is required");
    },
    // "data.logo": function (value = null) {
    //   return Validator.value(value).required("Logo is required");
    // },
  },
};
</script>
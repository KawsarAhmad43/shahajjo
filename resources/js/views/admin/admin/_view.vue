<template>
  <view-page></view-page>
</template>

<script>
// define model name
const model = "admin";

export default {
  data() {
    return {
      model: model,
      image: {},
      data: [],
      fileColumns: [],
      password_option: false,
      pass_verify: false,
      change_pass: {},
    };
  },
  methods: {
    updateInformation() {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        if (res) {
          this.$root.submit = true;
          var form = document.getElementById("updateInfoForm");
          var formData = new FormData(form);
          formData.append("_method", "put");
          if (this.image.profile) {
            formData.append("profile", this.image.profile);
          } else {
            formData.append("profile", "");
          }
          axios
            .post("/admin/" + this.$route.params.id, formData)
            .then((res) => {
              this.notification(res.data.message, "success");
              this.get_data(this.model, this.$route.params.id, "data");

              setTimeout(() => {
                profile.dispatch("setProfile", this.data.profile);
              }, 400);
            })
            .catch((error) => console.log(error))
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },
    onFileChange(e, model, fileClass, pdf = null) {
      this.showImage(e, model, model, fileClass, pdf);
    },
    passwordOption(type) {
      this.password_option = type;
    },
    changePassword() {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        if (res) {
          this.$root.submit = true;
          axios
            .post("/change-password", this.change_pass)
            .then((res) => {
              this.notification(res.data.message, "success");
              Admin.logout();
            })
            .catch((error) => console.log(error))
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },
  },
  created() {
    this.change_pass.id = this.$route.params.id;
    this.get_data(`${this.model}/${this.$route.params.id}`); // get data
    this.setBreadcrumbs(this.model, "view"); // Set Breadcrumbs
  },

  // ================== validation rule for form ==================
  validators: {
    "data.name": function (value = null) {
      if (!this.password_option) {
        return Validator.value(value).required("Name is required");
      }
    },
    "data.mobile": function (value = null) {
      if (!this.password_option) {
        return Validator.value(value)
          .digit()
          .regex("01+[0-9+-]*$", "Must start with 01.")
          .minLength(11)
          .maxLength(15);
      }
    },
    "change_pass.old_password": function (value = null) {
      var app = this;
      if (this.password_option) {
        return Validator.value(value)
          .required("Old password is required")
          .minLength(6)
          .custom(function () {
            if (!Validator.isEmpty(value)) {
              app.$root.submit = true;
              axios.post("/check-old-password", app.change_pass).then((res) => {
                if (res.data) {
                  app.pass_verify = true;
                } else {
                  app.pass_verify = false;
                  return "Old password do not match our records!!";
                }
              });
              return Promise.delay(2000).then(function () {
                if (!app.pass_verify) {
                  return "Old password do not match our records!!";
                }
                app.$root.submit = false;
              });
            }
          });
      }
    },
    "change_pass.new_password": function (value = null) {
      if (this.password_option && this.pass_verify) {
        return Validator.value(value)
          .required("New password is required")
          .minLength(6);
      }
    },
    "change_pass.confirm_password, change_pass.new_password": function (
      confirm_password = null,
      new_password = null
    ) {
      if (this.password_option && this.pass_verify) {
        return Validator.value(confirm_password)
          .required("Password confirmation is required")
          .match(new_password);
      }
    },
  },
};
</script>

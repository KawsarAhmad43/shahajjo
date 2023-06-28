<template>
  <div class="content-part">
    <div class="inner-content">
      <slot name="button">
        <AddOrBackButton
          :route="model + '.index'"
          :portion="model"
          :icon="'fas fa-backward'"
        />
      </slot>
      <div class="view-profile">
        <div class="row">
          <div class="col-lg-3">
            <div class="profile-main">
              <div class="profile-image">
                <div class="img position-relative">
                  <center v-if="$root.spinner">
                    <div class="spinner-border mt-5 text-black" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </center>

                  <img
                    v-else
                    :src="data.profile ? data.profile : $root.userimage"
                    alt="Profile"
                    class="img-fluid w-100"
                  />
                  <div class="upload">
                    <input
                      type="file"
                      id="upload"
                      class="d-none"
                      accept="image/*"
                      @change="handleFileUpload"
                    />
                    <label for="upload">
                      <i class="fa fa-cloud-upload upload"></i>
                    </label>
                  </div>
                </div>

                <div class="text mt-4 text-center">
                  <h4>{{ data.name }}</h4>
                </div>
              </div>

              <GlobalCrop
                field="data.profile"
                v-on:update:modelValue="data.profile = $event"
                :image="image.profile"
                :aspectRatio="{ aspectRatio: 800 / 800 }"
                :width="600"
                :height="600"
              ></GlobalCrop>

              <div class="contact-info mt-4">
                <h5>Contact Information</h5>
                <ul>
                  <li>
                    <i class="fa-solid fa-envelope"></i>
                    <span>{{ data.email }}</span>
                  </li>
                  <li>
                    <i class="fa-solid fa-phone"></i>
                    <span> {{ data.mobile }}</span>
                  </li>
                  <li v-if="data.address">
                    <i class="fas fa-map-marker-alt"></i>
                    <span> {{ data.address }} </span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-lg-9">
            <div class="settings-change-password">
              <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                  <button
                    class="nav-link active"
                    id="nav-home-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#nav-home"
                    type="button"
                    role="tab"
                    aria-controls="nav-home"
                    aria-selected="false"
                    @click="passwordOption(false)"
                  >
                    Settings
                  </button>
                  <button
                    class="nav-link"
                    id="nav-profile-tab"
                    data-bs-toggle="tab"
                    data-bs-target="#nav-profile"
                    type="button"
                    role="tab"
                    aria-controls="nav-profile"
                    aria-selected="true"
                    @click="passwordOption(true)"
                  >
                    Change Password
                  </button>
                </div>
              </nav>
              <div class="tab-content" id="nav-tabContent">
                <div
                  class="tab-pane fade active show"
                  id="nav-home"
                  role="tabpanel"
                  aria-labelledby="nav-home-tab"
                >
                  <div class="update-profile-info show">
                    <form
                      @submit.prevent="updateInformation"
                      id="updateInfoForm"
                    >
                      <div class="row">
                        <Input
                          v-model="data.name"
                          field="data.name"
                          title="Name"
                          col="4"
                          :req="true"
                        />
                        <Input
                          v-model="data.mobile"
                          field="data.mobile"
                          title="Mobile"
                          col="4"
                          :req="true"
                        />
                        <Input
                          v-model="data.email"
                          field="data.email"
                          title="Email"
                          col="4"
                          :req="true"
                        />
                      </div>
                      <Button title="Update" process="" />
                    </form>
                  </div>
                </div>
                <div
                  class="tab-pane"
                  id="nav-profile"
                  role="tabpanel"
                  aria-labelledby="nav-profile-tab"
                >
                  <div class="update-profile-info">
                    <form @submit.prevent="changePassword">
                      <div class="row align-items-center">
                        <!------------ Single Input ------------>
                        <Input
                          v-model="change_pass.old_password"
                          field="change_pass.old_password"
                          title="Old password"
                          col="6"
                          :req="true"
                        />
                        <div class="row">
                          <!------------ Single Input ------------>
                          <Input
                            v-model="change_pass.confirm_password"
                            field="change_pass.confirm_password"
                            title="New password"
                            col="6"
                            :req="true"
                          />

                          <!------------ Single Input ------------>
                          <Input
                            v-model="change_pass.new_password"
                            field="change_pass.new_password"
                            title="Confirm password"
                            col="6"
                            :req="true"
                          />
                        </div>
                      </div>
                      <Button title="Update" process="" />
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// define model name
const model = "admin";
import Promise from "bluebird";
export default {
  data() {
    return {
      model: model,
      image: { image: "" },
      data: { profile: "" },
      password_option: false,
      pass_verify: false,
      change_pass: {},
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
            .put("/admin/" + this.$route.params.id, this.data)
            .then((res) => {
              this.$toast(res.data.message, "success");
              this.get_data(this.model, this.$route.params.id, "data");
            })
            .catch((error) => {
              if (error.response && error.response.status === 422) {
                this.$toast(error.response.data.message, "warning");
              } else {
                this.$toast("Something went wrong!", "error");
              }
            })
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },
    handleFileUpload(event) {
      const type = event.target.files[0].type;
      if (
        type !== "image/jpeg" &&
        type !== "image/jpeg" &&
        type !== "image/png"
      ) {
        this.$toast("File must be of type image (.jpg/png)", "error");
        return;
      }

      this.image.profile = event.target.files[0];
      this.data.profile = URL.createObjectURL(this.image.profile);
      this.image.profile = this.data.profile;
      $("#showCropModal").modal("show");
    },
    onFileChange(e, model, fileClass, pdf = null) {
      this.showImage(e, model, model, fileClass, pdf);
    },
    passwordOption(type) {
      this.password_option = type;
    },
    changePassword() {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
        if (error > 0) {
          this.$toast(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
        }

        if (res) {
          this.$root.submit = true;
          axios
            .post("/change-password", this.change_pass)
            .then((res) => {
              this.$toast(res.data.message, "success");
              this.logout();
            })
            .catch((error) => {
              console.log(error);
              if (error.response && error.response.status === 422) {
                this.$toast(error.response.data.message, "warning");
              } else {
                this.$toast("Something went wrong!", "error");
              }
              setTimeout(() => (this.$root.submit = false), 200);
            })
            .then((alw) => setTimeout(() => (this.$root.submit = false), 200));
        }
      });
    },
    async logout() {
      const res = await this.callApi("post", "logout");
      if (res.status == 200) {
        this.$store.dispatch("auth/logout");
        this.$toast(res.data.message, "success");
        window.location.href = this.$root.baseurl + "/admin/nsl-admin";
      }
    },
  },
  created() {
    this.$root.spinner = true;
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
          .custom(function () {});
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

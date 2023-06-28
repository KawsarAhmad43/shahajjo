<template>
  <div class="content-part">
    <div class="inner-content">
      <div class="box box-success" v-if="!$root.spinner">
        <div class="box-header with-border">
          <h3 class="box-title">{{ ucfirst(model) + " File Create" }}</h3>

          <!--============ Add or Back Button Start ============-->
          <div class="box-tools pull-right float-end">
            <router-link
              :to="{
                name: model + '.show',
                params: { slug: $route.params.slug },
              }"
              class="btn btn-xs btn-success pull-left text-white me-2"
              title="View File"
            >
              <i class="fa fa-eye"></i>
              <span class="text-capitalize"> View {{ model }}</span>
            </router-link>
            <router-link
              :to="{ name: model + '.edit' }"
              class="btn btn-xs btn-success pull-left text-white"
              title="Add File"
            >
              <i class="fa fa-plus"></i>
              <span class="text-capitalize"> Edit {{ model }}</span>
            </router-link>
          </div>
          <!--============ Add or Back Button End ============-->
        </div>

        <div class="box-body box-min-height">
          <!--============ Form Start ============-->
          <div class="row justify-content-center">
            <form
              v-on:submit.prevent="submit"
              id="form"
              class="form-row col-5 border border-success p-4 rounded"
            >
              <!------------ Single Input ------------>
              <div
                class="form-row col-12 mb-3"
                :class="{
                  'has-error': validation.hasError('data.title'),
                  'has-success': data.title,
                }"
              >
                <label class="col-3 control-label">Title</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model="data.title"
                    name="title"
                    class="form-control form-control-sm"
                    placeholder="Title"
                  />
                  <span class="help-block">{{
                    validation.firstError("data.title")
                  }}</span>
                </div>
              </div>
              <!------------ Single Input ------------>
              <div
                class="form-row col-12 mb-3"
                :class="{ 'has-error': errors.file, 'has-success': image.file }"
              >
                <label class="col-3">File</label>
                <div class="col-9">
                  <input
                    type="file"
                    accept=".pdf"
                    v-on:change="onFileChange"
                    class="form-control form-control-sm"
                  />
                  <span class="help-block" v-if="errors.file">{{
                    errors.file[0]
                  }}</span>
                </div>
              </div>
              <!------------ Single Input ------------>
              <div
                class="form-row col-12 mb-3"
                :class="{
                  'has-error': validation.hasError('data.sorting'),
                  'has-success': data.sorting,
                }"
              >
                <label class="col-3">Sorting</label>
                <div class="col-9">
                  <input
                    type="text"
                    v-model="data.sorting"
                    name="sorting"
                    class="form-control form-control-sm"
                    placeholder="Sorting"
                  />
                  <span class="help-block">{{
                    validation.firstError("data.sorting")
                  }}</span>
                </div>
              </div>

              <!-------------- button -------------->
              <div class="col-12 mt-4">
                <Button
                  class="btn btn-xs btn-success pull-left text-white me-2"
                  title="Submit"
                  process=""
                />
              </div>
              <!-------------- button -------------->
            </form>
          </div>
          <!--============ Form End ============-->
        </div>
      </div>
    </div>
  </div>
</template>

<script>
// define model name
const model = "content";

export default {
  data() {
    return {
      model: model,
      data: { sorting: 0 },
      image: { file: "" },
      errors: {},
    };
  },
  methods: {
    submit: function () {
      const error = this.validation.countErrors();
      this.$validate().then((res) => {
        // If there is an error
        if (error > 0) {
          this.$toast(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
          return false;
        }

        // If there is no error
        if (res) {
          this.$root.spinner = true;
          var form = document.getElementById("form");
          var formData = new FormData(form);
          if (this.image.file) {
            formData.append("file", this.image.file);
          } else {
            formData.append("file", "");
          }
          axios
            .post("/content-file/" + this.data.slug, formData)
            .then((res) => {
              this.$toast(res.data.message, "success");
              this.$router.push({
                name: "content.show",
                params: { slug: this.$route.params.slug },
              });
            })
            .catch((error) => {
              if (error.response.status === 422) {
                this.errors = error.response.data.errors || {};
                this.$toast(
                  "You need to fill empty mandatory fields",
                  "warning"
                );
              }
            })
            .then((alw) => setTimeout(() => (this.$root.spinner = false), 200));
        }
      });
    },
    onFileChange(e) {
      this.showImage(e, "file", ""); // 1st profile image, second show image
    },
  },
  created() {
    this.data.slug = this.$route.params.slug;
    // set breadcrumb
    // var breadcrumb = [
    //   {
    //     route: model + ".create",
    //     title: model + " Create",
    //     slug: this.$route.params.slug,
    //   },
    //   {
    //     route: model + ".file",
    //     title: model + " File Create ",
    //     slug: this.$route.params.slug,
    //   },
    // ];
    // breadcrumbs.dispatch("setBreadcrumbs", breadcrumb); // Set Breadcrumbs
    setTimeout(() => (this.$root.spinner = false), 200);
  },
  beforeCreate() {
    this.$root.spinner = true;
  },

  // ================== validation rule for form ==================
  validators: {
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
  },
};
</script>

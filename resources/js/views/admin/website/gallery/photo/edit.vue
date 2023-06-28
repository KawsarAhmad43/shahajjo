<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <v-select-container title="Album">
        <v-select
          v-model="data.album_id"
          label="name"
          :reduce="(obj) => obj.id"
          :options="albums"
          placeholder="--Select Any--"
          :closeOnSelect="true"
        ></v-select>
        <span
          v-if="validation.hasError('data.album_id')"
          class="input-message danger"
        >
          {{ validation.firstError("data.album_id") }}
        </span>
      </v-select-container>
      <!------------ Single Input ------------>
      <Input v-model="data.title" field="data.title" title="Title" />
      <!------------ Single Input ------------>
      <File
        title="Image"
        field="data.thumb"
        mime="img"
        fileClassName="file2"
        req
      />
      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        req
        col="2"
      />
    </div>
    <Button title="Submit" process="" />
  </create-form>
</template>

<script>
// define model name
const model = "photo";

export default {
  data() {
    return {
      model: model,
      data: { album_id: null, title: "Test", thumb: "", sorting: 0 },
      image: { thumb: "" },
      albums: {},
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

          formData.append("album_id", this.data.album_id);

          this.update(this.model, formData, this.data.id, "image");
        }
      });
    },
    getAlbum() {
      axios.get("/get-album/Photos").then((res) => (this.albums = res.data));
    },
  },
  created() {
    this.setBreadcrumbs(this.model, "edit");
    this.get_data(`${this.model}/${this.$route.params.id}`);
    this.getAlbum();
  },

  // validation rule for form
  validators: {
    "data.album_id": function (value = null) {
      return Validator.value(value).required("Album is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
  },
};
</script>
<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <v-select-container title="Type" col="2">
        <v-select
          v-model="data.type"
          label="name"
          :reduce="(obj) => obj.value"
          :options="types"
          placeholder="--Select One--"
          :closeOnSelect="true"
          :req="true"
        ></v-select>
      </v-select-container>

      <!------------ Single Input ------------>
      <Input
        v-model="data.name"
        field="data.name"
        title="Name"
        :req="true"
        col="6"
      />
      <!------------ Single Input ------------>
      <File
        title="Image (500kb)"
        field="data.image"
        mime="img"
        fileClassName="file2"
        :req="true"
        :showCrop="true"
      />

      <!------------ Single Input ------------>
      <GlobalCrop
        field="data.image"
        v-on:update:modelValue="data.image = $event"
        :image="image.image"
        :aspectRatio="{ aspectRatio: 800 / 800 }"
        :width="600"
        :height="600"
      ></GlobalCrop>

      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        :req="true"
        col="2"
        type="number"
      />

      <!------------ Single Input ------------>
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
const model = "album";

export default {
  data() {
    return {
      model: model,
      data: { type: "", image: "", sorting: 0, status: "active" },
      image: { image: "" },
      types: [
        { name: "Photos", value: "Photos" },
        { name: "Videos", value: "Videos" },
      ],
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
          formData.append("type", this.data.type);

          if (this.data.id) {
            this.update(this.model, this.data, this.data.slug, "image");
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
      this.get_sorting("Website-News");
    }
  },

  // validation rule for form
  validators: {
    "data.name": function (value = null) {
      return Validator.value(value).required("Name is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
    "data.image": function (value = null) {
      return Validator.value(value)
        .required("Image is required")
        .custom(function () {
          if (Validator.isEmpty(value)) {
            return;
          }

          var type = value.type;
          const size = value.size;
          //   if (
          //     type == "image/jpeg" ||
          //     type == "image/jpg" ||
          //     type == "image/png"
          //   ) {
          //   } else {
          //     return "Image must be of type .jpg .jpeg or .png";
          //   }

          if (size > 500000) {
            return "File must be smaller than 500KB";
          }
        });
    },
  },
};
</script>

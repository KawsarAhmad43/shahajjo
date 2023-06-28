<template>
  <create-form @onSubmit="submit">
    <div class="row align-items-center">
      <!------------ Single Input ------------>
      <date-picker
        id="date"
        v-model="data.date"
        field="data.date"
        name="date"
        title="Date"
        placeholder="Date"
        col="2"
        :req="true"
      >
      </date-picker>
      <!------------ Single Input ------------>
      <v-select-container field="data.category_id" :req="true" title="Category">
        <v-select
          v-model="data.category_id"
          label="title"
          :reduce="(obj) => obj.id"
          :options="categories"
          placeholder="--Select One--"
          :closeOnSelect="true"
          :req="true"
        ></v-select>
      </v-select-container>
      <!------------ Single Input ------------>
      <Input
        v-model="data.title"
        field="data.title"
        title="Title"
        :req="true"
        class="col-lg-6"
      />
      <!------------ Single Input ------------>
      <File
        title="Image"
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
        :aspectRatio="{ aspectRatio: 600 / 600 }"
        :width="600"
        :height="600"
      ></GlobalCrop>

      <!------------ Single Input ------------>
      <div class="col-12 mb-3">
        <label class="form-label">Description</label>
        <div class="col-12">
          <editor v-model="data.description" />
        </div>
      </div>

      <!------------ Single Input ------------>
      <Input
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        :req="true"
        col="2"
        type="number"
      />

      <!-- <div class="form-check form-switch">
        <input
          class="form-check-input"
          type="checkbox"
          checked
          v-model="switchValue"
        />
        <label
          :class="`form-check-label text-capitalize ${
            data.status == 'active' ? 'text-success' : 'text-danger'
          }`"
          for="flexSwitchCheckDefault"
          >{{ data.status }}</label
        >
      </div> -->

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
import Editor from "../../../../components/Form/CKEditor";

const model = "news";

export default {
  components: { Editor },

  data() {
    return {
      switchValue: false,
      model: model,
      data: { image: "", sorting: 0, status: "draft" },
      image: {},
      categories: [],
    };
  },
  provide() {
    return {
      validate: this.validation,
      data: () => this.data,
      image: this.image,
    };
  },
  watch: {
    switchValue(newData, oldData) {
      if (newData) {
        this.data.status = "active";
      } else {
        this.data.status = "draft";
      }
    },
  },
  methods: {
    submit: function (e) {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();

        if (error > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
        }

        if (res) {
          var form = document.getElementById("form");
          var formData = new FormData(form);
          formData.append("description", this.data.description);

          if (this.data.id) {
            this.update(this.model, this.data, this.data.slug);
          } else {
            this.store(this.model, this.data);
          }
        }
      });
    },
    getNewsCategory() {
      axios.get(`get-category/${this.model}`).then((res) => {
        this.categories = res.data;
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
    this.getNewsCategory();
  },

  validators: {
    "data.date": function (value = null) {
      return Validator.value(value).required("Date is required");
    },
    "data.category_id": function (value = null) {
      return Validator.value(value).required("Category is required");
    },
    "data.title": function (value = null) {
      return Validator.value(value).required("Title is required");
    },
    "data.image": function (value = null) {
      return Validator.value(value).required("Image is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
  },
};
</script>

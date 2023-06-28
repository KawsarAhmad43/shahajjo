<template>
  <create-form @onSubmit="submit">
    <!------------ Back button ------------>
    <template v-slot:button>
      <AddOrBackButton
        :route="'slider' + '.index'"
        :portion="slider"
        :icon="'fas fa-backward'"
      />
    </template>

    <!------------ Single Input ------------>
    <div class="row align-items-center">
      <File
        title="Slider"
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
        :aspectRatio="{ aspectRatio: this.slider.width / this.slider.height }"
        :width="this.slider.width"
        :height="this.slider.height"
      ></GlobalCrop>

      <!------------ Single Input ------------>
      <input name="slider_id" v-model="slider_id" hidden />

      <!------------ Single Input ------------>
      <v-select-container title="Has Button">
        <select
          v-model="data.has_button"
          class="form-select shadow-none"
          aria-label="Default select example"
          required
        >
          <option value="" v-if="data.has_button == ''" selected>
            -- Select --
          </option>
          <option value="Yes">Yes</option>
          <option value="No">No</option>
        </select>
      </v-select-container>

      <!------------ Single Input ------------>
      <v-select-container title="Button type" v-if="data.has_button === 'Yes'">
        <select
          v-model="data.button_type"
          class="form-select shadow-none"
          aria-label="Default select example"
          required
        >
          <template v-for="(type, index) in sliderButtonTypes" :key="index">
            <option value="" v-if="index === 0">-- Select --</option>
            <option :value="type">
              {{ type }}
            </option>
          </template>
        </select>
      </v-select-container>

      <!------------ Single Input ------------>
      <Input
        v-if="
          data.has_button !== 'No' && data.has_button !== '' && data.type !== ''
        "
        type="name"
        v-model="data.button_name"
        field="data.button_name"
        title="Button name"
      />

      <!------------ Single Input ------------>
      <Input type="url" v-model="data.url" field="data.position" title="URL" />

      <!------------ Single Input ------------>
      <div class="col-12">
        <label class="form-label">Description</label>
        <div class="col-12">
          <editor v-model="data.description" />
        </div>
      </div>

      <!------------ Single Input ------------>
      <Input
        type="number"
        title="Sorting"
        field="data.sorting"
        v-model="data.sorting"
        :req="true"
        col="2"
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
import Editor from "../../../../../../components/Form/CKEditor";
const model = "slider-details";
export default {
  components: { Editor },
  data() {
    return {
      model: model,
      data: {
        image: "",
        button_type: "",
        button_name: "",
        slider_id: this.$route.params.id,
        has_button: "No",
        status: "active",
        url: "",
      },
      image: { image: "" },
      slider: {
        width: "600",
        height: "600",
      },
      positions: [],
    };
  },
  watch: {
    "data.has_button"(current, old) {
      if (current == "No") {
        this.data.button_type = "";
        this.data.button_name = "";
      }
    },
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

        // Check if there is error
        if (error > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            "You need to fill " + error + " more empty mandatory fields",
            "warning"
          );
        }

        // Store
        if (res) {
          var form = document.getElementById("form");
          var formData = new FormData(form);

          formData.append("description", this.data.description);
          formData.append("slider_id", this.data.slider_id);

          if (this.data.id) {
            this.update(
              this.model,
              this.data,
              this.data.id,
              null,
              "slider.show",
              this.data.slider_id
            );
          } else {
            this.store(
              this.model,
              this.data,
              "slider.show",
              this.data.slider_id
            );
          }
        }
      });
    },
    getSliderHeightWidth(id) {
      axios
        .get(`slider-height-width/${id}`)
        .then((res) => (this.slider = res.data));
    },
  },

  created() {
    if (this.$route.params.id) {
      this.data.slider_id = this.$route.params.id;
      this.getSliderHeightWidth(this.$route.params.id);
      //   this.setBreadcrumbs(this.model, "Edit");
      this.get_sorting("SliderDetails");
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.data.slider_id = this.$route.query.id;
      this.getSliderHeightWidth(this.$route.query.id);
      this.setBreadcrumbs(this.model, "create");
      this.get_sorting("SliderDetails");
    }
  },

  // Validation
  validators: {
    "data.slider_id": function (value = null) {
      return Validator.value(value).required("Slider is required");
    },
    "data.has_button": function (value = null) {
      const vm = this;
      return Validator.value(value).custom(function (value) {
        if (vm.data.has_button === "Yes" && vm.data.button_type === "") {
          vm.$toast("Button type is required", "warning");
        }
      });
    },
    "data.button_type": function (value = null) {
      const vm = this;
      return Validator.value(value).custom(function (value) {
        if (vm.data.has_button === "Yes" && vm.data.button_type === "") {
          vm.$toast("Button type is required", "warning");
        }
      });
    },
    "data.button_name": function (value = null) {
      const vm = this;
      return Validator.value(value).custom(function (value) {
        if (vm.data.button_name === "" && vm.data.has_button === "Yes") {
          vm.$toast("Button name is required", "warning");
        }
      });
    },
    "data.url": function (value = null) {
      const vm = this;
      return Validator.value(value).custom(function (value) {
        if (vm.data.has_button !== "No" && vm.data.url == "") {
          vm.$toast("URL is required", "warning");
        }
      });
    },
    "data.image": function (value = null) {
      return Validator.value(value).required("Image is required");
    },
    "data.status": function (value = null) {
      return Validator.value(value).required("Status width is required");
    },
    "data.sorting": function (value = null) {
      return Validator.value(value).required("Sorting is required");
    },
  },
};
</script>

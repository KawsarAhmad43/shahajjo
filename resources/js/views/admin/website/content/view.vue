<template>
  <div class="content-part">
    <div class="inner-content">
      <div class="box box-success" v-if="!$root.spinner">
        <div class="box-header with-border">
          <h3 class="box-title">{{ ucfirst(model) + " View" }}</h3>

          <!--============ Add or Back Button Start ============-->
          <div class="box-tools pull-right float-end">
            <router-link
              :to="{ name: model + '.edit' }"
              class="btn btn-xs btn-success pull-left text-white me-2"
              title="Add File"
            >
              <i class="fa fa-plus"></i>
              <span class="text-capitalize"> Update {{ model }}</span>
            </router-link>
            <router-link
              :to="{ name: model + '.file' }"
              class="btn btn-xs btn-success pull-left text-white"
              title="Add File"
            >
              <i class="fa fa-plus"></i>
              <span class="text-capitalize"> Add {{ model }} File</span>
            </router-link>
          </div>
          <!--============ Add or Back Button End ============-->
        </div>

        <div class="box-body mt-5">
          <h5>{{ data.title }}</h5>
          <div class="row mt-3" style="text-align: justify">
            <div class="col-9" v-html="data.description"></div>
            <div class="col-3">
              <img class="img-width" :src="data.image" />
            </div>
          </div>
        </div>
      </div>

      <!-- content file -->
      <slot v-if="data && data.content_files">
        <div
          class="box box-success"
          v-if="Object.keys(data.content_files).length > 0"
        >
          <div class="box-header with-border">
            <h3 class="box-title">{{ model + " File" }}</h3>
          </div>

          <div class="box-body">
            <table class="table table-bordered table-hover table-striped">
              <thead>
                <tr>
                  <th class="sl">#</th>
                  <th>Title</th>
                  <th class="action">File</th>
                </tr>
              </thead>
              <tbody>
                <slot v-for="(dataFile, index) in data.content_files">
                  <tr :key="index">
                    <td class="text-center">{{ index + 1 }}</td>
                    <td>{{ dataFile.title }}</td>
                    <td class="action">
                      <a
                        target="_blank"
                        :href="
                          $root.baseurl + '/public/storage/' + dataFile.file
                        "
                        class="btn btn-sm btn-success action-view me-2"
                      >
                        <i class="fa fa-eye"></i>
                      </a>
                      <button
                        v-if="$root.checkPermission('content.destroy')"
                        v-on:click="destroy(dataFile.id)"
                        class="btn btn-sm btn-danger"
                        title="Delete"
                      >
                        <i class="fa fa-trash"></i>
                      </button>
                    </td>
                  </tr>
                </slot>
              </tbody>
            </table>
          </div>
        </div>
      </slot>
      <!-- content file -->
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
      data: [],
    };
  },
  methods: {
    destroy(id) {
      if (confirm("Are you sure want to delete?")) {
        this.$root.spinner = true;
        axios
          .delete("/" + this.model + "/" + id)
          .then((res) => {
            this.get_data(this.model, this.$route.params.slug, "data"); // get data
            this.notification(res.data.message, "success");
          })
          .catch((error) => console.log(error))
          .then((alw) => setTimeout(() => (this.$root.spinner = false), 200));
      }
    },
  },
  created() {
    this.get_data(`${this.model}/${this.$route.params.slug}`);
  },
};
</script>

<style scoped>
.img-width {
  width: 80% !important;
  max-width: 100% !important;
}
</style>

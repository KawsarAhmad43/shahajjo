<template>
  <view-page :defaultTable="false">
    <div class="row justify-content-center">
      <div class="col-md-7">
        <div class="box box-success">
          <p class="text-center p-2">
            A description of all necessary step of creating
            <span class="text-red font-weight-bold">module</span> is given below
            <span class="text-maroon font-weight-bold"
              >(Please, follow these instruction)</span
            >
          </p>
        </div>
        <!-- /.box -->
      </div>
    </div>

    <!-- ==================== File Create ==================== -->
    <section class="content text-dark" v-if="!$root.spinner">
      <!-- row -->
      <div class="row">
        <div class="col-md-12">
          <!-- The time line -->
          <ul class="timeline">
            <!-- Laravel Route item -->
            <li>
              <i class="fa fa-folder bg-navy"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  <b>Laravel Route:</b>
                  Copy the newly created route in 'admin.php' into 'auth:acces'
                  block
                </h3>
              </div>
            </li>
            <!-- END Laravel Route item -->
            <!-- Vue Route item -->
            <li>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  <b>Vue Route:</b>
                  <span class="text-maroon font-weight-bold"
                    >resources/js/Router/router.js</span
                  >
                </h3>
                <div class="timeline-body">
                  Please copy below routes into router/index.js
                  <br />
                  // ------------------<span class="text-uppercase"
                    >{{ data.name }} PORTION</span
                  >------------------
                  <br />
                  <span class="text-maroon">
                    { path: '/{{ data.route }}', name: '{{ data.route }}.index',
                    component: () => import('./../views/admin/{{
                      data.route
                    }}/index')},
                    <br />
                    { path: '/{{ data.route }}/create', name: '{{
                      data.route
                    }}.create', component: () => import('./../views/admin/{{
                      data.route
                    }}/create')},
                    <br />
                    { path: '/{{ data.route }}/:id', name: '{{
                      data.route
                    }}.show', component: () => import('./../views/admin/{{
                      data.route
                    }}/view')},
                    <br />
                    { path: '/{{ data.route }}/:id/edit', name: '{{
                      data.route
                    }}.edit', component: () => import('./../views/admin/{{
                      data.route
                    }}/create')},
                    <br />
                  </span>
                </div>
              </div>
            </li>
            <!-- END Vue Route item -->
            <!-- Database item -->
            <li>
              <i class="fa fa-folder bg-purple"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  <b>Database:</b>
                  <span class="text-success font-weight-bold">{{
                    data.database
                  }}</span>
                </h3>
                <div class="timeline-body">
                  add your needed field in
                  <span class="text-maroon font-weight-bold">migration</span>
                  file, and run this command
                  <span class="text-maroon font-weight-bold"
                    >php artisan migrate</span
                  >
                </div>
              </div>
            </li>
            <!-- END Database item -->
            <!-- view File item -->
            <li>
              <i class="fa fa-folder bg-success text-white"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  <b>Vue File:</b>
                  <span class="text-success font-weight-bold">{{
                    data.vue_file
                  }}</span>
                </h3>
                <div class="timeline-body">
                  Customize your
                  <b class="text-maroon">Create.vue</b> form as the requirement
                  <br />
                  <span class="text-maroon">
                    please provide validation rule for each and every field
                  </span>
                </div>
              </div>
            </li>
            <!-- END Vue File item -->
            <!-- Controller item -->
            <li>
              <i class="fa fa-folder bg-blue"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  <b>Controller:</b>
                  <span class="text-success font-weight-bold">{{
                    data.controller
                  }}</span>
                </h3>
                <!-- <div class="timeline-body">
                  If this line does not exist :
                  <span
                    class="text-maroon font-weight-bold"
                  >use App\Http\Controllers\Controller;</span>
                  You just comment out of this line or
                  <b
                    class="text-maroon"
                  >remove this</b>
                </div>-->
              </div>
            </li>
            <!-- END Controller item -->
            <!-- model item -->
            <li>
              <i class="fa fa-folder bg-primary text-white"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  <b>Model:</b>
                  <span class="text-success font-weight-bold">
                    {{ data.model }}
                  </span>
                </h3>
              </div>
            </li>
            <!-- END model item -->
            <!-- Resource item -->
            <li>
              <i class="fa fa-folder bg-teal"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  <b>Resource:</b>
                  <span class="text-success font-weight-bold">
                    {{ data.resource }}
                  </span>
                </h3>
              </div>
            </li>
            <!-- END Resource item -->
            <!-- Setting item -->
            <li>
              <i class="fa fa-cogs bg-purple text-white"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  For menu and system update, Click below button<br />
                  <a
                    @click="systemRoleUpdate"
                    class="btn btn-xs mr-2 btn-success pull-left text-white"
                  >
                    <i class="fa fa-refresh"></i>
                    <span class="text-capitalize">Update System Role</span>
                  </a>
                  <a
                    target="_blank"
                    :href="$root.baseurl + '/clear'"
                    class="btn btn-xs mr-2 btn-danger pull-left text-white"
                  >
                    <i class="fa fa-refresh"></i>
                    <span class="text-capitalize">Clear</span>
                  </a>
                </h3>
                <div class="timeline-body">
                  Please add this menu to seeder file for backup
                  <b class="text-success">database/seeders/MenuSeeder.php</b>
                  <br />
                  Your menu has been created and the
                  <b class="text-success">{{ data.name }}</b> menu is at the top
                  of the <b class="text-success">Dashboard</b> menu. You will
                  see after reloading. <br />Finally reload the browser
                  <b class="text-maroon">( ctrl + f5 )</b>.
                </div>
              </div>
            </li>

            <!-- END Setting item -->
            <!-- Setting item -->
            <li>
              <i class="fa fa-thumbs-up bg-blue text-white"></i>
              <div class="timeline-item">
                <h3 class="timeline-header no-border">
                  If you complete all the processes then your module is ready to
                  work
                  <br />
                  <br />
                  <b class="text-success">Congrats !!</b>
                  Go ahead
                </h3>
              </div>
            </li>
            <!-- END Setting item -->
            <li>
              <i class="fa fa-circle-o-notch bg-red"></i>
            </li>
          </ul>
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
  </view-page>
</template>

<script>
// define model name
const model = "module";
// set breadcrumb
const breadcrumb = [
  { route: "module.create", title: "Module Create" },
  { route: "module.index", title: "Module Post Installation Guide" },
];

export default {
  data() {
    return {
      model: model,
      data: {},
    };
  },
  methods: {
    getRules: function () {
      this.$root.spinner = true;
      axios
        .get("/module/create", {
          params: { model_name: this.$route.params.model },
        })
        .then((res) => (this.data = res.data))
        .catch((error) => console.log(error))
        .then((alw) => setTimeout(() => (this.$root.spinner = false), 300));
    },
    systemRoleUpdate() {
      axios.get("/systems-update").then((res) => {
        this.$toast(res.data.message, "success");
      });
    },
  },
  created() {
    this.getRules(); // get rules
    this.$store.dispatch("breadcrumb/storeLevels", breadcrumb);
    console.log(this.$route.params.model);
  },
};
</script>

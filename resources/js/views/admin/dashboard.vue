<template>
  <div class="content-part" v-if="!$root.spinner">
    <div class="top-short-summery">
      <div class="row">
        <template v-for="(menu, index) in data.dashboardMenus" :key="index">
          <div class="col-lg-6 col-xl-3 col-xxl-3 col-md-6">
            <div class="summery-item">
              <h4 class="text-capitalize">{{ menu.parent_title }}</h4>
              <h3 class="counter text-capitalize">{{ menu.menu_name }}</h3>
              <ul>
                <li>
                  <span
                    ><i class="bi bi-arrow-up"></i>Sorting :
                    {{ menu.sorting }}</span
                  >
                </li>
              </ul>
              <div class="circle">
                <span v-html="menu.icon"> </span>
              </div>
            </div>
          </div>
        </template>
      </div>
    </div>
    <div class="details-info">
      <div class="row">
        <div class="col-lg-12 col-xl-5 col-xxl-5">
          <div class="projects">
            <div class="title">
              <h4>Login Information</h4>
            </div>
            <div class="project-table table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Login At</th>
                    <th>Login Ip</th>
                    <th>Browser</th>
                  </tr>
                </thead>
                <tbody style="border-top: 0">
                  <template v-if="Object.keys(data.loginHistories).length > 0">
                    <template
                      v-for="(history, index) in data.loginHistories"
                      :key="index"
                    >
                      <tr>
                        <td>{{ ++index }}</td>
                        <td>{{ history.user.name }}</td>
                        <td>{{ $filter.enFormat(history.login_at) }}</td>
                        <td>{{ history.login_ip }}</td>
                        <td>{{ history.login_browser_client }}</td>
                      </tr>
                    </template>
                  </template>
                  <template v-else>
                    <tr>
                      <td colspan="6">
                        <p class="text-center">No data available</p>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="col-lg-12 col-xl-7 col-xxl-7">
          <div class="projects">
            <div class="title">
              <h4>Recent Activity</h4>
            </div>
            <div class="project-table table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Log Name</th>
                    <th>Event Name</th>
                    <th>Description</th>
                    <th>Created at</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody style="border-top: 0">
                  <template v-if="Object.keys(data.activities).length > 0">
                    <template
                      v-for="(activity, index) in data.activities"
                      :key="index"
                    >
                      <tr>
                        <td>{{ ++index }}</td>
                        <td>{{ activity.log_name }}</td>
                        <td>{{ activity.event }}</td>
                        <td>{{ activity.description }}</td>
                        <td>{{ $filter.enFormat(activity.created_at) }}</td>
                        <td>
                          <a
                            :href="`${$root.baseurl}/activityLog/${activity.id}`"
                          >
                            <span class="delete view"
                              ><i class="fa-solid fa-eye"></i
                            ></span>
                          </a>
                        </td>
                      </tr>
                    </template>
                  </template>
                  <template v-else>
                    <tr>
                      <td colspan="6">
                        <p class="text-center">No data available</p>
                      </td>
                    </tr>
                  </template>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      data: {
        dashboardMenus: {},
        activities: {},
        loginHistories: {},
      },
    };
  },
  methods: {
    getDashboardData() {},
  },
  mounted() {
    var breadcrumb = [{ route: "dashboard", title: "Dashboard" }];
    this.$store.dispatch("breadcrumb/storeLevels", breadcrumb);
  },
  created() {
    this.get_data("dashboard");
  },
};
</script>

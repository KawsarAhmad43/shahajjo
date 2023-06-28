export default {
    methods: {
        // get pagination data
        get_paginate(url, params = null, allData = null,) {
            this.$root.spinner = allData ? true : false;
            this.$root.tableSpinner = true;

            let apiUrl = `${laravel.baseurl}/${url}`;

            if (this.$route.query.page) {
                apiUrl = url + "?page=" + this.$route.query.page;
            }

            if (params.field_name && params.value || this.$route.query.page !== 1) {
                apiUrl = url + "?page=" + 1;
            } else {
                apiUrl = url + "?page=" + this.$route.query.page;
            }

            axios
                .get(apiUrl, { params: params })
                .then((res) => {
                    if (allData) {
                        this.extraData[allData] = res.data;
                    } else {
                        this.table['datas'] = res.data.data;
                        this.table['meta'] = res.data.meta;
                        this.table['links'] = res.data.links;
                    }
                    setTimeout(() => {
                        this.$root.spinner = false
                        this.$root.tableSpinner = false
                    }, 200);
                })
                .catch(error => {
                    this.$root.spinner = false
                    this.$root.tableSpinner = false
                })
        },

        // get single data
        get_data(url, dataVar = null) {
            this.$root.spinner = true;
            axios
                .get(`${laravel.baseurl}/${url}`,)
                .then((res) => {
                    if (dataVar) {
                        this.obj[dataVar] = res.data;
                    } else {
                        this.data = res.data;
                    }
                    setTimeout(() => this.$root.spinner = false, 200);
                })
                .catch(error => this.$root.spinner = false)
        },

        // Get Promise Request
        callApi(method, url, dataObj = null) {
            this.$root.spinner = true;
            try {
                return axios({
                    method: method,
                    url: `${laravel.baseurl}/${url}`,
                    data: dataObj,
                })
            } catch (e) {
                return e.response;
            }
        },

        // get sorting
        get_sorting(namespace) {
            try {
                axios.get("/get-last-sorting", { params: { model: namespace } })
                    .then(res => {
                        if (res.data) {
                            this.data['sorting'] = res.data;
                        }
                    })
            } catch (e) {
                return e.response;
            }
        },

        // store data
        store(model_name, data, redirect = null, params=null) {
            this.$root.validation_errors = {};
            this.$root.submit = true;
            axios.post("/" + model_name, data)
                .then(res => {
                    if (res.status == 201) {
                        this.$toast(res.data.message, "success");
                    } else if (res.status == 202) {
                        this.$toast(res.data.message, "error");
                    } else if (res.status == 203) {
                        this.$toast(res.data.message, "warning");
                    }

                    let url = redirect ? redirect : model_name + '.index';

                    if (params) {
                        this.$router.push({ name: url, params: { id: params } });
                        return;
                    }

                    this.$router.push({ name: url, });
                })
                .catch(error => {
                    console.log(error);
                    if (error.response.status === 422) {
                        $("#validateModal").modal("show");
                        if (error.response.data.exception) {
                            this.$root.exception_errors = error.response.data.exception
                        } else {
                            this.$root.validation_errors = error.response.data.errors || {};
                        }

                        this.$toast("You need to fill empty mandatory fields", "warning");
                    }
                })
                .then(alw => setTimeout(() => (this.$root.submit = false), 100));
        },

        // update data
        update(model_name, data, id, image = null, redirect = null,params=null) {
            this.$root.validation_errors = {};
            this.$root.submit = true;
            if (image) {
                data.append("_method", "put");
                axios.post("/" + model_name + "/" + id, data)
                    .then(res => {
                        if (res.status == 201) {
                            this.$toast(res.data.message, "success");
                        } else if (res.status == 202) {
                            this.$toast(res.data.message, "error");
                        } else if (res.status == 203) {
                            this.$toast(res.data.message, "warning");
                        }

                        setTimeout(() => $(".update_item" + id).addClass("sorting-success"), 1000);
                        setTimeout(() => $(".update_item" + id).removeClass("sorting-success"), 6000);

                        let url = redirect ? redirect : model_name + '.index';

                        if (params) {
                            this.$router.push({ name: url, params: { id: params } });
                            return;
                        }

                      this.$router.push({ name: url, query: { page: this.$route.query.page, id: id }, })

                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            $("#validateModal").modal("show");
                            if (error.response.data.exception) {
                                this.$root.exception_errors = error.response.data.exception
                            } else {
                                this.$root.validation_errors = error.response.data.errors || {};
                            }
                            this.$toast("You need to fill empty mandatory fields", "warning");
                        }
                    })
                    .then(alw => setTimeout(() => (this.$root.submit = false), 400));
            }
            else {
                axios.put("/" + model_name + "/" + id, data)
                    .then(res => {
                        if (res.status == 201) {
                            this.$toast(res.data.message, "success");
                        } else if (res.status == 202) {
                            this.$toast(res.data.message, "error");
                        } else if (res.status == 203) {
                            this.$toast(res.data.message, "warning");
                        }

                        setTimeout(() => $(".update_item" + id).addClass("sorting-success"), 1000);
                        setTimeout(() => $(".update_item" + id).removeClass("sorting-success"), 6000);

                        let url = redirect ? redirect : model_name + '.index';
                        this.$router.push({ name: url, query: { page: this.$route.query.page, id: id }, })
                    })
                    .catch(error => {
                        if (error.response.status === 422) {
                            $("#validateModal").modal("show");
                            if (error.response.data.exception) {
                                this.$root.exception_errors = error.response.data.exception
                            } else {
                                this.$root.validation_errors = error.response.data.errors || {};
                            }
                            this.$toast("You need to fill empty mandatory fields", "warning");
                        }
                    })
                    .then(alw => setTimeout(() => (this.$root.submit = false), 400));
            }
        },

        // destroy data
        destroy_data(model_name, id, search_data=null) {
            this.$root.tableSpinner = true;
            let url = model_name + "/" + id;
            axios
                .delete(`${laravel.baseurl}/${url}`)
                .then(res => {
                    this.scrollTop(0, 0);
                    if (search_data) {
                        this.get_paginate(model_name, search_data)
                    }

                    if (res.status == 201) {
                        this.$toast(res.data.message, "success");
                        return true;
                    } else if (res.status == 202) {
                        this.$toast(res.data.message, "error");
                    }
                })
                .catch(error => console.log(error))
                .then(alw => setTimeout(() => (this.$root.tableSpinner = false), 200));
        },

        // get route name
        getRouteName(model) {
            this.table.routes = {
                view: model + ".show",
                edit: model + ".edit",
                destroy: model + ".destroy"
            };
        },

    }
}

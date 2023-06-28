
import toast from "izitoast";
import 'izitoast/dist/css/iziToast.min.css'

export default {
    install: function (app) {
        app.config.globalProperties.toast = toast;

        // mixin 
        app.mixin({
            methods: {
                $toast(message, type, title = '') {
                    this.toast[type]({
                        title: title ? title : type.toUpperCase() + " !!",
                        message,
                    });
                }
            },
        })
    }
};

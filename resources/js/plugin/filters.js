import moment from "moment"

let filters = {
    enFormat(value, format = 'll') {
        moment.locale('en-gb');
        return moment(String(value)).format(format)
    },
    capitalize(str) {
        if (!str) return '-';
        return String(str)
            .replace(/and/ig, '&')
            .replace(/\-|\_/ig, ' ')
            .replace(/([A-Z][^A-Z]+)/g, ' $1')
            .split(' ')
            .map((x) => x.charAt(0).toUpperCase() + x.slice(1))
            .join(' ');
    },
}

export default {
    install: function (app) {
        app.config.globalProperties.$filter = filters;
    }
};

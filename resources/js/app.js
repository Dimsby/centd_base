Vue.component('loader', require('./components/utils/loader.vue').default);

const App = new Vue({
    el: '#app',
    mixins: [mix],
    mounted() {
        this.enableInterceptor()
    },
    data: {
        isLoading: false,
        axiosInterceptor: null
    },
    methods: {
        enableInterceptor() {
            this.axiosInterceptor = window.axios.interceptors.request.use((config) => {
                this.isLoading = true;
                return config;
            }, (error) => {
                this.isLoading = false;
                return Promise.reject(error);
            });

            window.axios.interceptors.response.use((response) => {
                this.isLoading = false;
                return response;
            }, function(error) {
                this.isLoading = false;
                window.scrollTo(0, 0);
                return Promise.reject(error);
            })
        },

        disableInterceptor() {
            window.axios.interceptors.request.eject(this.axiosInterceptor)
        },
    },
});

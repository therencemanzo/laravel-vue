import { reactive } from "vue";
import axios from "axios";


export const store = reactive({
    isLoggedIn: !!localStorage.getItem('access_token'),
    user: {},
    loads: false,
    login() {
        
        axios.defaults.headers.common['Authorization'] = `Bearer ${localStorage.getItem('access_token')}`;
        this.isLoggedIn = true
    },
    logout() {
        this.isLoggedIn = false
    },
    setUser(user) {
        this.user = user
    },
    clearUser() {
        this.user = {}
    },
    showLoader(){
        this.loads = true;
    },
    hideLoader(){
        this.loads = false;
    }
})

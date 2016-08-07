// require dependencies
window.$ = window.jQuery = require('jquery');
require('bootstrap-sass');

$( document ).ready(function() {
    console.log($.fn.tooltip.Constructor.VERSION);
});

var Vue = require('vue');

var vueResource = require('vue-resource');

Vue.use(vueResource);

// Laravel CSRF protection
Vue.http.headers.common['X-CSRF-TOKEN'] = document.querySelector('#token').getAttribute('content');
Vue.http.options.emulateJSON = true;

//import Alerts from './components/Alert.vue';
import Inputs from './components/Input.vue';
import Follow from './components/FollowTopic.vue';
import LeaveInput from './components/LeaveInput.vue';
import User from './components/User.vue';
import Topics from './components/Topics.vue'




new Vue({
    el:'#app',
    components: {
        Inputs,
        Follow,
        LeaveInput,
        User,
        Topics
    },
    ready() {

    }
});
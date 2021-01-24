import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state:{
         username : '',
         login:0,
         type:'',
         id:'',
    }
})

export default store

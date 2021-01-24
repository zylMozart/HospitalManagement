import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'
import home from '@/components/home'
import about from '@/components/about'
import login from '@/components/login'
import register from '@/components/Register'
import profile from '@/components/Profile'
import index from '@/components/index'
import alarm from '@/components/Alarm'
import diagnosis from '@/components/diagnosis'

import User from '@/components/User'
import Warning from '@/components/Warning'
import Log from '@/components/Log'
import Report from '@/components/Report'
import Sign from '@/components/Sign'
import SignStatic from '@/components/SignStatic'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'index',
      component: index
    },
    {
      path: '/home',
      name: 'home',
      component: home
    },
    {
      path: '/about',
      name: 'about',
      component: about
    },
    {path: '/index',name: 'index',component: index},
    {path: '/login',name: 'login',component: login},
    {path: '/register',name: 'register',component: register},
    {path: '/profile',name: 'profile',component: profile},
    {path: '/alarm',name: 'alarm',component: alarm},
    {path: '/diagnosis',name: 'diagnosis',component: diagnosis},
    { 
      path: '/admin/sign',
      name: 'Sign', 
      component: Sign 
    },
    { 
      path: '/admin/signstatic',
      name: 'SignStatic', 
      component: SignStatic 
    },
    { path: '/admin/user', name: 'User', component: User },
    { path: '/admin/warning', name: 'Warning', component: Warning },
    { path: '/admin/log', name: 'Log', component: Log },
    { path: '/admin/report', name: 'Report', component: Report },

  ]
})

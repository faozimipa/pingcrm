import {InertiaApp} from '@inertiajs/inertia-vue'
// import Permissions from './Mixins/Permissions'
import PortalVue from 'portal-vue'
import Vue from 'vue'

Vue.config.productionTip = false
Vue.mixin({methods: {route: window.route}})
Vue.use(InertiaApp)
Vue.use(PortalVue)

// Vue.use(Permissions)

Vue.directive('can', function (el, binding, vnode) {

  if(Permissions.indexOf(binding.value) !== -1){
    return vnode.elm.hidden = false;
  }else{
    return vnode.elm.hidden = true;
  }
})

let app = document.getElementById('app')

new Vue({
  render: h => h(InertiaApp, {
    props: {
      initialPage: JSON.parse(app.dataset.page),
      resolveComponent: name => import(`@/Pages/${name}`).then(module => module.default),
    },
  }),
}).$mount(app)

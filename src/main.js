// This is the main.js file. Import global CSS and scripts here.
// The Client API can be used here. Learn more: gridsome.org/docs/client-api
import Vuex from 'vuex'

import DefaultLayout from '~/layouts/Default.vue'

export default function (Vue, { appOptions }) {
  Vue.use(Vuex)

  const isClient = typeof window !== 'undefined'
  let initialTheme = 'dark'
  if (isClient) {
    const savedTheme = localStorage.getItem('theme')
    if (savedTheme) {
      initialTheme = savedTheme
    }
  }

  appOptions.store = new Vuex.Store({
    state: {
      navActive: false,
      theme: initialTheme
    },
    mutations: {
      toggleNav (state) {
        state.navActive = !state.navActive;
      },
      setTheme (state, theme) {
        state.theme = theme
        if (isClient) {
          localStorage.setItem('theme', theme)
          document.documentElement.setAttribute('data-theme', theme)
        }
      }
    },
    actions: {
      toggleNav(context) {
        context.commit('toggleNav')
      },
      toggleTheme(context) {
        const nextTheme = context.state.theme === 'dark' ? 'light' : 'dark'
        context.commit('setTheme', nextTheme)
      }
    }
  })

  // Set default layout as a global component
  Vue.component('Layout', DefaultLayout)
}

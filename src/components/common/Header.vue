<template>
  <header id="main-header" class="container">
    <g-link to="/" class="top-logo">
      <Logo/>
    </g-link>
    <div class="header-actions">
      <button id="theme-toggle" @click="toggleTheme" :aria-label="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`" :title="`Switch to ${theme === 'dark' ? 'light' : 'dark'} mode`">
        <svg v-if="theme === 'dark'" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon sun"><circle cx="12" cy="12" r="5"></circle><line x1="12" y1="1" x2="12" y2="3"></line><line x1="12" y1="21" x2="12" y2="23"></line><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line><line x1="1" y1="12" x2="3" y2="12"></line><line x1="21" y1="12" x2="23" y2="12"></line><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line></svg>
        <svg v-else xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="theme-icon moon"><path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path></svg>
      </button>
      <a id="toggle-menu" @click="toggleNav">
        <span>Menu</span>
        <div id="hamburger-menu" :class="{'open' : navActive}">
          <span></span>
          <span></span>
          <span></span>
          <span></span>
        </div>
      </a>
    </div>
  </header>
</template>

<script>
import Logo from '@/components/icons/Logo'

export default {
  computed: {
    navActive: function() {
      return this.$store.state.navActive
    },
    theme: function() {
      return this.$store.state.theme
    }
  },
  components: {
    Logo
  },
  methods: {
    toggleNav: function() {
      this.$store.commit('toggleNav')
    },
    toggleTheme: function() {
      this.$store.dispatch('toggleTheme')
    }
  }
}
</script>

<style lang="scss" scoped>
@import '~/styles/_variables.scss';

#main-header {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  z-index: 10;
  margin-top: 20px;
  display: flex;
  justify-content: space-between;
  align-items: center;

  &.nav-up {
      top: -75px;
  }

  a {
    display: inline-block;
    vertical-align: middle;
  }

  .top-logo {
    color: var(--header-btn-text);
    transition: color 0.3s ease;
    
    svg {
      max-height: 50px;
    }
  }

  &.push-right {
    margin-left: -300px;
    right: 300px;
  }
}

.header-actions {
  display: flex;
  align-items: center;
  gap: 15px;
}

#theme-toggle {
  background: transparent;
  border: 2px solid var(--header-btn-border);
  color: var(--header-btn-text);
  padding: 8px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  width: 40px;
  height: 40px;

  &:hover {
    cursor: pointer;
    transform: scale(1.05);
    background: rgba(17, 98, 90, 0.1);
  }

  .theme-icon {
    width: 20px;
    height: 20px;
  }
}

#toggle-menu {
  padding: 10px 15px;
  border: 2px solid var(--header-btn-border);
  color: var(--header-btn-text);
  display: flex;
  align-items: center;
  gap: 8px;
  transition: all 0.3s ease;

  &:hover {
    cursor: pointer;
    transform: scale(1.05);
    background: rgba(17, 98, 90, 0.1);
  }

  span {
    text-transform: uppercase;
    font-family: 'Plus Jakarta Sans', sans-serif;
    letter-spacing: 2px;
    font-size: 14px;
    line-height: 1;
  }

  /*
    Hamburger Menu
    */

  @at-root #hamburger-menu {
    display: inline-block;
    width: 16px;
    height: 12px;
    position: relative;
    transform: rotate(0deg);
    transition: .5s ease-in-out;
    cursor: pointer;

    span {
      display: block;
      position: absolute;
      height: 2px;
      width: 100%;
      background: var(--header-btn-text);
      border-radius: 9px;
      opacity: 1;
      left: 0;
      transform: rotate(0deg);
      transition: .25s ease-in-out;

      &:nth-child(1) {
        top: 0px;
      }
      &:nth-child(2),
      &:nth-child(3) {
        top: 5px;
      }
      &:nth-child(4) {
        top: 10px;
      }

    }

    &.open span {
      &:nth-child(1) {
        top: 5px;
        width: 0%;
        left: 50%;
      }
      &:nth-child(2) {
        transform: rotate(45deg);
      }
      &:nth-child(3) {
        transform: rotate(-45deg);
      }
      &:nth-child(4) {
        top: 5px;
        width: 0%;
        left: 50%;
      }
    }
  }
}
</style>
<template>
  <header id="main-header" class="container">
    <g-link to="/" class="top-logo">
      <Logo/>
    </g-link>
    <a id="toggle-menu" @click="toggleNav">
      <span>Menu</span>
      <div id="hamburger-menu" :class="{'open' : navActive}">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div></a>
  </header>
</template>

<script>
import Logo from '@/components/icons/Logo'

export default {
  computed: {
    navActive: function() {
      return this.$store.state.navActive
    }
  },
  components: {
    Logo
  },
  methods: {
    toggleNav: function() {
      this.$store.commit('toggleNav')
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

  &.nav-up {
      top: -75px;
  }

  a {
    display: inline-block;
    vertical-align: middle;
  }

  .top-logo svg {
    max-height: 50px;
  }

  &.push-right {
    margin-left: -300px;
    right: 300px;
  }
}

#toggle-menu {
  padding: 10px 15px;
  border: 2px solid #fff;
  color: #fff;
  float: right;

  &  > * {
    display: inline-block;
    vertical-align: sub;
  }

  &:hover {
    cursor: pointer;
    transform: scale(1.05);
  }

  span {
    margin-right: 5px;
    text-transform: uppercase;
    font-family: 'ElenarLove', sans-serif;
    letter-spacing: 2px;
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
      background: #fff;
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
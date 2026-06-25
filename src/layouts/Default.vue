<template>
  <div :class="navActive ? 'push-right' : ''" class="layout">
    <Header/>
    <Nav/>
    <slot/>
    <Contact/>
    <Footer/>
  </div>
</template>

<static-query>
query {
  metadata {
    siteName
  }
}
</static-query>

<script>
import Header from '@/components/common/Header'
import Nav from '@/components/common/Nav'
import Contact from '@/components/common/Contact'
import Footer from '@/components/common/Footer'

export default {
  data() {
    return {

    }
  },
  computed: {
    navActive: function() {
      return this.$store.state.navActive
    }
  },
  components: {
    Header,
    Nav,
    Contact,
    Footer
  },
  mounted() {
    if (typeof window !== 'undefined') {
      document.documentElement.setAttribute('data-theme', this.$store.state.theme);
    }
  }
}
</script>

<style lang="scss">
@import url('https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
@import '~/styles/_variables.scss';

:root {
  --bg-primary: #151e1b;
  --bg-secondary: #1a2421;
  --bg-hero: linear-gradient(to bottom, #414345, #232526);
  --bg-card: #202c28;
  --text-primary: #ffffff;
  --text-secondary: #8ba79d;
  --text-muted: #627c73;
  --border-color: rgba(255, 255, 255, 0.1);
  --header-btn-border: #ffffff;
  --header-btn-text: #ffffff;
  --accent-color: #30AEA2;
  --shadow-color: rgba(0, 0, 0, 0.3);
}

html[data-theme="light"] {
  --bg-primary: #f5f8f7;
  --bg-secondary: #ffffff;
  --bg-hero: linear-gradient(to bottom, #e6edea, #cce0db);
  --bg-card: #ffffff;
  --text-primary: #1e2825;
  --text-secondary: #4a5c56;
  --text-muted: #738a82;
  --border-color: rgba(0, 0, 0, 0.08);
  --header-btn-border: #11625a;
  --header-btn-text: #11625a;
  --accent-color: #11625a;
  --shadow-color: rgba(0, 0, 0, 0.06);
}

* {
  box-sizing: border-box;
  outline: 0;
}
html,
body {
  margin: 0;
  padding: 0;
  width: 100%;
  max-width: 100%;
  overflow-x: hidden;
}
#app {
  margin: 0;
  padding: 0;
  width: 100%;
  max-width: 100%;
}
body {
  position: relative;
  left: 0;
  color: var(--text-primary);
  background-color: var(--bg-primary);
  font-family: 'Outfit', sans-serif;
  transition: background-color 0.3s ease, color 0.3s ease;
}
h1, h2, h3, h4, h5, h6, .section-title, .intro-title {
  font-family: 'Plus Jakarta Sans', sans-serif;
}
a {
  position: relative;
  text-decoration: none;
  color: var(--accent-color);
}

p {
  line-height: 1.6em;
  color: var(--text-secondary);

  a {
    padding: 2px 3px;


  }
}
img {
  max-width: 100%;
}

/*
  Global Layout Stlyes
  */
.full-window {
  width: 100%;
  height: 100vh;
}
.container {
  padding-left: 50px;
  padding-right: 50px;
}
.inner-container {
  max-width: 1240px;
  padding: 0 15px;
  display: block;
  margin: 0 auto;
}
.small-container {
  max-width: 768px;
  padding: 0 15px;
  display: block;
  margin: 0 auto;
}

section {
  padding-top: 30px;
  padding-bottom: 30px;
  box-sizing: border-box;
}
.bottom-reveal {
  position: fixed;
  left: 0;
  right: 0;
  bottom: 0;
}

.clearfix:before,
.clearfix:after {
  content: "";
  display: table;
}
.clearfix:after {
  clear: both;
}
.clearfix {
  zoom: 1;
}

.col-half {
  width: 50%;
  float: left;
}
.three-col {
  width: 33.33%;
  float: left;
}
.center-content {
  position: absolute;
  top: 50%;
  left: 0;
  right: 0;
  transform: translateY(-50%);
}
.section-full-content {
  padding: 70px 25px;
  width: 100%;
  height: 100%;
  box-sizing: border-box;
}

*[class^="flaticon"] {
  color: #fff;
}

.push-right {
  margin-left: -300px!important;
  overflow-y: hidden;
}

.section.fp-auto-height {
  padding: 50px 0;
}

.text-center {
  text-align: center;
}
.text-light {
  & * {
    color: #fff;
  }
}


.section-title {
  font-size: calc(1em + 1.5vw);
}
.section-sub-statement {
  font-size: 1.25em;
  line-height: 1.75em;
  margin-bottom: 40px;
}

.copyright {
  font-size: 12px;
  opacity: 0.4;
  line-height: 1.2em;
  color: #8ba79d;
}
</style>

<template>
  <Layout>
    <IntroSection id="home"/>
    <AboutMe/>
    <PortfolioSection/>
  </Layout>
</template>

<script>
import IntroSection from '@/components/home/IntroSection'
import AboutMe from '@/components/home/AboutMe'
import PortfolioSection from '@/components/home/PortfolioSection'

export default {
  components: {
    IntroSection,
    AboutMe,
    // PortfolioSection
  },
  metaInfo: {
    title: 'Welcome to my Portfolio Site!'
  }
}
</script>

<style>

</style>

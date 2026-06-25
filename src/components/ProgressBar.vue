<template>  
  <div class="profile__skills">
    <div v-for="(skill, index) in skills" :key="index" class="skillbar clearfix">
      <div class="skillbar-title"><span>{{ skill.name }}</span></div>
      <div class="skillbar-bar" :style="{ width: animated ? skill.level + '%' : '0%' }"></div>
      <div class="skill-bar-percent">{{ skill.level }}%</div>
    </div>
    <small class="profile__skill--description">Left quite a lot of room for improvements!</small>
    <small class="profile__skill--description">Photo credits: <a href="https://www.facebook.com/tyronnesantella" target="_blank" rel="noopener">Tyronne Santella</a></small>
  </div>
</template>

<script>
export default {
  data() {
    return {
      animated: false,
      skills: [
        { name: 'Wordpress', level: 75 },
        { name: 'PSD to HTML', level: 80 },
        { name: 'HTML5/CSS3', level: 85 },
        { name: 'CSS/SVG Animation', level: 80 },
        { name: 'Javascript', level: 65 }
      ]
    }
  },
  mounted() {
    // Trigger transition after render
    setTimeout(() => {
      this.animated = true;
    }, 200);
  }
}
</script>

<style lang="scss">
@import '~/styles/_variables.scss';
/*
 * Progress Bar
 */

 .skillbar {
 	position:relative;
 	display:block;
 	width:100%;
 	height:35px;
 	margin-bottom:15px;
 	border-radius:3px;
 	background: var(--border-color);
  overflow: hidden;

  .skillbar-title,
  .skillbar-bar {
    background-color: var(--accent-color);
  }

  .skillbar-title {
  	position:absolute;
  	top:0;
  	left:0;
  	color:#fff;
  	border-top-left-radius:3px;
  	border-bottom-left-radius:3px;
  	background: var(--accent-color);
  	font-size:13px;
  	font-weight:normal;
    z-index: 2;

   span {
   	display:block;
   	height:35px;
   	padding:0 20px;
   	border-top-left-radius:3px;
   	border-bottom-left-radius:3px;
   	background: lighten(#11625a, 5%);
    letter-spacing: 1px;
   	line-height:35px;
   }
  }

  .skillbar-bar {
  	width:0px;
  	height:35px;
  	border-radius:3px;
    transition: width 1.5s cubic-bezier(0.25, 1, 0.5, 1);
    z-index: 1;
  }

  .skill-bar-percent {
  	position:absolute;
  	top:0;
  	right:10px;
  	height:35px;
  	color: var(--text-primary);
  	opacity: 0.6;
  	font-size:11px;
  	line-height:35px;
    z-index: 2;
  }
 }
</style>
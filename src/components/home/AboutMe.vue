<template>
  <section id="about" class="clearfix">
    <div id="profile-picture" class="col-half"></div>
    <div class="col-half profile">
      <h2 class="profile__name">Mikko de Castro</h2>
      <h3 class="profile__title">Web Developer <span style="color: #11625a">/</span> Designer</h3>

      <div class="profile__description">
        <p>The opportunity for new challenges is what keeps me going, and this is why I consider web development as my better half.</p>
        <p>I started out as a graphic designer, and soon discovered the sense of fulfillment in not only understanding the art in websites, but also building them in code. Because of this evolution, I gain a big advantage in front-end development and CSS animations that enters in your project!</p>
      </div>

      <p class="section-title">Experience &amp; Recognition</p>
      
      <!-- Loopable Autoplay Experience Slider -->
      <div class="slider-container" @mouseenter="stopAutoplay" @mouseleave="startAutoplay">
        <div class="slider-wrapper" :style="{ transform: `translateX(${-currentSlide * 100}%)` }">
          <div 
            v-for="(item, i) in experiences" 
            :key="i"
            class="experience-slide"
          >
            <div class="profile__experience--title">
              {{ item.title }} <span>( {{ item.period }} )</span>
            </div>
            <div class="profile__experience--description">
              <p>{{ item.description }}</p>
            </div>
          </div>
        </div>
        
        <!-- Slider Pagination Dots -->
        <div class="slider-dots">
          <span 
            v-for="(item, i) in experiences" 
            :key="i"
            :class="['dot', { active: currentSlide === i }]"
            @click="setSlide(i)"
            :title="`Go to slide ${i + 1}`"
          ></span>
        </div>
      </div>

      <p class="section-title">Skills</p>
      <ProgressBar/>

    </div>
  </section>
</template>

<script>
import ProgressBar from '@/components/ProgressBar'

export default {
  components: {
    ProgressBar
  },
  data() {
    return {
      currentSlide: 0,
      autoplayTimer: null,
      experiences: [
        {
          title: "August99 - Web Developer",
          period: "JUN 2015 - MAR 2017",
          description: "Started as a Project Coordinator and transitioned to the programming department to pursue a development career. Worked with international clients utilizing WordPress."
        },
        {
          title: "De La Salle College of Saint Benilde",
          period: "2011 - 2015",
          description: "Graduated with a Bachelor of Arts in Multimedia Arts - Honorable Mention, building a solid foundation in graphics, layouts, and typography."
        },
        {
          title: "Freelance Developer & Designer",
          period: "2017 - PRESENT",
          description: "Building responsive bespoke WordPress themes/plugins, integrating ERP database visualization layers, and constructing high-end interactive layouts with clean micro-animations."
        }
      ]
    }
  },
  mounted() {
    this.startAutoplay();
  },
  beforeDestroy() {
    this.stopAutoplay();
  },
  methods: {
    startAutoplay() {
      this.autoplayTimer = setInterval(() => {
        this.nextSlide();
      }, 4000);
    },
    stopAutoplay() {
      if (this.autoplayTimer) {
        clearInterval(this.autoplayTimer);
        this.autoplayTimer = null;
      }
    },
    nextSlide() {
      this.currentSlide = (this.currentSlide + 1) % this.experiences.length;
    },
    setSlide(index) {
      this.currentSlide = index;
    }
  }
}
</script>

<style lang="scss" scoped>
@import '~/styles/_variables.scss';

#about {
  position: relative;
  padding: 0;
  display: flex;

  @media (max-width: 768px) {
    flex-direction: column;
  }

  .col-half {
    flex: 1;
  }

  #profile-picture {
    background-color: #21baae;
    background-image: url('../../img/mikko-profile.png');
    background-position: center center;
    background-size: cover;
    background-repeat: no-repeat;
    
    @media (max-width: 768px) {
      min-height: 350px;
    }
  }

  .profile {
    padding: 40px 50px;
    overflow: hidden;

    @media (max-width: 576px) {
      padding: 30px 20px;
    }

    & > *:not(.profile__name):not(.section-title):not(.slider-container) {
      margin-bottom: 30px;
    }
    
    .section-title {
      font-size: 1.1em;
      margin-top: 0;
      font-weight: bold;
      color: var(--text-primary);
      text-transform: uppercase;
      letter-spacing: 1px;
      margin-bottom: 15px;
    }
    
    &__name {
      font-size: calc(1.3em + 1.5vw);
      margin-bottom: 10px;
      font-weight: 900;
      color: var(--text-primary);
    }
    
    &__title {
      margin-top: 0;
      font-size: 1.1em;
      color: var(--text-secondary);
      margin-bottom: 25px;
    }
    
    // Experience slider layout
    .slider-container {
      position: relative;
      overflow: hidden;
      width: 100%;
      background: var(--bg-card);
      border: 1px solid var(--border-color);
      border-radius: 12px;
      margin-bottom: 35px;
      box-shadow: 0 4px 15px var(--shadow-color);
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .slider-wrapper {
      display: flex;
      transition: transform 0.6s cubic-bezier(0.25, 1, 0.5, 1);
      width: 100%;
    }

    .experience-slide {
      min-width: 100%;
      box-sizing: border-box;
      padding: 25px 30px 15px 30px;
    }

    .profile__experience--title {
      margin-bottom: 12px;
      font-weight: bold;
      letter-spacing: 1px;
      color: var(--accent-color);
      font-size: 1.05em;

      span {
        font-size: 80%;
        color: var(--text-muted);
        font-weight: 500;
      }
    }

    .profile__experience--description {
      p {
        margin: 0;
        line-height: 1.6;
        color: var(--text-secondary);
        font-size: 0.95em;
      }
    }

    .slider-dots {
      display: flex;
      justify-content: center;
      gap: 8px;
      padding-bottom: 20px;
      
      .dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background-color: var(--border-color);
        cursor: pointer;
        transition: all 0.3s ease;
        
        &:hover {
          background-color: var(--accent-color);
        }
        
        &.active {
          background-color: var(--accent-color);
          transform: scale(1.3);
        }
      }
    }

    &__skill {
      &--description {
        opacity: 0.5;
        display: block;
      }
    }
  }
}
</style>
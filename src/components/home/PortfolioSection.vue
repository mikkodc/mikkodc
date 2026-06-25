<template>
  <section id="portfolio" class="portfolio-section">
    <div class="inner-container">
      <h2 class="section-title text-center">My Portfolio</h2>
      <p class="section-sub-statement text-center">
        A collection of WordPress plugins, custom themes, full-stack applications, and interactive web tools.
      </p>

      <!-- Category Filter Tabs -->
      <div class="portfolio-filters">
        <button 
          v-for="cat in categories" 
          :key="cat"
          :class="['filter-btn', { active: activeCategory === cat }]"
          @click="activeCategory = cat"
        >
          {{ cat }}
        </button>
      </div>

      <!-- Projects Grid -->
      <div class="projects-grid">
        <div 
          v-for="(project, i) in filteredProjects" 
          :key="i"
          class="project-card"
          @click="openDetails(project)"
        >
          <div class="project-card__content">
            <span class="project-card__category">{{ project.category }}</span>
            <h3 class="project-card__title">{{ project.title }}</h3>
            <p class="project-card__desc">{{ project.description }}</p>
            
            <div class="project-card__tags">
              <span v-for="tag in project.tags" :key="tag" class="tag-badge">{{ tag }}</span>
            </div>
            
            <span class="project-card__link">View Project Details <span class="arrow">&rarr;</span></span>
          </div>
        </div>
      </div>
    </div>

    <!-- Project Details Modal (Glassmorphism) -->
    <transition name="fade">
      <div v-if="selectedProject" class="project-modal-backdrop" @click.self="closeDetails">
        <div class="project-modal">
          <button class="close-btn" @click="closeDetails" aria-label="Close modal">&times;</button>
          
          <div class="modal-content">
            <span class="modal-category">{{ selectedProject.category }}</span>
            <h3 class="modal-title">{{ selectedProject.title }}</h3>
            
            <hr class="modal-divider">
            
            <p class="modal-long-desc">{{ selectedProject.longDescription || selectedProject.description }}</p>
            
            <div class="modal-tags">
              <h4>Technologies & Skills</h4>
              <div class="tags-container">
                <span v-for="tag in selectedProject.tags" :key="tag" class="tag-badge accent">{{ tag }}</span>
              </div>
            </div>

            <div class="modal-actions">
              <a 
                v-if="selectedProject.demoUrl" 
                :href="selectedProject.demoUrl.startsWith('/') ? selectedProject.demoUrl : selectedProject.demoUrl" 
                :target="selectedProject.demoUrl.startsWith('/') ? '_self' : '_blank'"
                class="btn btn-primary"
              >
                Launch App
              </a>
              <a 
                v-if="selectedProject.githubUrl" 
                :href="selectedProject.githubUrl" 
                target="_blank" 
                class="btn btn-ghost"
              >
                GitHub Repo
              </a>
            </div>
          </div>
        </div>
      </div>
    </transition>
  </section>
</template>

<static-query>
query {
  metadata {
    projects {
      title
      description
      longDescription
      category
      tags
      demoUrl
      githubUrl
    }
  }
}
</static-query>

<script>
export default {
  name: "PortfolioSection",
  data() {
    return {
      activeCategory: "All",
      selectedProject: null
    };
  },
  computed: {
    projects() {
      return this.$static.metadata.projects || [];
    },
    categories() {
      const cats = new Set(this.projects.map(p => {
        if (p.category.toLowerCase().includes("wordpress")) return "WordPress";
        if (p.category.toLowerCase().includes("full-stack") || p.category.toLowerCase().includes("analytics")) return "Full-stack";
        if (p.category.toLowerCase().includes("front-end") || p.category.toLowerCase().includes("interactive")) return "Front-end";
        return "Other";
      }));
      return ["All", ...Array.from(cats)];
    },
    filteredProjects() {
      if (this.activeCategory === "All") {
        return this.projects;
      }
      return this.projects.filter(p => {
        const catGroup = p.category.toLowerCase().includes("wordpress") ? "WordPress" :
                         p.category.toLowerCase().includes("full-stack") || p.category.toLowerCase().includes("analytics") ? "Full-stack" :
                         p.category.toLowerCase().includes("front-end") || p.category.toLowerCase().includes("interactive") ? "Front-end" : "Other";
        return catGroup === this.activeCategory;
      });
    }
  },
  methods: {
    openDetails(project) {
      this.selectedProject = project;
      document.body.style.overflow = "hidden";
    },
    closeDetails() {
      this.selectedProject = null;
      document.body.style.overflow = "";
    }
  }
};
</script>

<style lang="scss" scoped>
@import '~/styles/_variables.scss';
@import '~/styles/_mixins.scss';
@import '~/styles/_buttons.scss';

.portfolio-section {
  padding: 80px 0;
  background-color: var(--bg-secondary);
  border-top: 1px solid var(--border-color);
  border-bottom: 1px solid var(--border-color);
  transition: background-color 0.3s ease, border-color 0.3s ease;
}

.portfolio-filters {
  display: flex;
  justify-content: center;
  gap: 12px;
  margin-bottom: 45px;
  flex-wrap: wrap;

  .filter-btn {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    padding: 10px 24px;
    font-size: 0.9em;
    font-weight: 600;
    border-radius: 30px;
    cursor: pointer;
    transition: all 0.3s ease;

    &:hover {
      border-color: var(--accent-color);
      color: var(--text-primary);
      transform: translateY(-2px);
    }

    &.active {
      background-color: var(--accent-color);
      border-color: var(--accent-color);
      color: #ffffff;
      box-shadow: 0 4px 12px var(--shadow-color);
    }
  }
}

.projects-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
  gap: 30px;
}

.project-card {
  background-color: var(--bg-card);
  border: 1px solid var(--border-color);
  border-radius: 16px;
  padding: 30px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  &:hover {
    transform: translateY(-8px);
    border-color: var(--accent-color);
    box-shadow: 0 12px 30px var(--shadow-color);

    .project-card__link {
      color: var(--text-primary);

      .arrow {
        transform: translateX(6px);
      }
    }
  }

  &__category {
    font-size: 0.8em;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--accent-color);
    font-weight: bold;
    display: block;
    margin-bottom: 12px;
  }

  &__title {
    font-size: 1.35em;
    margin: 0 0 15px 0;
    color: var(--text-primary);
    font-weight: 700;
  }

  &__desc {
    font-size: 0.95em;
    line-height: 1.5;
    color: var(--text-secondary);
    margin-bottom: 20px;
  }

  &__tags {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 25px;
  }

  &__link {
    color: var(--accent-color);
    font-weight: bold;
    font-size: 0.9em;
    text-transform: uppercase;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: color 0.3s ease;

    .arrow {
      transition: transform 0.3s cubic-bezier(0.25, 1, 0.5, 1);
    }
  }
}

.tag-badge {
  font-size: 0.75em;
  padding: 4px 10px;
  border-radius: 6px;
  background-color: var(--border-color);
  color: var(--text-secondary);
  font-weight: 600;

  &.accent {
    background-color: var(--accent-color);
    color: #ffffff;
  }
}

// Detailed Modal overlay (glassmorphism)
.project-modal-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.65);
  backdrop-filter: blur(8px);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.project-modal {
  background: var(--bg-card);
  border: 1px solid var(--border-color);
  border-radius: 24px;
  max-width: 600px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
  animation: slideUp 0.3s ease-out;

  .close-btn {
    position: absolute;
    top: 20px;
    right: 20px;
    background: transparent;
    border: none;
    font-size: 2.2em;
    line-height: 1;
    color: var(--text-secondary);
    cursor: pointer;
    transition: color 0.3s;

    &:hover {
      color: var(--text-primary);
    }
  }

  .modal-content {
    padding: 40px;
  }

  .modal-category {
    font-size: 0.85em;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--accent-color);
    font-weight: bold;
  }

  .modal-title {
    font-size: 1.8em;
    margin: 10px 0 20px 0;
    color: var(--text-primary);
  }

  .modal-divider {
    border: 0;
    height: 1px;
    background: var(--border-color);
    margin: 20px 0;
  }

  .modal-long-desc {
    font-size: 1.05em;
    line-height: 1.6;
    color: var(--text-secondary);
    margin-bottom: 30px;
  }

  .modal-tags {
    margin-bottom: 35px;

    h4 {
      margin: 0 0 12px 0;
      font-size: 0.9em;
      color: var(--text-primary);
      text-transform: uppercase;
      letter-spacing: 1px;
    }

    .tags-container {
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
    }
  }

  .modal-actions {
    display: flex;
    gap: 15px;

    .btn {
      padding: 12px 30px;
      font-size: 0.9em;
      border-radius: 30px;
      
      &.btn-ghost {
        border-color: var(--border-color);
        color: var(--text-primary);
        &:hover {
          background-color: var(--border-color);
        }
      }
    }
  }
}

// Fade transition animation
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

@keyframes slideUp {
  from {
    transform: translateY(30px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
</style>

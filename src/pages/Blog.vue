<template>
  <Layout>
    <main class="blog-page">
      <div class="inner-container">
        <header class="page-header">
          <h1 class="page-title text-center">Tech & Design Blog</h1>
          <p class="section-sub-statement text-center">
            Insights on WordPress plugins development, database architectures, and high-performance front-end engineering.
          </p>
        </header>

        <!-- Search and Filter Bar -->
        <div class="blog-toolbar">
          <div class="search-box">
            <input 
              type="text" 
              placeholder="Search articles..." 
              v-model="searchQuery"
            >
            <span class="search-icon">🔍</span>
          </div>

          <div class="category-filters">
            <button 
              v-for="cat in categories" 
              :key="cat"
              :class="['filter-btn', { active: activeCategory === cat }]"
              @click="activeCategory = cat"
            >
              {{ cat }}
            </button>
          </div>
        </div>

        <!-- Articles Grid -->
        <div v-if="filteredArticles.length > 0" class="articles-grid">
          <article 
            v-for="post in filteredArticles" 
            :key="post.id"
            class="article-card"
            @click="readArticle(post)"
          >
            <div class="article-card__header">
              <span class="article-card__category">{{ post.category }}</span>
              <span class="article-card__read-time">{{ post.readTime }}</span>
            </div>
            
            <h2 class="article-card__title">{{ post.title }}</h2>
            <p class="article-card__desc">{{ post.description }}</p>
            
            <div class="article-card__footer">
              <span class="article-card__date">{{ post.date }}</span>
              <button class="article-card__btn btn-arrow-right">Read Article</button>
            </div>
          </article>
        </div>

        <!-- Empty State -->
        <div v-else class="empty-state text-center">
          <h3>No articles found</h3>
          <p>Try adjusting your search terms or filters.</p>
        </div>
      </div>
    </main>

    <!-- Modal Full Article Reader -->
    <transition name="fade">
      <div v-if="selectedPost" class="reader-backdrop" @click.self="closeReader">
        <div class="reader-modal">
          <button class="close-btn" @click="closeReader" aria-label="Close reader">&times;</button>
          
          <article class="reader-content">
            <header class="reader-header">
              <div class="reader-meta">
                <span class="reader-category">{{ selectedPost.category }}</span>
                <span class="reader-bullet">&bull;</span>
                <span class="reader-read-time">{{ selectedPost.readTime }}</span>
                <span class="reader-bullet">&bull;</span>
                <span class="reader-date">{{ selectedPost.date }}</span>
              </div>
              <h1 class="reader-title">{{ selectedPost.title }}</h1>
            </header>

            <hr class="reader-divider">

            <div class="reader-body">
              <p class="lead-text">{{ selectedPost.description }}</p>
              <p v-for="(paragraph, i) in getParagraphs(selectedPost.content)" :key="i">
                {{ paragraph }}
              </p>
            </div>

            <div class="reader-tags">
              <span v-for="tag in selectedPost.tags" :key="tag" class="tag-badge accent">{{ tag }}</span>
            </div>
          </article>
        </div>
      </div>
    </transition>
  </Layout>
</template>

<static-query>
query {
  metadata {
    articles {
      id
      title
      description
      content
      category
      tags
      readTime
      date
    }
  }
}
</static-query>

<script>
export default {
  metaInfo: {
    title: 'Blog - Tech Insights'
  },
  data() {
    return {
      searchQuery: "",
      activeCategory: "All",
      selectedPost: null
    };
  },
  computed: {
    articles() {
      return this.$static.metadata.articles || [];
    },
    categories() {
      const cats = new Set(this.articles.map(a => a.category));
      return ["All", ...Array.from(cats)];
    },
    filteredArticles() {
      return this.articles.filter(post => {
        // Category Filter
        const matchesCategory = this.activeCategory === "All" || post.category === this.activeCategory;
        
        // Search Query Filter
        const query = this.searchQuery.toLowerCase();
        const matchesSearch = 
          post.title.toLowerCase().includes(query) ||
          post.description.toLowerCase().includes(query) ||
          post.content.toLowerCase().includes(query) ||
          post.tags.some(tag => tag.toLowerCase().includes(query));

        return matchesCategory && matchesSearch;
      });
    }
  },
  methods: {
    readArticle(post) {
      this.selectedPost = post;
      document.body.style.overflow = "hidden";
    },
    closeReader() {
      this.selectedPost = null;
      document.body.style.overflow = "";
    },
    getParagraphs(content) {
      if (!content) return [];
      // Split content by custom breaks or double newlines if any
      return content.split("\n\n").filter(p => p.trim() !== "");
    }
  }
};
</script>

<style lang="scss" scoped>
@import '~/styles/_variables.scss';
@import '~/styles/_mixins.scss';
@import '~/styles/_buttons.scss';

.blog-page {
  padding-top: 110px;
  padding-bottom: 80px;
  background-color: var(--bg-primary);
  min-height: 100vh;
  transition: background-color 0.3s ease;
}

.page-header {
  margin-bottom: 50px;
}

.page-title {
  font-size: calc(1.8em + 1.5vw);
  font-weight: 900;
  color: var(--text-primary);
  margin-bottom: 15px;
}

.blog-toolbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 20px;
  margin-bottom: 45px;
  flex-wrap: wrap;

  @media (max-width: 768px) {
    flex-direction: column;
    align-items: stretch;
  }
}

.search-box {
  position: relative;
  flex: 1;
  max-width: 350px;

  @media (max-width: 768px) {
    max-width: 100%;
  }

  input {
    width: 100%;
    padding: 12px 20px 12px 45px;
    border-radius: 30px;
    border: 1px solid var(--border-color);
    background-color: var(--bg-secondary);
    color: var(--text-primary);
    outline: none;
    font-size: 0.95em;
    transition: all 0.3s ease;

    &:focus {
      border-color: var(--accent-color);
      box-shadow: 0 0 10px rgba(48, 174, 162, 0.25);
    }
  }

  .search-icon {
    position: absolute;
    left: 18px;
    top: 50%;
    transform: translateY(-50%);
    font-size: 0.9em;
    opacity: 0.5;
  }
}

.category-filters {
  display: flex;
  gap: 10px;
  flex-wrap: wrap;

  .filter-btn {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-secondary);
    padding: 8px 18px;
    font-size: 0.85em;
    font-weight: 600;
    border-radius: 20px;
    cursor: pointer;
    transition: all 0.3s ease;

    &:hover {
      border-color: var(--accent-color);
      color: var(--text-primary);
    }

    &.active {
      background-color: var(--accent-color);
      border-color: var(--accent-color);
      color: #ffffff;
      box-shadow: 0 4px 10px var(--shadow-color);
    }
  }
}

.articles-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(340px, 1fr));
  gap: 30px;
}

.article-card {
  background-color: var(--bg-secondary);
  border: 1px solid var(--border-color);
  border-radius: 20px;
  padding: 30px;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
  display: flex;
  flex-direction: column;
  justify-content: space-between;

  &:hover {
    transform: translateY(-6px);
    border-color: var(--accent-color);
    box-shadow: 0 12px 30px var(--shadow-color);
  }

  &__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 15px;
  }

  &__category {
    font-size: 0.8em;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: var(--accent-color);
    font-weight: 700;
  }

  &__read-time {
    font-size: 0.8em;
    color: var(--text-muted);
  }

  &__title {
    font-size: 1.35em;
    margin: 0 0 15px 0;
    color: var(--text-primary);
    line-height: 1.3;
    font-weight: 700;
  }

  &__desc {
    font-size: 0.95em;
    line-height: 1.5;
    color: var(--text-secondary);
    margin-bottom: 25px;
    flex-grow: 1;
  }

  &__footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-top: 1px solid var(--border-color);
    padding-top: 15px;
    margin-top: auto;
  }

  &__date {
    font-size: 0.85em;
    color: var(--text-muted);
  }

  &__btn {
    background: transparent;
    border: none;
    color: var(--accent-color);
    font-weight: bold;
    font-size: 0.85em;
    text-transform: uppercase;
    letter-spacing: 1px;
    padding: 0;
    cursor: pointer;
  }
}

.empty-state {
  padding: 80px 0;
  border-radius: 20px;
  border: 1px dashed var(--border-color);
  color: var(--text-secondary);

  h3 {
    color: var(--text-primary);
    margin-bottom: 8px;
  }
}

// Reader Overlay (Slide-over / Modal)
.reader-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.7);
  backdrop-filter: blur(8px);
  z-index: 1000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

.reader-modal {
  background: var(--bg-card);
  border: 1px solid var(--border-color);
  border-radius: 24px;
  max-width: 800px;
  width: 100%;
  max-height: 90vh;
  overflow-y: auto;
  position: relative;
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.4);
  animation: slideUp 0.3s ease-out;

  .close-btn {
    position: absolute;
    top: 25px;
    right: 25px;
    background: transparent;
    border: none;
    font-size: 2.5em;
    line-height: 1;
    color: var(--text-secondary);
    cursor: pointer;
    transition: color 0.3s;
    z-index: 2;

    &:hover {
      color: var(--text-primary);
    }
  }

  .reader-content {
    padding: 50px;
    
    @media (max-width: 576px) {
      padding: 30px 20px;
    }
  }

  .reader-header {
    margin-bottom: 25px;
  }

  .reader-meta {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.85em;
    color: var(--text-muted);
    margin-bottom: 12px;
    flex-wrap: wrap;

    .reader-category {
      color: var(--accent-color);
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 1px;
    }
  }

  .reader-title {
    font-size: calc(1.5em + 1vw);
    line-height: 1.25;
    color: var(--text-primary);
    margin: 0;
    font-weight: 800;
  }

  .reader-divider {
    border: 0;
    height: 1px;
    background: var(--border-color);
    margin: 25px 0;
  }

  .reader-body {
    font-size: 1.1em;
    line-height: 1.7;
    color: var(--text-secondary);
    
    p {
      margin-bottom: 20px;
      color: var(--text-secondary);
    }

    .lead-text {
      font-size: 1.15em;
      font-weight: 600;
      color: var(--text-primary);
      margin-bottom: 25px;
    }
  }

  .reader-tags {
    margin-top: 40px;
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    border-top: 1px solid var(--border-color);
    padding-top: 25px;
  }
}

.tag-badge {
  font-size: 0.8em;
  padding: 5px 12px;
  border-radius: 6px;
  background-color: var(--border-color);
  color: var(--text-secondary);
  font-weight: 600;

  &.accent {
    background-color: var(--accent-color);
    color: #ffffff;
  }
}

// Transitions
.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s;
}
.fade-enter, .fade-leave-to {
  opacity: 0;
}

@keyframes slideUp {
  from {
    transform: translateY(40px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}
</style>

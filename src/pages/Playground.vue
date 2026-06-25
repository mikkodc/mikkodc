<template>
  <Layout>
    <main class="playground-page">
      <div class="inner-container">
        <header class="page-header">
          <h1 class="page-title text-center">Developer Playground</h1>
          <p class="section-sub-statement text-center">
            A space for experiments, dynamic canvas renderers, and interactive animation sandboxes.
          </p>
        </header>

        <!-- Interactive Canvas Section -->
        <section class="playground-section canvas-sandbox">
          <h2 class="sandbox-title">1. Interactive Particle Node Canvas</h2>
          <p class="sandbox-desc">Move your cursor around the container to attract particles and draw connections.</p>
          
          <div class="canvas-container" ref="canvasContainer">
            <canvas ref="particleCanvas"></canvas>
            <div class="canvas-hud">
              <span>Nodes: {{ particleCount }}</span>
              <span>FPS: 60 (Canvas API)</span>
            </div>
          </div>
        </section>

        <!-- CSS/SVG Animation Sandbox -->
        <section class="playground-section animation-sandbox">
          <h2 class="sandbox-title">2. CSS & SVG Micro-Animation Customizer</h2>
          <p class="sandbox-desc">Adjust the keyframe timing parameters to customize the morphing SVG circle below in real-time.</p>

          <div class="sandbox-layout">
            <!-- Animation Controls -->
            <div class="sandbox-controls">
              <div class="control-group">
                <label>Animation Duration: <span>{{ duration }}s</span></label>
                <input type="range" min="0.5" max="5.0" step="0.1" v-model="duration">
              </div>

              <div class="control-group">
                <label>Float Speed: <span>{{ floatSpeed }}s</span></label>
                <input type="range" min="1.0" max="6.0" step="0.2" v-model="floatSpeed">
              </div>

              <div class="control-group">
                <label>Timing Function</label>
                <select v-model="timingFunction">
                  <option value="linear">linear</option>
                  <option value="ease">ease</option>
                  <option value="ease-in">ease-in</option>
                  <option value="ease-out">ease-out</option>
                  <option value="cubic-bezier(0.68, -0.55, 0.265, 1.55)">bounce (cubic-bezier)</option>
                  <option value="cubic-bezier(0.25, 1, 0.5, 1)">smooth (cubic-bezier)</option>
                </select>
              </div>

              <div class="control-group">
                <label>Shape Morph Strength</label>
                <select v-model="morphStrength">
                  <option value="gentle">Gentle</option>
                  <option value="medium">Medium</option>
                  <option value="extreme">Extreme</option>
                </select>
              </div>

              <!-- Output CSS code block -->
              <div class="code-output">
                <div class="code-header">
                  <span>Generated CSS</span>
                  <button class="copy-btn" @click="copyCSS">{{ copied ? 'Copied!' : 'Copy Code' }}</button>
                </div>
                <pre><code>{{ generatedCSS }}</code></pre>
              </div>
            </div>

            <!-- Animation Preview Panel -->
            <div class="sandbox-preview">
              <div class="preview-stage">
                <!-- Interactive SVG Shape -->
                <svg 
                  class="morph-svg" 
                  viewBox="0 0 200 200" 
                  :style="previewStyles"
                >
                  <defs>
                    <linearGradient id="morphGrad" x1="0%" y1="0%" x2="100%" y2="100%">
                      <stop offset="0%" stop-color="#11625a" />
                      <stop offset="100%" stop-color="#30AEA2" />
                    </linearGradient>
                  </defs>
                  <path :class="['morph-path', morphStrength]" d="M100,20 C140,20 180,60 180,100 C180,140 140,180 100,180 C60,180 20,140 20,100 C20,60 60,20 100,20 Z" fill="url(#morphGrad)"/>
                </svg>
              </div>
            </div>
          </div>
        </section>
      </div>
    </main>
  </Layout>
</template>

<script>
export default {
  metaInfo: {
    title: 'Interactive Playground'
  },
  data() {
    return {
      // Canvas particles
      particleCount: 50,
      canvasWidth: 800,
      canvasHeight: 400,
      
      // Animation controls
      duration: 2.0,
      floatSpeed: 3.0,
      timingFunction: "cubic-bezier(0.25, 1, 0.5, 1)",
      morphStrength: "medium",
      copied: false
    };
  },
  computed: {
    previewStyles() {
      return {
        "--morph-duration": `${this.duration}s`,
        "--float-duration": `${this.floatSpeed}s`,
        "--morph-timing": this.timingFunction
      };
    },
    generatedCSS() {
      return `.morphing-node {\n  animation: \n    morph ${this.duration}s ${this.timingFunction} infinite alternate,\n    float ${this.floatSpeed}s ease-in-out infinite;\n}`;
    }
  },
  methods: {
    copyCSS() {
      navigator.clipboard.writeText(this.generatedCSS).then(() => {
        this.copied = true;
        setTimeout(() => {
          this.copied = false;
        }, 1500);
      });
    },
    initParticles() {
      const canvas = this.$refs.particleCanvas;
      if (!canvas) return;
      const ctx = canvas.getContext("2d");
      const container = this.$refs.canvasContainer;
      
      let width = (canvas.width = container.clientWidth);
      let height = (canvas.height = 350);
      
      const particles = [];
      const mouse = { x: null, y: null, radius: 120 };

      // Re-adjust size on window resize
      const handleResize = () => {
        if (container && canvas) {
          width = canvas.width = container.clientWidth;
          height = canvas.height = 350;
        }
      };
      window.addEventListener("resize", handleResize);

      // Mouse movements
      canvas.addEventListener("mousemove", (e) => {
        const rect = canvas.getBoundingClientRect();
        mouse.x = e.clientX - rect.left;
        mouse.y = e.clientY - rect.top;
      });

      canvas.addEventListener("mouseleave", () => {
        mouse.x = null;
        mouse.y = null;
      });

      class Particle {
        constructor() {
          this.x = Math.random() * width;
          this.y = Math.random() * height;
          this.vx = (Math.random() - 0.5) * 1.5;
          this.vy = (Math.random() - 0.5) * 1.5;
          this.radius = Math.random() * 3 + 2;
        }

        update() {
          // Attract particles slightly towards mouse cursor
          if (mouse.x !== null && mouse.y !== null) {
            const dx = mouse.x - this.x;
            const dy = mouse.y - this.y;
            const dist = Math.sqrt(dx * dx + dy * dy);
            if (dist < mouse.radius) {
              const force = (mouse.radius - dist) / mouse.radius;
              this.vx += (dx / dist) * force * 0.15;
              this.vy += (dy / dist) * force * 0.15;
            }
          }

          // Friction limit
          this.vx *= 0.98;
          this.vy *= 0.98;

          this.x += this.vx;
          this.y += this.vy;

          // Bounce off walls
          if (this.x < 0 || this.x > width) this.vx *= -1;
          if (this.y < 0 || this.y > height) this.vy *= -1;
        }

        draw() {
          ctx.beginPath();
          ctx.arc(this.x, this.y, this.radius, 0, Math.PI * 2);
          ctx.fillStyle = "rgba(48, 174, 162, 0.85)";
          ctx.fill();
        }
      }

      // Populate particles list
      for (let i = 0; i < this.particleCount; i++) {
        particles.push(new Particle());
      }

      // Drawing loop
      const animate = () => {
        if (!canvas) return;
        ctx.clearRect(0, 0, width, height);

        // Update and draw particles
        particles.forEach((p) => {
          p.update();
          p.draw();
        });

        // Draw connections
        for (let i = 0; i < particles.length; i++) {
          for (let j = i + 1; j < particles.length; j++) {
            const dx = particles[i].x - particles[j].x;
            const dy = particles[i].y - particles[j].y;
            const dist = Math.sqrt(dx * dx + dy * dy);

            if (dist < 100) {
              ctx.beginPath();
              ctx.moveTo(particles[i].x, particles[i].y);
              ctx.lineTo(particles[j].x, particles[j].y);
              ctx.strokeStyle = `rgba(17, 98, 90, ${1 - dist / 100})`;
              ctx.lineWidth = 0.8;
              ctx.stroke();
            }
          }
        }

        this.animationId = requestAnimationFrame(animate);
      };

      animate();
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.initParticles();
    });
  },
  beforeDestroy() {
    if (this.animationId) {
      cancelAnimationFrame(this.animationId);
    }
  }
};
</script>

<style lang="scss" scoped>
@import '~/styles/_variables.scss';

.playground-page {
  padding-top: 110px;
  padding-bottom: 80px;
  background-color: var(--bg-primary);
  min-height: 100vh;
  transition: background-color 0.3s ease;
}

.page-header {
  margin-bottom: 60px;
}

.page-title {
  font-size: calc(1.8em + 1.5vw);
  font-weight: 900;
  color: var(--text-primary);
  margin-bottom: 15px;
}

.playground-section {
  background-color: var(--bg-secondary);
  border: 1px solid var(--border-color);
  border-radius: 24px;
  padding: 40px;
  margin-bottom: 50px;
  box-shadow: 0 10px 30px var(--shadow-color);
  transition: all 0.3s ease;
}

.sandbox-title {
  font-size: 1.5em;
  margin: 0 0 10px 0;
  color: var(--text-primary);
  font-weight: 700;
}

.sandbox-desc {
  color: var(--text-secondary);
  font-size: 1em;
  margin-bottom: 30px;
}

// Canvas styling
.canvas-container {
  width: 100%;
  background: var(--bg-card);
  border-radius: 16px;
  border: 1px solid var(--border-color);
  position: relative;
  overflow: hidden;

  canvas {
    display: block;
    cursor: crosshair;
  }

  .canvas-hud {
    position: absolute;
    bottom: 15px;
    left: 15px;
    background: rgba(0, 0, 0, 0.6);
    color: #ffffff;
    font-size: 0.75em;
    padding: 6px 12px;
    border-radius: 6px;
    display: flex;
    gap: 15px;
    pointer-events: none;
    font-family: monospace;
  }
}

// Customizer layout styling
.sandbox-layout {
  display: flex;
  gap: 40px;
  flex-wrap: wrap;

  @media (max-width: 768px) {
    flex-direction: column;
  }
}

.sandbox-controls {
  flex: 1.2;
  display: flex;
  flex-direction: column;
  gap: 20px;
  min-width: 280px;
}

.control-group {
  display: flex;
  flex-direction: column;
  gap: 8px;

  label {
    font-size: 0.9em;
    font-weight: 600;
    color: var(--text-primary);
    display: flex;
    justify-content: space-between;

    span {
      color: var(--accent-color);
    }
  }

  input[type="range"] {
    -webkit-appearance: none;
    width: 100%;
    height: 6px;
    background: var(--border-color);
    border-radius: 5px;
    outline: none;

    &::-webkit-slider-thumb {
      -webkit-appearance: none;
      width: 18px;
      height: 18px;
      border-radius: 50%;
      background: var(--accent-color);
      cursor: pointer;
      transition: transform 0.1s;
      &:hover {
        transform: scale(1.2);
      }
    }
  }

  select {
    width: 100%;
    padding: 12px;
    border-radius: 8px;
    background-color: var(--bg-card);
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    font-size: 0.95em;
    outline: none;
    cursor: pointer;
    transition: all 0.3s ease;

    &:focus {
      border-color: var(--accent-color);
    }
  }
}

.code-output {
  margin-top: 15px;
  background-color: var(--bg-card);
  border-radius: 12px;
  border: 1px solid var(--border-color);
  overflow: hidden;

  .code-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background-color: rgba(0, 0, 0, 0.15);
    padding: 10px 18px;
    font-size: 0.8em;
    color: var(--text-secondary);
    font-weight: 600;
  }

  .copy-btn {
    background: transparent;
    border: 1px solid var(--border-color);
    color: var(--text-primary);
    padding: 4px 10px;
    border-radius: 4px;
    cursor: pointer;
    font-size: 0.85em;
    transition: all 0.3s;

    &:hover {
      background-color: var(--accent-color);
      border-color: var(--accent-color);
      color: #ffffff;
    }
  }

  pre {
    margin: 0;
    padding: 18px;
    overflow-x: auto;
    font-family: 'Courier New', Courier, monospace;
    font-size: 0.85em;
    line-height: 1.4;
    color: var(--text-primary);
  }
}

.sandbox-preview {
  flex: 0.8;
  display: flex;
  align-items: center;
  justify-content: center;
  min-width: 250px;
  background-color: var(--bg-card);
  border: 1px solid var(--border-color);
  border-radius: 16px;
  min-height: 300px;
}

.preview-stage {
  position: relative;
  width: 100%;
  height: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.morph-svg {
  width: 180px;
  height: 180px;
  filter: drop-shadow(0 8px 24px rgba(48, 174, 162, 0.35));
  animation: float var(--float-duration) ease-in-out infinite;

  .morph-path {
    transform-origin: center;
    animation: morph var(--morph-duration) var(--morph-timing) infinite alternate;
    
    // Morph strength levels through SVG path variants would normally require SMIL,
    // but here we simulate scaling variations based on timing/bezier logic.
    &.gentle {
      transform: scale(0.97);
    }
    &.medium {
      transform: scale(1.0);
    }
    &.extreme {
      animation: morph var(--morph-duration) var(--morph-timing) infinite alternate,
                 extremeRotate 8s linear infinite;
    }
  }
}

// Custom Keyframe animations
@keyframes morph {
  0% {
    d: path("M100,20 C140,20 180,60 180,100 C180,140 140,180 100,180 C60,180 20,140 20,100 C20,60 60,20 100,20 Z");
    border-radius: 50%;
  }
  50% {
    d: path("M100,30 C150,15 170,70 185,105 C200,140 155,160 105,185 C55,210 20,155 30,105 C40,55 50,45 100,30 Z");
  }
  100% {
    d: path("M100,20 C160,10 190,50 170,110 C150,170 120,170 90,190 C60,210 15,160 25,95 C35,30 40,30 100,20 Z");
  }
}

@keyframes float {
  0% {
    transform: translateY(0px);
  }
  50% {
    transform: translateY(-15px);
  }
  100% {
    transform: translateY(0px);
  }
}

@keyframes extremeRotate {
  0% {
    transform: rotate(0deg) scale(0.95);
  }
  50% {
    transform: rotate(180deg) scale(1.1);
  }
  100% {
    transform: rotate(360deg) scale(0.95);
  }
}
</style>

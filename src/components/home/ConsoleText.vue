<template>
  <span class="console-wrapper">
    <slot></slot>
    <span id="text"></span>
    <span class="console-underscore" id="console">&#95;</span>
  </span>
</template>

<script>
export default {
  data() {
    return {
      titles: ["designer", "photographer", "music lover", "singer"],
      titleColors: ["tomato", "#30AEA2", "lightblue", "#69c674"]
    }
  },
  methods: {
    consoleText: function(words, id, colors) {
      if (colors === undefined) colors = ["#fff"];
      var visible = true;
      var con = document.getElementById("console");
      var letterCount = 1;
      var x = 1;
      var waiting = false;
      var target = document.getElementById(id);
      if (!target || !con) return;
      target.setAttribute("style", "color:" + colors[0]);
      window.setInterval(function() {
        if (!target) return;
        if (letterCount === 0 && waiting === false) {
          waiting = true;
          target.innerHTML = words[0].substring(0, letterCount);
          window.setTimeout(function() {
            var usedColor = colors.shift();
            colors.push(usedColor);
            var usedWord = words.shift();
            words.push(usedWord);
            x = 1;
            target.setAttribute("style", "color:" + colors[0]);
            letterCount += x;
            waiting = false;
          }, 1000);
        } else if (letterCount === words[0].length + 1 && waiting === false) {
          waiting = true;
          window.setTimeout(function() {
            x = -1;
            letterCount += x;
            waiting = false;
          }, 1000);
        } else if (waiting === false) {
          target.innerHTML = words[0].substring(0, letterCount);
          letterCount += x;
        }
      }, 120);
      window.setInterval(function() {
        if (!con) return;
        if (visible === true) {
          con.className = "console-underscore hidden";
          visible = false;
        } else {
          con.className = "console-underscore";
          visible = true;
        }
      }, 400);
    }
  },
  mounted() {
    this.$nextTick(() => {
      this.consoleText(
        this.titles,
        "text",
        this.titleColors
      );
    });
  }
};
</script>

<style scoped>
.console-wrapper {
  display: inline;
  white-space: nowrap;
}
.console-underscore {
  display: inline-block;
  position: relative;
  top: -0.05em;
  left: 3px;
  font-weight: bold;
}
.hidden {
  opacity: 0;
}
</style>

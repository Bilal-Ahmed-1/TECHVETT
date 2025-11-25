<template>
    <div class="selection-section">
        <h2>Select a Level based on your Experience</h2>
        <form @submit.prevent="selectLevel" class="form-container">
            <div class="form-group">
                <label>Select that sort of level which you can easily go through it.</label>
                <div class="radio-tile-group">
                    <div v-for="level in levels" :key="level.id" class="input-container">
                        <input 
                            type="radio" 
                            :id="'level-' + level.id" 
                            :value="level.id" 
                            v-model="selectedLevel" 
                        />
                        <div class="radio-tile">
                            <img :src="level.imageUrl" alt="Level Image" class="level-image" />
                            <label :for="'level-' + level.id">{{ level.name }}</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="btn-display">
                <button type="submit" class="btn2 button-30" :disabled="loading">
                    Next&nbsp;&nbsp;<i class="fa-solid fa-diamond"></i>
                </button>
            </div>
        </form>
    </div>
</template>

<script>
export default {
    data() {
        return {
            selectedLevel: null,
            levels: [
                { id: 1, name: 'Beginner', imageUrl: '/images/2.png' },
                { id: 2, name: 'Intermediate', imageUrl: '/images/3.png' },
                { id: 3, name: 'Advanced', imageUrl: '/images/4.png' },
            ],
        };
    },
    methods: {
        selectLevel() {
            if (this.selectedLevel) {
                this.$emit('level-selected', this.selectedLevel);
            } else {
                alert("Please select a level.");
            }
        },
    },
};
</script>

<style scoped>
@import url("https://fonts.googleapis.com/css2?family=Roboto:wght@400&display=swap");

::after,
::before {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
}

body {
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    font-size: 20px;
    animation: transitionIn 0.75s;
}

.selection-section {
    color: #09c3e4;
    background: #1a1a1a;
    border-radius: 10px;
    border: 1px solid rgba(255, 255, 255, 0.18);
    box-shadow: 9px 13px 7px 5px rgba(0, 0, 0, 0.61);
    padding: 20px;
    margin-bottom: 20px;
    text-align: center;
}

h2 {
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    font-size: 20px;
}

.form-container {
    display: flex;
    flex-direction: column;
    align-items: center;
}

.radio-tile-group {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    column-gap: 10rem;
}

.input-container {
    position: relative;
    height: 7rem;
    width: 7rem;
    margin: 0.5rem;
}

.input-container input {
    position: absolute;
    height: 100%;
    width: 100%;
    margin: 0;
    cursor: pointer;
    z-index: 2;
    opacity: 0;
}

.input-container .radio-tile {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    height: 100%;
    border: 2px solid black;
    border-radius: 8px;
    background: #212626;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.input-container .radio-tile::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(0, 227, 255, 0.3), transparent);
    transition: left 0.4s ease;
}

.input-container input:hover + .radio-tile {
    transform: scale(1.05) rotate(2deg);
    box-shadow: 0 0 12px rgba(0, 227, 255, 0.5);
}

.input-container input:hover + .radio-tile::before {
    left: 100%;
}

.input-container input:checked + .radio-tile {
    background: linear-gradient(135deg, #212626 0%, #1a3c3f 100%);
    transform: scale(1.1) rotate(0deg);
    box-shadow: 0 0 15px rgba(0, 227, 255, 0.7);
    border: 2px solid #09c3e4;
}

.input-container label {
    color: black;
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-align: center;
}

.input-container input:checked + .radio-tile label {
    color: white;
}

.level-image {
    width: 70px;
    height: auto;
    margin-bottom: 10px;
}

.input-container input:checked + .radio-tile ion-icon,
.input-container input:checked + .radio-tile label {
    color: white;
}

/* Updated Next Button Styling (Inspired by start-btn) */
.btn2.button-30 {
  margin-top: 20px;
  padding: 14px 28px;
  font-size: 16px;
  color: #09c3e4;
  background: none;
  border: none;
  position: relative;
  cursor: pointer;
  font-family: 'Roboto Mono', monospace; /* Matches original typography */
  font-weight: bold;
  text-transform: uppercase; /* Trendy, tech vibe */
  letter-spacing: 1px;
  transition: color 0.3s ease;
}

.btn2.button-30::after {
  content: "";
  position: absolute;
  left: 0;
  bottom: -4px;
  width: 0;
  height: 2px;
  background-color: #09c3e4;
  transition: width 0.3s ease;
}

.btn2.button-30:hover:not(:disabled) {
  color: #ffffff;
  text-shadow: 0 0 8px rgba(9, 195, 228, 0.5); /* Subtle glow for trendy tech feel */
}

.btn2.button-30:hover::after {
  width: 100%;
}

.btn2.button-30:disabled {
  opacity: 0.5;
  cursor: not-allowed;
  color: #09c3e4; /* Maintains color when disabled */
}

.btn2.button-30:disabled::after {
  width: 0; /* No underline when disabled */
}
</style>
<template>
    <div class="selection-section">
        <h2>Select a Category</h2>
        <form @submit.prevent="selectCategory">
            <div class="form-group">
                <label>Select that field which you want to give that asessement.</label>
                <div class="radio-tile-group">
                    <div v-for="cat in categories" :key="cat.id" class="input-container">
                        <input 
                            type="radio" 
                            :id="'category-' + cat.id" 
                            :value="cat.id" 
                            v-model="selectedCategory" 
                        />
                        <div class="radio-tile">
                            <img :src="cat.imageUrl" alt="Category Image" class="category-image" />
                            <label :for="'category-' + cat.id">{{ cat.name }}</label>
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
    props: {
        categories: {
            type: Array,
            required: true,
        },
        loading: {
            type: Boolean,
            default: false,
        },
    },
    data() {
        return {
            selectedCategory: null,
            categories: [
                { id: 1, name: 'SQA', imageUrl: '/images/2.jpg' },
                { id: 2, name: 'Network', imageUrl: '/images/3.jpg' },
            ],
        };
    },
    methods: {
        selectCategory() {
            if (this.selectedCategory) {
                this.$emit('category-selected', this.selectedCategory);
            } else {
                alert("Please select a category.");
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
    font-size: 16px;
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

.input-container ion-icon {
    color: black;
    font-size: 3rem;
}

.input-container label {
    color: black;
    font-family: "Roboto", sans-serif;
    font-weight: 400;
    font-size: 16px;
    text-transform: uppercase;
    letter-spacing: 1px;
    text-align: center;
}

.input-container input:checked + .radio-tile ion-icon,
.input-container input:checked + .radio-tile label {
    color: white;
}

.category-image {
    width: 70px;
    height: 70px;
    margin-top: 10px;
    margin-bottom: 5px;
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
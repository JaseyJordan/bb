<template>
    <div class="mr-8 flex items-center">
        <button v-for="(color, theme) in themes"
                class="rounded-full w-4 h-4 mr-2 border border-default focus:outline-none"
                :style="{ 'background-color': color }"
                :class="{ 'border-accent': selectedTheme == theme }"
                @click="selectedTheme = theme ">
        </button>
    </div>
</template>

<script>
    export default {
        created() {
            this.selectedTheme = localStorage.getItem('theme') || 'theme-light';
        },
        data() {
            return {
                themes: {
                    'theme-light': '#f5f6f9',
                    'theme-dark': '#222'
                },
                selectedTheme: 'theme-light'
            };
        },

        watch: {
            selectedTheme() {
                document.body.className = document.body.className.replace(/theme-\w+/, this.selectedTheme);
                localStorage.setItem('theme', this.selectedTheme);
            }
        }
    }
</script>

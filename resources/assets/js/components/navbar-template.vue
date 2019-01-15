<template>
    <nav class="">
        <div class="level is-mobile">
            <div class="level-left"></div>
            <div class="level-right">
                <button class="button is-inverted level-item">
                    Add Task
                </button>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        data() {
            return {
              isActive: false
            }
        },
        methods: {
            toggleNavbar() {
                this.isActive = !this.isActive;
            }
        }
    }
</script>

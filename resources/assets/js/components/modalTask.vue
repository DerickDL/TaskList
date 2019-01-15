<template>

</template>

<script>
    export default {
        props: ['title', 'body'],
        methods: {
            addArticle() {
                vm.$parent.addArticle;
            }
        }
    }
</script>
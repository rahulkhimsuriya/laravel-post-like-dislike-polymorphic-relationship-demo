<template>
    <div class="row justify-content-center">
        <div class="d-flex align-items-center" v-if="loading">
            <strong>Loading...</strong>
        </div>
        <div class="col-md-8" v-if="posts">
            <Post
                v-for="post in posts"
                :post="post"
                :key="post.id"
                class="mb-4"
            />
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import Post from './Post.vue';

    export default {
        name: 'PostList',

        components: {
            Post,
        },

        data() {
            return {
                posts: '',
                loading: false,
            };
        },

        mounted() {
            this.loading = true;
            axios
                .get('/home')
                .then(({ data }) => (this.posts = data))
                .finally(() => (this.loading = false));
        },
    };
</script>

<style lang="css" scoped></style>

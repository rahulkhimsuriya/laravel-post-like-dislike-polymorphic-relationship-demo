<template>
    <div class="card">
        <div class="card-header">{{ post.title }}</div>

        <div class="card-body">
            {{ post.body }}
        </div>

        <div class="card-footer d-flex">
            <button
                class="btn btn-sm mr-2"
                :class="isLiked ? 'btn-primary' : 'btn-light'"
                @click="like"
                :disabled="isLikeLoading"
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                    v-if="isLikeLoading"
                ></span>
                LIKE {{ likesCount }}
            </button>

            <button
                class="btn btn-sm"
                :class="isDisLiked ? 'btn-danger' : 'btn-light'"
                @click="unlike"
                :disabled="isDisLikeLoading"
            >
                <span
                    class="spinner-border spinner-border-sm"
                    role="status"
                    aria-hidden="true"
                    v-if="isDisLikeLoading"
                ></span>
                DISLIKE {{ dislikesCount }}
            </button>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: 'Post',

        props: {
            post: {
                required: true,
                type: Object,
            },
        },

        data() {
            return {
                isLikeLoading: false,
                isDisLikeLoading: false,
                isLiked: this.post.isLiked,
                isDisLiked: this.post.isDisLiked,
                likesCount: this.post.likesCount,
                dislikesCount: this.post.dislikesCount,
            };
        },

        methods: {
            setData(post) {
                this.isLiked = post.isLiked;
                this.isDisLiked = post.isDisLiked;
                this.likesCount = post.likesCount;
                this.dislikesCount = post.dislikesCount;
            },

            like() {
                this.isLikeLoading = true;
                axios
                    .post(`/posts/${this.post.id}/like`)
                    .then(({ data }) => this.setData(data))
                    .finally(() => (this.isLikeLoading = false));
            },

            unlike() {
                this.isDisLikeLoading = true;
                axios
                    .post(`/posts/${this.post.id}/dislike`)
                    .then(({ data }) => this.setData(data))
                    .finally(() => (this.isDisLikeLoading = false));
            },
        },
    };
</script>

<style lang="css" scoped></style>

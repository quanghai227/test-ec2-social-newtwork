<template>
    <div class="show_modal" v-if="comments && comments.length > 0">
        <div class="__small_content" v-for="(cmt, index) in comments" :key="index">
            <img :src="cmt.user.avatar" width="30" height="30" alt="">
            <div class="comment_text ml-2">
                <span class="u__name">{{cmt.user.username}}</span> <br>
                <span class="text__content">{{cmt.content}}</span>
            </div>
        </div>
    </div>
</template>

<script>
import api from '@/services';

export default {
    name: 'ShowComment',
    props: ["post_id", 'add_comment'],
    data() {
        return {
            comments: [],
        };
    },
    async created() {
        // await this.fetchComments();
    },
    mounted() {
        this.fetchComments();
    },
    methods: {
        async fetchComments() {
            const result = await api.get('/comment/all-comments-post/' + this.post_id);
            // console.log('comments', result);
            if (result && result.statusCode == 200) {
                this.comments = result.resultData.comments;
                return;
            }
        },
        async fetchCommentsAfterCreate(p_id) {
            const result = await api.get('/comment/all-comments-post/' + p_id);
            if (result && result.statusCode == 200) {
                return result.resultData.comments;
            }
        },
    },
    watch: {
        add_comment: {
            handler(newVal){
                this.comments = newVal;
            },
            deep: true
        }
    },
}
</script>

<style scoped>
.show_modal {
    width: 100%;
    padding: 5px 20px;
}

.__small_content {
  display: flex;
  padding: 10px;
}
.__small_content img {
  border: 3px solid #3ca7ee;
  border-radius: 50%;
  object-fit: cover;
}
.comment_text {
  background: rgba(168, 165, 165, 0.301);
  border-radius: 8px;
  padding: 8px 10px;
  color: #f5f5f5;
  max-width: 90%;
}
.u__name:hover {
  text-decoration: underline;
}
.text__content {
word-wrap: break-word;
}

</style>
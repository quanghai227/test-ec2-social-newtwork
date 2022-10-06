<template>
    <div>
        <div class="card-header"><h3>Posts</h3></div>
        <div class="card card-body mb-2" v-for="article in posts" :key="article.id">
            <h4>{{ article.title }}</h4>
            <p>{{ article.content }}</p>
            <div>
                <div class="float-right">
                    <button class="btn btn-primary" @click="post = article">Edit</button>
                    <button class="btn btn-danger" @click="deletePost(article.id)">Delete</button>
                </div>
            </div>
        </div>
        <Pagination v-if="posts.length > 0" ref="child" :fetchList="fetchPosts" :pagination="page_data" @event_pagination="currentPagination"></Pagination>

    </div>
</template>

<script>
import api from '@/services';
import Pagination from "@/components/common/Pagination";

export default {
    data() {
        return {
            posts: [],
            post: {
                id: '',
                title: '',
                content: '',
                user: {},
                user_id: '',
            },
            page_data: {},
        };
    },
    components: {
        Pagination,
    },

    created() {
        this.fetchPosts(1);
    },

    methods: {
        async fetchPosts(page) {
            console.log('page', page)
            const response = await api.get('/post?page=' + page );
            this.posts = response.resultData.data.data;
            // console.log('list', response.resultData);
            this.page_data = Object.assign({}, response.resultData.data);
            
            if (response.status) {
                console.log("make pagination");
                this.$refs.child.makePagination(this.page_data);
            }
        },
        // getPagination(pagination) {
        //     this.pagination = pagination;
        // }
        currentPagination(currentPage) {
            this.page_data = currentPage;
        }
    }
};
</script>

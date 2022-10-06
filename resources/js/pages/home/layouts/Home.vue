<template>
  <div class="col-md-7">
    <div class="new__article">
      <div class="__user">
        <img :src="user.avatar" width="50" height="50" alt="avatar" @click="nextProfile(user.id)">
        <h3>{{user.username}}</h3>
      </div>
      <textarea name="" id="new_post" v-model="post_content" placeholder="What's on your mind?"></textarea>
      <div class="choose__img">
        <i class="far fa-images" style="font-size: 27px;"></i>
        <input type="file" @change="previewFiles" />
      </div>
      <hr>
      <button class="btn btn-block" @click="createNewPost">POST</button>
    </div>

    <article class="__article" v-for="(item, index) in posts" :key="index">
      <div class="card__post">
        <div class="u__info d-flex">
          <img :src="item.post_user.avatar" width="50" height="50" alt="" @click="nextProfile(item.post_user.id)">
          <div class="ml-2">
            <h5>{{item.post_user.username}}</h5>
            <!-- <span>{{item.post_user.username}}<small class="ml-3">{{item.created_at}}</small></span> -->
          </div>
        </div>
        <hr>
        <p>{{item.content}}</p>
        <div v-if="item.image">
          <img :src="item.image" alt="post image" class="post__img">
        </div>
        <div class="post__footer">
          <div class="__icon_post__active">
            <span ><i class="fas fa-thumbs-up" :class="{active_like: item.user_is_like}"></i> {{item.count_post_likes || 0}}</span>
            <span>1 comment</span>
          </div>
          <div class="__icon_post">
            <span :class="{active_like: item.user_is_like}" @click="handlerLikePost(item.id, index)"><i class="far fa-thumbs-up"></i> Like</span>
            <span><i class="far fa-comment-alt"></i> Comment</span>
          </div>
          <div class="__comment">
            <h6>View previous comments</h6>
            <template>
              <ShowComment :post_id="item.id" :add_comment="item.comments" ref="list_comments" />
            </template>
            
            <AddComment :post_id="item.id" @fetchComment="fetchComments(item.id, index)" /> 
            
          </div>
        </div>
      </div>
    </article>

  </div>
</template>

<script>
import api from '@/services';
import AddComment from '../comment/AddComment.vue'
import ShowComment from '../comment/ShowComment.vue'

export default {
  props: {
    user: {
      type: Object,
      default: {}
    }
  },
  components: {
    AddComment,
    ShowComment,
  },
  data() {
    return {
      posts: [],
      post: {
        id: '',
        title: '',
        content: '',
        image: '',
        user: {},
        user_id: '',
      },
      post_content: '',
      new_post_file: '',
      // add_comment: {}
    };
  },
  created() {
    this.fetchPosts();
    // this.fetchLikes();
  },
  methods: {
    async fetchPosts() {
      const response = await api.get('/post/all');
      
      console.log('list', response.resultData.data);
      if (response && response.statusCode == 200) {
        this.posts = response.resultData.data.data;
        return;
      }
    },
    async fetchLikes() {
      const result = await api.post('/post/post-likes', {post_id: 25});
      
      console.log('likes', result);
    },

    async createNewPost() {
      if (!this.post_content) {
        console.log('post null');
        return;
      }
      let newPost = new FormData();
      newPost.append('post_content', this.post_content);
      newPost.append('image', this.new_post_file);
      const result = await api.post('/post/add', newPost);
      
      if (result && result.statusCode == 200) {
        this.post_content = '';
        this.new_post_file = '';
        await this.fetchPosts();
        return;
      }
    },
    async handlerLikePost(post_id, index) {
      const result = await api.post('/post/like', {post_id: post_id, is_like: true});
      
      var countLike = this.posts[index].count_post_likes;
      if (result && result.statusCode == 200) {
        this.posts[index].count_post_likes = this.posts[index].user_is_like ? countLike - 1 : countLike + 1;
        this.posts[index].user_is_like = !this.posts[index].user_is_like;
        return;
      }
    },

    async fetchComments(post_id, index) {
      let newComments = await this.$refs.list_comments[index].fetchCommentsAfterCreate(post_id);
      this.posts[index].comments = newComments;
      // console.log('list_comment', index, post_id, this.posts[index]);
      
    },
    
    previewFiles(event) {
      this.new_post_file = event.target.files[0];
    },
    nextProfile(id) {
      this.$router.push({name: 'Profile', params: {id: id}})
    }
  },
  computed: {},
};
</script>

<style scoped>
.section__right {
  display: none;
  visibility: hidden;
}
.new__article {
  width: 100%;
  background:#444647;
  padding: 20px;
  margin: 20px 0;
  border-radius: 15px;
  box-shadow: 1px 1px rgba(36, 35, 35, 0.5);
  color: #f5f5f5;
}
.__user {
  display: flex;
  align-items: flex-end;
  margin-bottom: 20px;
}
.__user img {
  border: 3px solid #3ca7ee;
  border-radius: 50%;
  margin-right: 10px;
  object-fit: cover;
  cursor: pointer;
}
.new__article hr {
  margin: 20px 2px;
  background: rgba(155, 152, 152, 0.589);
}
#new_post , #new_comment{
  width: 100%;
  height: 40px;
  padding: 5px 20px;
  border:none;
  outline: none;
  border-radius: 20px;
  resize: none;
  overflow: hidden;
  font-size: 18px;
  background-color: rgba(192, 185, 185, 0.247);

  transition: 0.3s;
}
#new_post::placeholder, #new_comment::placeholder {
  color: #e2dcdc;
}
#new_post:hover , #new_comment:hover{
  background-color: rgba(190, 182, 182, 0.5);
  cursor: pointer;
}
#new_post:focus {
  min-height: 150px;
  padding: 10px;
  border-radius: 10px;
  overflow-y: scroll;
  background-color: #3a3b3c;
  color: #f5f5f5;
}
.new__article textarea::-webkit-scrollbar {
  width: 12px;
  background-color: #f5f5f5;
  border-radius: 0 12px 12px 0;
}
.new__article textarea::-webkit-scrollbar-thumb {
  border-radius: 10px;
  --webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
  background-color: #84868b;
}
.new__article button {
  background: #3ca7ee;
  font-size: 16px;
  color: white;
  font-weight: bold;
  border-radius: 10px;
}
/* .new__article textarea::-webkit-scrollbar-track {
  right: 20px;
} */


.__article {
  padding: 20px 0px;
  background:#444647;
  box-shadow: 1px 1px rgba(36, 35, 35, 0.438);
  margin: 20px 30px;
  border-radius: 15px;
  color: white;
}
.u__info {
  padding: 0 20px;
}
.u__info img{
  border: 3px solid #3ca7ee;
  border-radius: 50%;
  margin-right: 10px;
  object-fit: cover;
  cursor: pointer;
}
.__article p {
  margin: 20px 0;
  padding: 0 20px;
}
.__article .post__img {
  width: 100%;
}
.post__footer {
  margin-top: 20px;
  padding: 0 20px;
}
.__article hr {
  margin: 10px 20px;
  background: rgba(155, 152, 152, 0.589);
}
.__icon_post, .__icon_post__active {
  display: flex;
  justify-content: space-between;
  align-items: center;
}
.__icon_post {
  padding: 5px 0;
  margin: 10px 0;
  border-top: 1px solid rgba(155, 152, 152, 0.589);
  border-bottom: 1px solid rgba(155, 152, 152, 0.589);
  justify-content: space-around;
}
.__icon_post span {
  flex: 1;
  padding: 5px 0;
  cursor: pointer;
  font-size: 16px;
  text-align: center;
  border-radius: 5px;
  transition: 0.3s;
}
.__icon_post span:hover {
  background: rgba(184, 180, 180, 0.5);
}
.__icon_post__active i {
  cursor: pointer;
}
.active_like {
  color: #3ca7ee;
}


/* comment */
.__comment {
  margin-top: 10px;
}
.__comment h6{
  font-size: 16px;
}





</style>

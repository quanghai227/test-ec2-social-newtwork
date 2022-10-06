<template>
  <div class="col-md-3">
    <div class="panel panel-default left-sidebar">
      <div class="panel-heading title__sb-left">
        <img :src="user.avatar" width="50" height="50" style="margin: 5px" @click="toProfile(user.id)" />
        <h2 class="text-center">{{ user.username }}</h2>
      </div>
      <ul>
        <li>
          <i class="far fa-comment-dots"></i>
          <router-link to="/" class="link__item">News Feed</router-link>
        </li>
        <li>
          <i class="fas fa-user-friends"></i>
          <router-link to="/friends" class="link__item">Friend</router-link>
        </li>
        <li>
          <i class="far fa-comments"></i>
          <router-link to="/message" class="link__item">Message</router-link>
        </li>
        <li>
          <i class="fas fa-briefcase"></i>
          <router-link to="/job" class="link__item">Job</router-link>
        </li>
        <li>
          <i class="fas fa-globe"></i>
          <router-link to="/find-friend" class="link__item">Find Friend</router-link>
        </li>
      </ul>
      <h3>Contacts</h3>
      <hr style="background: rgba(155, 152, 152, 0.589)" />
      <template v-if="friends">
        <div class="friend__content" v-for="(friend, index) in friends" :key="index">
          <img
            :src="friend.avatar"
            width="50"
            height="50"
            alt="avatar"
            @click="toProfile(friend.id)"
          />
          <div class="user__name">
            <h5>{{ friend.username }}</h5>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script>
// import { mapState } from "vuex";

export default {
  name: "MenuLeft",
  props: {
    user: {
      type: Object,
      default: {},
    },
    friends: {
      type: Array,
      default: () => [],
    },
  },
  data() {
    return {
      friendsOfUser: [],
    };
  },
  created() {},
  methods: {
    toProfile($id) {
      this.$router.push({ name: "Profile", params: { id: $id } });
    },
  },
  computed: {},
};
</script>

<style scoped>
.left-sidebar {
  width: 22%;
  position: fixed;
  left: 30px;
  top: 77px;
  z-index: 2;
  color: white;
}
.left-sidebar li {
  padding: 10px;
  /* border-bottom: 1px solid #ddd; */
  list-style: none;
  margin-left: -20px;
  font-size: 18px;
  color: #3ca7ee;
}
.left-sidebar li:hover {
  background: #7073757a;
  border-radius: 10px;
}
.left-sidebar li i {
  margin-right: 10px;
}
.link__item {
  color: white;
  font-weight: bold;
  text-decoration: none;
}

.panel-heading {
  font-size: 22px;
}
.title__sb-left {
  width: 100%;
  padding: 5px 10px;
  display: flex;
  background: rgba(199, 193, 193, 0.5);
  border-radius: 10px;
  margin-bottom: 20px;
  box-shadow: 2px 2px rgba(31, 30, 30, 0.384);
}
.title__sb-left img {
  border: 3px solid #3ca7ee;
  border-radius: 50%;
  cursor: pointer;
}
.title__sb-left h2 {
  align-self: flex-end;
}

.friend__content {
  display: flex;
  align-items: center;
  border-radius: 10px;
  padding: 5px;
  margin: 5px 0;
}
.friend__content:hover {
  background: rgba(168, 165, 165, 0.301);
  cursor: pointer;
}

.friend__content img {
  border: 3px solid #3ca7ee;
  border-radius: 10px;
  object-fit: cover;
}
.user__name {
  background: rgba(168, 165, 165, 0.301);
  border-radius: 8px;
  padding: 8px 10px;
  margin-left: 10px;
  word-wrap: break-word;
}
</style>

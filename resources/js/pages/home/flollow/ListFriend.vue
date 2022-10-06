<template>
  <div class="list__friend col-md-9">
    <h3 class="mt-3">People You May Know</h3>
    <div class="row" v-if="suggested_friends.length > 0">
      <div class="col-md-4 mb-3" v-for="(friend, index) in suggested_friends" :key="index">
				<div class="friend--content">
					<img :src="friend.avatar"
          width="100%"
          height="250"
          alt="avatar"
          @click="nextProfile(friend.id)"
        />
        <h3 class="__user-name">{{ friend.username }}</h3>
				<button class="btn btn-primary" @click="addFriend(friend.id)">Add Friend</button>
				<button class="btn btn-default" @click="nextProfile(friend.id)">Profile</button>
				</div>
      </div>

    </div>
    <div class="row not__found" v-else>
			<h3 class="text-center">You don't have any invites right now</h3>
		</div>
  </div>
</template>

<script>
import { mapGetters } from "vuex";
import api from '@/services';

export default {
  name: "ListFriend",
  data() {
    return {
      suggested_friends: [],
    };
  },
  created() {
    this.init();
  },
  methods: {
    async init() {
      const result =  await api.get('/friend/all-suggested');
      // console.log('list friend', result);
      if (result && result.statusCode == 200) {
        this.suggested_friends = result.resultData.suggested_user;
        return;
      }
      console.log("Error", result.statusCode);
    },

    async addFriend(id) {
      const result =  await api.post('/friend/friend_request', {user_id : this.loginUserID, friend_id: id});
      console.log('add', result);
      if (result && result.statusCode == 200) {
        // hidden button add or call again init()
        await this.init();
        return;
      }
      console.log("Error", result.statusCode);
    },

    nextProfile($id) {
      this.$router.push({ name: "Profile", params: { id: $id } });
    },
  },
  computed: {
    ...mapGetters(["getUser"]),
    loginUserID() {
      return this.getUser.id;
    },
  },
};
</script>

<style scoped>
.list__friend {
  width: 100%;
	color: #f5f5f5;
  background: #18191a;
  border-radius: 5px;
}
.friend--content {
	display: flex;
	flex-direction: column;
	background: #242526;
	padding-bottom: 10px;
	border-radius: 15px;
	border: 1px solid #7073757a;
}
.friend--content img {
  object-fit: cover;
  cursor: pointer;
	border-radius: 15px 15px 0 0;
}
.__user-name {
	margin: 8px 20px;
}

.friend--content button {
	color: #2D88FF;
	font-size: 20px;
	background: #2D88FF33;
	margin: 5px 20px;
	border: none;
	border-radius: 8px;
}
.friend--content button:hover {
	background: #799fd133;
}

.not__found {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

</style>


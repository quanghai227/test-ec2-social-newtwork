<template>
  <div class="request__friend col-md-9">
    <h3 class="mt-3">My Friend Request</h3>
    <div class="row" v-if="request_friends.length > 0">
      <div class="col-md-4 mb-3" v-for="(friend, index) in request_friends" :key="index">
				<div class="friend--content">
					<img :src="friend.avatar"
          width="100%"
          height="250"
          alt="avatar"
          @click="goProfile(friend.id)"
        />
        <h3 class="__user-name">{{ friend.username }}</h3>
				<button class="btn btn-primary" @click="acceptFriend(friend.id)">Accept</button>
				<button class="btn btn-default" @click="blocked(friend.id)">Refuse</button>
				</div>
      </div>

    </div>
		<div class="row not__found" v-else>
			<h3 class="text-center">You don't have any invites right now</h3>
		</div>
  </div>
</template>

<script>
import { mapActions } from "vuex";
import api from '@/services';

export default {
  name: "RequestFriend",
  data() {
    return {
      request_friends: [],
    };
  },
  created() {
    this.allRequests();
  },
  methods: {
		...mapActions({
      allFriendRequest: 'allFriendsRequest',
		}),
		async allRequests() {
      let result = await this.allFriendRequest();

			console.log('friend_request', result);
			if (result && result.statusCode == 200) {
				this.request_friends = result.resultData.friends_request;
				return;
			}
      console.log("Error", result.statusCode);
    },
    async blocked(id) {
      const result =  await api.post('/friend/reply-request-friend', {friend_id: id, status: 'blocked'});
      console.log('blocked', result);
      if (result && result.statusCode == 200) {
        await this.allRequests();
        return;
      }
    },

		async acceptFriend(id) {
      const result =  await api.post('/friend/reply-request-friend', {friend_id: id, status: 'confirmed'});
      console.log('accept', result);
      if (result && result.statusCode == 200) {
        await this.allRequests();
        return;
      }
		},

    goProfile($id) {
      this.$router.push({ name: "Profile", params: { id: $id } });
    },
  },
  computed: {},
};
</script>

<style scoped>
.request__friend {
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


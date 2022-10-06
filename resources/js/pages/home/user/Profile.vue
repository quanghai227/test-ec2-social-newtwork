<template>
  <div class="col-md-9">
    <div class="card user__profile" v-if="profile">
      <div class="card-header card__header">
        <h3 class="text-center">Your Profile</h3>
        <div class="btn__add" v-if="isNotUserLogin">
          <button @click="handlerFriendRequest">
            <i class="fas mr-1" 
              :class="filterStatusFriend(changeIconUser)" 
              :disabled="checkFriend"></i>
            {{ checkFriend ? 'Friend' : 'Add Friend'}}</button>
          <button><i class="far fa-comment-dots mr-2"></i>Message</button>
        </div>
      </div>

      <div class="card-body">
        <div class="row profile">
          <div class="col-md-6 __avatar">
            <img
              :src="profile.avatar"
              width="300px"
              height="350px"
            />
          </div>
          <div class="col-md-6 __info">
            <div class="info__group">
              <label>Name: </label><span>{{ profile.name }}</span>
            </div>
            <div class="info__group">
              <label>User Name:</label><span>{{ profile.username }}</span>
            </div>
            <div class="info__group">
              <label>Gender: </label><span>{{ profile.gender == 1 ? 'Male' : 'Female'}}</span>
            </div>
            <div class="info__group">
              <label>Country: </label><span>{{ profile.country }}</span>
            </div>

            <div class="info__group __btn_edit-profile" v-if="!isNotUserLogin">
              <button class="btn btn-primary" @click="showFormUpdate">
                Edit Profile
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <template v-if="activeModal && !isNotUserLogin">
      <div class="card user__profile">
        <div class="card-header">
          <h3>update profile</h3>
        </div>
        <div class="card-body">
          <div class="form-group">
            <input type="text" class="form-control" v-model="dataUpdate.name" placeholder="User name...">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" v-model="dataUpdate.username" placeholder="Nick name...">
          </div>
          <div class="form-group">
            <input type="text" class="form-control" v-model="dataUpdate.country" placeholder="country...">
          </div>
          <div class="form-group">
            <input type="file" @change="previewFiles" multiple/>
          </div>
          <div class="form-group">
            <label class="mr-2">Gender: </label>
            <input type="radio" v-model="dataUpdate.gender" value="1" class="mr-2"
            /><label> Male</label>
            <input type="radio" v-model="dataUpdate.gender" value="0" class="mr-2" />
            <label> Female</label>
          </div>
        </div>
        <div class="card-footer">
          <button class="btn btn-primary" @click="handlerUpdateProfile">Save</button>
        </div>
      </div>
    </template>
    
  </div>
</template>

<script>
import { mapGetters, mapActions } from "vuex";

export default {
  data() {
    return {
      profile: {},
      dataUpdate: {
        name: "",
        username: "",
        avatar: "",
        country: "",
        gender: "",
        oldavatar: ""
      },
      activeModal: false,
      errors: [],
      token: "",
      isNotUserLogin: false,
      profile_id: '',
      changeIconUser: 'fa-user-plus',
      checkFriend: false,
    };
  },
  async created() {
    if (!this.$route.params.id) {
      return this.$router.push({
        name: 'NotFound',
      });
    };
    this.profile_id = this.$route.params.id;
    this.checkUserID();
    await this.handlerGetProfile();

    console.log('getFriendsRequest', this.friendsRequest);
    if(this.isNotUserLogin) {
      await this.checkFriendOfUser();
    }
    
  },
  mounted() {},
  methods: {
    ...mapActions({
      getUserStore: "getUserProfile",
      updateProfile: 'updateUserProfile',
      addFriend: 'requestAddFriend',
      checkFriendOfUserLogin: 'checkFriend',
    }),

    async handlerGetProfile() {
      let result = await this.getUserStore(this.profile_id);

      if(result && !result.resultData) {
        return this.$router.push({
          name: 'NotFound',
        });
      }
      
      if (result && result.statusCode == 200) {
        this.profile = Object.assign({}, result.resultData);
        this.dataUpdate = result.resultData;
        this.dataUpdate.oldavatar = this.profile.avatar ?? '';
        return;
      }

      if (result && result.statusCode == 422) {
        this.errors = result.data.errors;
      }
    },
    previewFiles(event) {
      // console.log(event.target.files[0]);
      this.dataUpdate.avatar = event.target.files[0];
    },
    async handlerUpdateProfile() {
      let formUpdate = new FormData();
      Object.keys(this.dataUpdate).forEach(item => {
        formUpdate.append(item, this.dataUpdate[item]);
      })

      let result = await this.updateProfile({id : this.loginUserID, data: formUpdate});
      
      if (result && result.statusCode == 200) {
        this.dataUpdate = Object.assign({}, result.resultData);
        this.profile = Object.assign({}, result.resultData);
        return;
      }

      if (result && result.statusCode == 422) {
        this.errors = result.data.errors;
      }
    },

    async handlerFriendRequest() {
      if (this.checkFriend) {
        console.log('da co user');
        return;
      }
      let result = await this.addFriend({user_id : this.loginUserID, friend_id: this.profile_id});
      
      if (result && result.statusCode == 200) {
        await this.checkFriendOfUser();
      }
    },
    
    async checkFriendOfUser() {
      let result = await this.checkFriendOfUserLogin({profile_id: this.profile_id});
      // console.log('check friend', result);
      if (result && result.statusCode == 200) {
        this.checkFriend = result.resultData.check_friend;
        if (result.resultData.check_friend) {
          this.changeIconUser = result.resultData.friendship.status;
          return;
        }
        
      }
    },

    deleteImage() {

    },
    filterStatusFriend(status) {
      switch(status) {
        case 'pending':
          return 'fa-check';
        case 'confirmed':
          return 'fa-user-check';
        case 'blocked':
          return 'fa-user-minus';
        default:
          return 'fa-user-plus';
      }
    },
    showFormUpdate() {
      this.activeModal = !this.activeModal;
    },
    checkUserID() {
      if(this.profile_id != this.loginUserID) {
        this.isNotUserLogin = true;
        return;
      }
      this.isNotUserLogin = false;
    }
  },
  computed: {
    ...mapGetters(["getUser", "getFriendsRequest"]),
    loginUserID() {
      return this.getUser.id;
    },
    friendsRequest() {
      return this.getFriendsRequest;
    }
  },
  // watch: {
  //   isNotUserLogin: {
  //     handler(){
  //       this.checkUserID();
  //     },
  //     deep: true
  //   }
  // },
  
};
</script>

<style scoped>
.user__profile {
  width: 100%;
  background:#444647;
  padding: 20px;
  margin: 20px 0;
  border-radius: 15px;
  box-shadow: 1px 1px rgba(36, 35, 35, 0.5);
  color: #f5f5f5;
}
.card__header {
  display: flex;
  justify-content: space-between;
}
.btn__add button {
  border: none;
  outline: none;
  padding: 5px 10px;
  margin: 0 5px;
  background: #3a3b3c;
  border-radius: 6px;
  font-size: 18px;
  color: white;
  font-weight: bold;
}
.btn__add button:first-child {
  background: #3ca7ee;
}
.btn__add button:first-child:hover {
  background: #3da9f19f;
}
.btn__add button:last-child:hover {
  background: rgba(168, 165, 165, 0.301);
}

.__avatar {
  padding: 5px;
  border: 2px solid rgba(155, 146, 146, 0.589);
  border-radius: 15px;
  cursor: zoom-in;
  overflow: hidden;
}
.__avatar img {
  width: 100%;
  height: 100%;
  border-radius: 15px;
  border: 1px solid rgba(155, 146, 146, 0.589);
}
.__info {
  font-size: 20px;
}
.info__group {
  display: flex;
  padding: 24px 10px;
}
.info__group label {
  flex: 1;
  font-weight: bold;
}
.info__group span {
  flex: 1;
  font-size: 16px;
}
.__btn_edit-profile {
  float: right;
}

.card-footer {
  text-align: right;
}
.disabled-click { 
  pointer-events: none 
}
</style>

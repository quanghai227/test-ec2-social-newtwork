<template>
  <div class="__app_social_network">
    <Header />
    <div class="row wapper__body">
      <SidebarLeft :user="loginUser" :friends="friendsS" />
      <router-view :key="$route.path" class="main__layout" :user="loginUser" />
      <!-- <right-panel></right-panel> -->
    </div>
    <!-- <Footer /> -->
  </div>
</template>

<script>
import Header from "./common/Header";
import SidebarLeft from "./common/MenuLeft";
import RightPanel from "./common/RightPanel";
// import Footer from "./common/Footer";
import { mapState, mapGetters, mapActions } from "vuex";

export default {
  components: {
    Header,
    SidebarLeft,
    RightPanel,
    // Footer,
  },
  data() {
    return { friendsS: []};
  },
  created() {
    this.init();
  },
  mounted() {
    
  },
  methods: {
    ...mapActions({
      getFriends: 'allFriends',
    }),
    async init() {
      if (!this.isLogin) {
        this.$router.push({
          name: "Login",
        });
      }
      const result = await this.getFriends();
      
      if (result && result.statusCode == 200) {
        this.friendsS = result.resultData.friends;
      }
    },
  },
  computed: {
    ...mapState({ friendsStore: (state) => state.friends}),
    // ...mapState(["friends"]),
    ...mapGetters(["isLoggedIn", "getUser"]),
    isLogin() {
      return this.isLoggedIn;
    },
    loginUser() {
      return this.getUser ?? {};
    },
    userFriends() {
      return this.friends;
    }
  },
};
</script>

<style scoped>
.__app_social_network {
  height: 100vh;
  overflow-x: hidden;
  background-color: #252627;
}
.__app_social_network .row {
  min-height: 77%;
  padding: 15px 30px;
}
.wapper__body {
  margin-top: 67px;
}
.main__layout {
  min-height: calc(70%);
  /* background: white; */
  padding: 0 25px;
}

</style>


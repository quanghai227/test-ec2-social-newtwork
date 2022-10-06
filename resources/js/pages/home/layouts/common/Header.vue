<template>
  <div class="__nav_header">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark">
      <div class="container">
      <router-link class="navbar-brand mr-auto" to="/">Social Network</router-link>
      <button
        class="navbar-toggler ml-auto"
        style="float: right"
        type="button"
        data-toggle="collapse"
        data-target=".dual-collapse2"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <div class="
          navbar-collapse
          collapse
          w-100
          order-1 order-md-0
          dual-collapse2
          ml-4
        "
      >
        <form class="form-inline my-2 my-lg-0" @submit.prevent="searchFilter" >
          <input
            class="form-control mr-sm-2"
            type="search"
            placeholder="Search"
            aria-label="Search"
            v-model="searchContent"
          />
          <button class="btn btn-outline-primary my-2 my-sm-0" type="submit">
            Search
          </button>
        </form>
      </div>

      <div class="navbar-collapse collapse w-100 order-3 dual-collapse2">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item active">
            <router-link class="nav-link" to="/"><i class="fas fa-home icon__big"></i></router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/groups"><i class="fas fa-users icon__big"></i></router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/friends"><i class="fas fa-user-friends icon__big"></i></router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/request-friends"><i class="fas fa-bell icon__big mr-2"></i>Notification</router-link>
          </li>
          <li class="nav-item dropdown">
            <a
              class="nav-link dropdown-toggle"
              href="#"
              id="navbarDropdown"
              role="button"
              data-toggle="dropdown"
              aria-haspopup="true"
              aria-expanded="false"
            >
              <!-- Dropdown -->
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
              <router-link class="dropdown-item" to="/profile">Profile</router-link>
              <a class="dropdown-item" href="#">Another action</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">Something else here</a>
            </div>
          </li>
          <li class="nav-item">
            <a class="nav-link" @click="goLogout">Logout</a>
          </li>
        </ul>
      </div>
      </div>
    </nav>
    <!-- <BreadCrumb /> -->
  </div>
</template>

<script>
// import BreadCrumb from "./BreadCrumb";
import { mapActions } from "vuex";
import api from '@/services';

export default {
  name: "Header",
  components: {
  },
  data() {
    return {
      navItemClick: false,
      searchContent: '',
    };
  },
  methods: {
    ...mapActions({logoutA: "logout"}),
    goLogout() {
      let result = this.logoutA();
      if(result) {
        this.$router.push({
          name: "Login",
        });
      }
    },
    async searchFilter() {
      if (!this.searchContent) {
        console.log('filter null');
        return;
      }
      const result = await api.get('/search-filter/' + this.searchContent);
      console.log('search', result);
    }
  },
  computed: {},
};
</script>

<style scoped>
.__nav_header {
  width: 100%;
  position: fixed;
  left: 0;
  top: 0;
  z-index: 20;
}
.__nav_header .nav-item {
  font-size: 16px;
}
.icon__big {
  font-size: 25px;
}
.navbar {
  border-bottom: 1px solid rgb(138, 134, 134);
}
.navbar-brand {
  font-size: 25px;
}
</style>

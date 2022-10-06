<template>
  <div class="__signup">
    <form>
      <div class="card__register">
        <h1 class="text-center">Register</h1>
        <div class="form-group">
          <input
            type="text"
            v-model="user.name"
            class="form-control"
            placeholder="Name"
          />
          <p class="text-danger" v-if="errors && errors.name">
            {{ errors.name[0] }}
          </p>
        </div>
        <div class="form-group">
          <input
            type="text"
            v-model="user.userName"
            class="form-control"
            placeholder="User Name"
          />
          <p class="text-danger" v-if="errors && errors.userName">
            {{ errors.userName[0] }}
          </p>
        </div>
        <div class="form-group">
          <input
            type="email"
            v-model="user.email"
            class="form-control"
            placeholder="Email"
          />
          <p class="text-danger" v-if="errors && errors.email">
            {{ errors.email[0] }}
          </p>
        </div>
        <div class="form-group">
          <input
            type="password"
            v-model="user.password"
            placeholder="Password"
            class="form-control"
          />
          <p class="text-danger" v-if="errors && errors.password">
            {{ errors.password[0] }}
          </p>
        </div>
        <div class="form-group">
          <input
            type="password"
            v-model="user.password_confirmation"
            placeholder="Password Confirm"
            class="form-control"
          />
          <p class="text-danger" v-if="errors && errors.password_confirmation">
            {{ errors.password_confirmation[0] }}
          </p>
        </div>
        <div class="form-group">
          <!-- <select v-model="user.gender" class="form-control" required placeholder="Gender" autocomplete="gender">
              <option value="1">Male</option>
              <option value="0">Female</option>
          </select> -->
          <label class="mr-2">Gender: </label>
          <input
            type="radio"
            v-model="user.gender"
            value="1"
            class="mr-2"
          /><label> Male</label>
          <input
            type="radio"
            v-model="user.gender"
            value="0"
            class="mr-2"
          /><label> Female</label>
          <p class="text-danger" v-if="errors && errors.gender">
            {{ errors.gender[0] }}
          </p>
        </div>
        <div class="form-group">
          <input
            type="text"
            v-model="user.country"
            class="form-control"
            placeholder="Country"
          />
          <p class="text-danger" v-if="errors && errors.country">
            {{ errors.country[0] }}
          </p>
        </div>
        <div class="form-group" v-if="addSuccess">
          <div class="alert alert-outline-success">
            Đăng ký thành công, Bạn muốn <router-link to="/login"> Đăng nhập</router-link>
          </div>
        </div>
        <div class="form-group btn__save">
          <button class="btn btn-primary col-6" @click.prevent="addUser">
            Register
          </button>
          <router-link to="/login" class="btn btn-default col-6">Cancel</router-link>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import { mapActions } from "vuex";

export default {
  data() {
    return {
      user: {
        name: "",
        userName: "",
        email: "",
        password: "",
        password_confirmation: "",
        gender: "",
        country: "",
      },
      errors: {},
      addSuccess: false,
    };
  },
  created() {},
  computed: {},
  methods: {
    ...mapActions({
      createUser: "register",
    }),

    async addUser() {
      let result = await this.createUser(this.user);
      
      if(result && result.statusCode == 200) {
        this.addSuccess = result.status;
        this.errors = [];
        return;
      }

      if (result && result.statusCode == 422) {
        this.errors = result.errors;
        this.addSuccess = false;
        return;
      }
    },
    async accessLogin() {
      //api login something
    }
  },
};
</script>

<style scoped>
.__signup {
  background: linear-gradient(120deg, #3ca7ee, #9b408f);
  height: 100vh;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}
.card__register {
  width: 400px;
  min-height: 480px;
  border: none;
  border-radius: 10px;
  background: white;
  padding: 20px;
}
.btn__save {
	display: flex;
}
</style>

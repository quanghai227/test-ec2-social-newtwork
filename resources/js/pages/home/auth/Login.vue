<template>
  <div class="__signin">
    <form style="width: 600px; margin: auto">
      <div class="card__login">
        <h2 class="text-center">{{ $t("auth.auth_login.title") }}</h2>
        <p class="text-right">
          <span @click="changeLocale('vi')" style="cursor: pointer">Vi</span>/
          <span @click="changeLocale('en')" style="cursor: pointer">En</span>
        </p>
        <hr />
        <div class="form-group">
          <label>Email</label>
          <input type="email" v-model="user_login.email" class="form-control" />
          <p class="text-danger" v-if="errors && errors.email">
            {{ errors.email[0] }}
          </p>
        </div>
        <div class="form-group">
          <label>Password</label>
          <input
            type="password"
            v-model="user_login.password"
            class="form-control"
          />
          <p class="text-danger" v-if="errors && errors.password">
            {{ errors.password[0] }}
          </p>
        </div>
        <div class="form-group">
          <input type="checkbox" v-model="user_login.remember_me" />
          <label>Remember Me</label>
        </div>
        <div class="form-group" v-if="unAuthor">
          <div class="alert alert-danger">
            {{unAuthor}}
          </div>
        </div>
        <div class="form-group">
          <button class="btn btn-primary" @click.prevent="handlerLogin">
            Login
          </button>
          <router-link to="/register" class="btn btn-link"
            >Do not have an account? Register</router-link
          >
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
      user_login: {
        email: "",
        password: "",
        remember_me: false,
      },
      errors: [],
      unAuthor: '',
    };
  },
  computed: {},
  created() {
  },
  methods: {
    ...mapActions({
      loginStore: "login",
    }),
    async handlerLogin() {
      let result = await this.loginStore(this.user_login);
      
      if (result && result.statusCode == 200) {
        return this.$router.push({
          name: "Home",
        });
      }

      if (result && result.statusCode == 422) {
        this.errors = result.errors;
        this.unAuthor = '';
        return;
      }

      if (result && result.statusCode == 401) {
        this.unAuthor = result.message;
        this.errors = [];
        return;
      }
    },
    changeLocale(locale) {
      this.$i18n.locale = locale;
    },
  },
};
</script>

<style scoped>
.__signin {
  background: linear-gradient(120deg, #3ca7ee, #9b408f);
  height: 100vh;
  overflow: hidden;
  display: flex;
  justify-content: center;
  align-items: center;
}
.card__login {
  width: 400px;
  min-height: 480px;
  border: none;
  border-radius: 10px;
  background: white;
  padding: 20px;
  margin: auto;
}
</style>

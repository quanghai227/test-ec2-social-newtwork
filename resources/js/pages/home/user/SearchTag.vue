<template>
  <div class="col-md-7 search">
    <div class="wrapper">
		<h2 class="title">Search Tags</h2>
		<div class="st__content">
			<input type="text" placeholder="Type and Enter">
		</div>
		<button class="remove-all">Clear All</button>
	</div>
  </div>
</template>

<script>
// import { mapGetters } from "vuex";

export default {
  data() {
    return {
      // isLogin: false,
    };
  },
  created() {
    
  },
  methods: {
  },
  computed: {},
};
</script>

<style scoped>
.wrapper {
    background: white;
    border-radius: 10px;
    width: 450px;
    padding: 20px;
}

.title {
    font-size: 22px;
}

.st__content {
    border: 1px solid #888;
    padding: 10px;
    display: flex;
    flex-wrap: wrap;
    margin-top: 10px;
    border-radius: 5px;
}

.st__content li {
    background: var(--primary-color);
    color: white;
    border-radius: 3px;
    list-style: none;
    margin: 4px 3px;
    padding: 5px 8px;
    display: flex;
    align-items: center;
}

.st__content li i {
    font-size: 16px;
    margin-left: 5px;
    cursor: pointer;
}
.st__content li i:hover {
    border: 1px solid rgb(180, 175, 175);
    border-radius: 2px;
}

.st__content input {
    border: none;
    outline: none;
    font-size: 18px;
    margin: 5px;
    flex: 1;
}

.remove-all {
    background: #8cc84c;
    border: none;
    outline: none;
    border-radius: 5px;
    color: white;
    padding: 10px 20px;
    font-size: 16px;
    margin-top: 20px;
    cursor: pointer;
}
.remove-all:hover {
    background: #486924;
}
</style>

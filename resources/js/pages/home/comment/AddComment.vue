<template>
    <div class="add_modal">
        <textarea 
        id="new_comment" 
        v-model="new_comment" 
        placeholder="Write a comment..." 
        @keyup.enter="newComment(new_comment)"
        >
        </textarea>
    </div>
</template>

<script>
import api from '@/services';

export default {
    name: 'AddComment',
    props: ["post_id"],
    data() {
        return {
            new_comment: '',
        };
    },
    created() {

    },
    methods: {
        async newComment(new_comment) {
            const result = await api.post('/comment/add', {post_id: this.post_id, content: new_comment});
            
            if (result && result.statusCode == 200) {
                this.new_comment = '';
                this.$emit('fetchComment');
                return;
            }
        },
    }
}
</script>

<style>
.add_modal {
    width: 100%;
    padding: 5px 20px;
}
#new_comment{
  width: 100%;
  height: 35px;
  padding: 5px 10px;
  border:none;
  outline: none;
  border-radius: 8px;
  resize: none;
  overflow: hidden;
  font-size: 15px;
  background-color: rgba(192, 185, 185, 0.247);

  transition: 0.3s;
}
#new_comment::placeholder {
  color: #e2dcdc;
}
#new_comment:hover{
  background-color: rgba(190, 182, 182, 0.5);
  cursor: pointer;
}
#new_comment:focus {
  min-height: 80px;
  padding: 10px;
  border-radius: 10px;
  overflow-y: scroll;
  background-color: #3a3b3c;
  color: #f5f5f5;
}
.add_modal textarea::-webkit-scrollbar {
  width: 10px;
  background-color: #f5f5f5;
  border-radius: 0 12px 12px 0;
}
.add_modal textarea::-webkit-scrollbar-thumb {
  border-radius: 10px;
  --webkit-box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.1);
  background-color: #84868b;
}
</style>
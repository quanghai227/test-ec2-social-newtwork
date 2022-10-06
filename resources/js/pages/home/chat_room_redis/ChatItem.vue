<template>
    <div class="message" :class="{'is-current-user': getUser.id === message.from_user}">
        <div class="message-item user-name">
            {{ message.from_contact != null ? message.from_contact.username : message.id}}
        </div>
        <div class="message-item timestamp">
            | {{ message.created_at }}:
<!--            | {{ message.created_at.split(' ')[1] }}:-->
<!--    nen tao 1 model chat room rieng vao database de test        -->
        </div>
        <div class="message-item text-message">
            {{ message.text }}
        </div>
    </div>
</template>

<script>
import {mapGetters} from "vuex";

export default {
    props: {
        message: {
            type: Object,
            default: {}
        }
    },
    mounted() {
        console.log('check message', this.message)
    },
    computed: {
        ...mapGetters(['getUser'])
    }
}
</script>

<style lang="scss" scoped>
.message {
    display: flex;
    color: #00b8ff;
    .message-item:not(:last-child) {
        margin-right: 5px;
    }
}
.message:not(:last-child) {
    padding-bottom: 20px;
}
.is-current-user {
    color: #a900ff;
}
</style>


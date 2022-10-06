<template>
    <div class="conversation">
        <h1>{{ contact ? contact.name : 'Select a Contact' }}</h1>
        <MessagesFeed :contact="contact" :messages="messages"/>
        <MessageComposer @send="sendMessage"/>
    </div>
</template>

<script>
import MessagesFeed from './MessagesFeed';
import MessageComposer from './MessageComposer';
import {mapGetters} from "vuex";
export default {
    props: {
        contact: {
            type: Object,
            default: null
        },
        messages: {
            type: Array,
            default: []
        }
    },
    computed: {
        ...mapGetters(['getToken'])
    },
    methods: {
        sendMessage(text) {
            if (!this.contact) {
                return;
            }

            console.log("data response when send", text)
            axios.post('api/message/conversation/send', {
                contact_id: this.contact.id,
                text: text
            }, {headers: {Authorization: 'Bearer ' + this.getToken }}).then((response) => {
                this.$emit('new', response.data);
            })
        }
    },
    components: {MessagesFeed, MessageComposer}
}
</script>

<style lang="scss" scoped>
.conversation {
    flex: 5;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    background: #242526;
    color: white;

    h1 {
        font-size: 20px;
        padding: 10px;
        margin: 0;
        border-bottom: 1px dashed lightgray;
    }
}
</style>

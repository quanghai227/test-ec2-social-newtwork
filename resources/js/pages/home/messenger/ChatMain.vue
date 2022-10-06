<template>
    <div class="chat-app col-md-12">
        <Header />
        <div class="row message_content">
            <ContactsList :contacts="contacts" @selected="startConversationWith"/>
            <Conversation :contact="selectedContact" :messages="messages" @new="saveNewMessage"/>
        </div>
        
        
    </div>
</template>

<script>
import Header from "../layouts/common/Header";
import Conversation from './Conversation';
import ContactsList from './ContactsList';
import { mapGetters } from "vuex";
import api from '@/services';

export default {
    // props: {
    //     user: {
    //         type: Object,
    //         required: true
    //     }
    // },
    data() {
        return {
            selectedContact: null,
            messages: [],
            contacts: [],
            user: {},
        };
    },
    mounted() {
        this.user = Object.assign({}, this.getUser) ;

        Echo.private(`messages.${this.user.id}`)
            .listen('MessageEvent', (e) => {
                this.hanleIncoming(e.message);
            });
        // axios.get('api/message/contacts', {headers: { Authorization: 'Bearer ' + this.getToken }})
        //     .then((response) => {
        //         this.contacts = response.data;
        //     });

        this.contactFriends();
    },
    computed: {
        ...mapGetters(['getUser', 'getToken'])
    },
    methods: {
        async contactFriends() {
            const result = await api.get('/message/contacts');
            console.log("contact ", result);
            if (result && result.statusCode == 200) {
                this.contacts = result.resultData;
            }
        },
        startConversationWith(contact) {
            this.updateUnreadCount(contact, true);
            axios.get(`api/message/conversation/${contact.id}`, {headers: {Authorization: 'Bearer ' + this.getToken }})
                .then((response) => {
                    this.messages = response.data;
                    this.selectedContact = contact;
                })
        },
        saveNewMessage(message) {
            this.messages.push(message);
        },
        hanleIncoming(message) {
            if (this.selectedContact && message.from == this.selectedContact.id) {
                this.saveNewMessage(message);
                return;
            }
            this.updateUnreadCount(message.from_contact, false);
        },
        updateUnreadCount(contact, reset) {
            this.contacts = this.contacts.map((single) => {
                if (single.id !== contact.id) {
                    return single;
                }
                if (reset)
                    single.unread = 0;
                else
                    single.unread += 1;
                return single;
            })
        }
    },
    components: {Conversation, ContactsList, Header}
}
</script>


<style lang="scss" scoped>
.chat-app {
    // display: flex;
    background: #18191a;
}
.message_content {
    margin-top: 70px;
    width: 100%;
    padding: 10px 20px;
    background: #18191a;
}
</style>

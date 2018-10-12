<template>
    <div>
        <div class="alert alert-success mb-1">{{ users.length }} Online</div>
        <chat-message v-if="messages.length" v-for="message in messages" :message="message" :key="message.id"></chat-message>
        <p v-if="!messages.length" class="d-flex justify-content-center py-5">There is nothing here! Start sending a message</p>
        <chat-form @stored="pushMessage"></chat-form>
    </div>
</template>

<script>
import ChatMessage from './ChatMessage.vue'
import ChatForm from './ChatForm.vue'

export default {
    components: {
        ChatMessage,
        ChatForm,
    },
    data() {
        return {
            messages: [],
            users: [],
        }
    },
    methods: {
        pushMessage(data) {
            this.messages.push(data)
        },
    },
    created() {
        axios.get('/chat').then(response => {
            this.messages = response.data
        })

        Echo.join('chatroom')
            .here(users => (this.users = users))
            .joining(user => {
                this.users.push(user)
            })
            .leaving(user => {
                this.users = this.users.filter(person => person != user)
            })
            .listen('MessageStored', message => {
                this.pushMessage(message.message)
            })

        console.log(Echo)
    },
}
</script>

<style scoped>
.alert {
    border-radius: 0;
}
</style>

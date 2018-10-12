<template>
    <div class="chat-form">
        <input type="text" v-model="body" @keyup.enter="store" placeholder="Your message here...">
        <button class="btn btn-primary" @click="store">Send</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            body: '',
        }
    },
    methods: {
        store() {
            axios
                .post('/chat', {
                    body: this.body,
                })
                .then(response => {
                    this.body = ''
                    this.$emit('stored', response.data)
                })
        },
    },
}
</script>

<style>
.chat-form {
    display: flex;
}

.chat-form input {
    flex: 1;
    border: 0;
    border-top: solid #e6e7e6 1px;
    padding: 0.375rem 0.75rem;
}

.chat-form button {
    border-radius: 0;
}
</style>

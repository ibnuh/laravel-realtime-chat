<template>
    <div class="p-2">
        <div>{{ message.body }}</div>
        <small>{{ message.user.name }}</small>
    </div>
</template>

<script>
export default {
    props: ['message'],
}
</script>

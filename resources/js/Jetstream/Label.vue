<template>
    <label class="block font-medium text-sm text-gray-700">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot></slot></span>
        <span v-if="required" class="text-sm text-red-500 ml-1">*</span>
        <span v-else class="text-sm text-gray-500 ml-2">(optional)</span>
    </label>
</template>

<script>
    import { defineComponent } from 'vue'

    export default defineComponent({
        props: ['value', 'required']
    })
</script>

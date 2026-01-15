<script setup>
const props = defineProps({
  modelValue: {
    type: [String, Number, null],
    required: true,
  },
  labelname: {
    type: String,
    required: true,
  },
  rows: {
    type: Number,
    default: 'text',
  },
  cols: {
    type: Number,
    default: 'text',
  },
  placeholder: {
    type: String,
    default: null,
  },
  maxlength: {
    type: Number,
    default: null,
  },
  message: String,
})

const emit = defineEmits(['update:modelValue'])
</script>

<template>
    

    <label>{{ labelname }}</label>
    <textarea :rows="rows" :cols="cols" :placeholder="placeholder" :value="props.modelValue" @input="emit('update:modelValue', $event.target.value)" :class="{'red' : message}" class="w-100 form-control border-0 mb-4" :maxlength="maxlength">
    </textarea>
    <span v-if="message" style="color:red;">{{ message }}</span>
 
 
</template>
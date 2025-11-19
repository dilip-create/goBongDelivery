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
  type: {
    type: String,
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
    <input :type="type" :placeholder="placeholder" :value="props.modelValue" @input="emit('update:modelValue', $event.target.value)" :class="{'red' : message}" class="w-100 form-control py-3 mb-4" :maxlength="maxlength"/>
    <span v-if="message" style="color:red;">{{ message }}</span>
 
 
</template>




<!-- <script>
    const model = defineModel({
        type: null,
        required: true,
    });
    defineProps({
        name: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        message: String,
    });
</script>
<template>
    <div class="mb-6">
        <label>{{ name }}</label>
        <input :type="type" v-model="model" />
        <span style="color:red;" v-if="message">{{ message }}</span>
    </div><br />
</template> -->

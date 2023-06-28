<template>
    <div>
        <a class="btn btn-default" @click="toggleShow">Select Image</a>
        <my-upload field="img" 
            @crop-success="cropSuccess" 
            @crop-upload-success="cropUploadSuccess"
            @crop-upload-fail="cropUploadFail" 
            v-model="show" 
            :width="300" 
            :height="300" 
            :params="params"
            :headers="headers" 
            lang-type="en" 
            img-format="png"
            >
        </my-upload>
        <!--  url="/upload"  -->
        <img :src="imgDataUrl ?? src" :name="field" :v-model="imgDataUrl" class="img-rounded" width="200">
    </div>
</template>

<script>
import myUpload from 'vue-image-crop-upload';

export default {    
    
    data() {
        return {
            show: false,
            params: {
                token: '123456798',
                name: 'avatar'
            },
            headers: {
                smail: '*_~'
            },
            imgDataUrl: null // the datebase64 url of created image
        };
    },
    props: {
        modelValue: {
            type: [String, Number],
        },
        title: {
            type: String,
        },
        field: {
            type: String,
        },
        type: {
            type: String,
            default: "text",
        },
        col: {
            type: String,
        },
        req: {
            type: Boolean,
            default: false,
        },
        placeholder: {
            type: String,
        },
        disabled: {
            type: Boolean,
            default: false,
        },
        readonly: {
            type: Boolean,
            default: false,
        },
        src: {
            type: String,
            default: false,
        },

    },

    inject: ["validate"],

    components: {
        'my-upload': myUpload
    },

    methods: {
        // image
        toggleShow() {
            this.show = !this.show;
        },

        cropSuccess(imgDataUrl, field) {
            this.$emit('update:modelValue', imgDataUrl)
            console.log('-------- crop success --------');
            this.imgDataUrl = imgDataUrl;
        },

        cropUploadSuccess(jsonData, field) {
            console.log('-------- upload success --------');
            console.log(jsonData);
            console.log('field: ' + field);
        },

        cropUploadFail(status, field) {
            console.log('-------- upload fail --------');
            console.log(status);
            console.log('field: ' + field);
        }
    }
};
</script>
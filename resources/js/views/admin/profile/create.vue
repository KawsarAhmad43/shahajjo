<template>
  <create-form @onSubmit='submit'>
    <div class='row align-items-center'>
        <Input v-model='data.name' field='data.name' title='Name' :req='true' />
				<Input v-model='data.email' field='data.email' title='Email' :req='true' />
				<Input v-model='data.phone' field='data.phone' title='Phone' :req='false' />
				<File title='Image' field='data.image' mime='img' fileClassName='data.image' :req='false'/>
				<File title='File' field='data.file' mime='.pdf' fileClassName='data.file'  :req='false'/>

        <CropImage 
            v-bind:corp="data.corp"
            v-on:update:modelValue="data.corp = $event" 
            fileClassName='data.crop'
            :width="500"
            :src="data.corp"
          >
        </CropImage>

        <div class="col-md-12">
          <div class="p-3 py-5">
            <div class="row mt-2" v-for="(item, index) in extras" :key="index">
              <div class="col-md-5">
                <input type="text" @input="validateInput()" v-model="item.name" class="form-control" placeholder="name" >
                <small class="text-danger" v-if="errors[`${index}.name`]">
                  {{errors[`${index}.name`]}}
                </small>
                
              </div>
              <div class="col-md-5">
                <input type="file" :name="'images[' + index + ']'" 
                :ref="'file'+index" class="form-control" @input="validateInput()" >
                <small class="text-danger" v-if="errors[`${index}.image`]">
                  {{ errors[`${index}.image`]}}
                </small>
              </div>
              <div class="col-md-2">
                <div class="btn btn-danger" 
                  @click.prevent="extras.splice(index, 1)" 
                  v-if="extras.length > 1">-</div>
                <div class="btn btn-success" @click="extras.push({ name: '1', image: '' })">+</div>
              </div>
            </div>
            
          </div>
        </div>
    </div>
    <Button title='Submit' process='' />
  </create-form>
</template>

<script>
import CropImage from '../../../components/Form/CropImage.vue';


// define model name
const model = 'profile';

export default {
  
  data() {
    return {
      model: model,
      data: {image:'',file:''},
      image:{},
      errors: {},
      extras: [{ name: '1', image: '' }],
    };
  },
  components: {
    CropImage
  },
  provide() {
    return {
      validate: this.validation,
      data: () => this.data, image: this.image
    };
  },

  methods: {
    submit: function (e) {
      this.$validate().then((res) => {
        const error = this.validation.countErrors();
        const iError = Object.keys(this.errors).length;
        // If there is an error
        const errCount = error + iError;
        if (errCount > 0) {
          console.log(this.validation.allErrors());
          this.$toast(
            'You need to fill ' + errCount + ' more empty mandatory fields',
            'warning'
          );
          return false;
        }

        // If there is no error
        if (res) {
          var form = document.getElementById('form'); 
          var formData = new FormData(form);
          formData.append('corp', this.data.corp);
          console.log(this.data);
          if (this.data.id) {
            this.update(this.model, formData, this.data.id,true);
          } else {
            this.store(this.model, formData);
          }
        }
      });
    },

    validateInput(){
      this.errors = {};
      // console.log(this.extras);
      this.extras.forEach((obj, ind) => {
        console.log(this.$refs['file' + ind][0].files[0]);
        

        if (!obj.name) {
          this.setError(ind, "name", "name is required");
        } else if (this.$refs['file' + ind][0].files[0] == undefined) {
          this.setError(ind, "image", "image is required");
        } 
        // else if (this.$refs['file' + ind][0].files[0] == undefined) {
        //   console.log('img hit');
        //   this.setError(ind, "image", "image is required");
        // } 
        
        
      })
      console.log('sd');
    },

    setError(index, prop, message) {
      this.errors = {
        ...this.errors,
        [`${index}.${prop}`]: message,
      };
    },
  },
  created() {
    if (this.$route.params.id) {
      this.setBreadcrumbs(this.model, 'edit');
      this.get_data(`${this.model}/${this.$route.params.id}`);
    } else {
      this.setBreadcrumbs(this.model, 'create');
    }
  },

 // validation rule for form
  validators: {
    'data.name': function (value = null) { return Validator.value(value).required('Name is required');},
		'data.email': function (value = null) { return Validator.value(value).required('Email is required').email();},
		'data.phone': function (value = null) { return Validator.value(value).digit().minLength(11).maxLength(11);},
		'data.image': function (value = null) { return Validator.value(value).custom(function () {
                if ( !value . type ) {
                    return false;
                }
                if (!Validator.isEmpty(value)) {
                var type = value.type;
                if (type == 'image/jpg'||type == 'image/jpeg'||type == 'image/webp'||type == 'image/png') {
                } else {
                    return 'Image must be of type .jpg.jpeg.webp.png';
                }
                }
            }).custom(function () {

                if (!Validator.isEmpty(value)) {
                    var size = value.size;
                    if (size > 1048576) {
                    return  "File must be smaller than 1024 kb";
                    }
                }
                });},
		'data.file': function (value = null) { return Validator.value(value).custom(function () {

                if (!Validator.isEmpty(value)) {
                    var size = value.size;
                    if (size > 2097152) {
                    return  "File must be smaller than 2048 kb";
                    }
                }
                });},

  },
}

</script>
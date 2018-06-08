<template>
<div>
	
	<div v-if="response._type == 'radio'">
		{{response.name}}
		<div v-for="opt in response.option">
			<input @change="changeInput(keys, $event)" :value="opt.oneoption" :type="response._type" :name="response._type + keys" v-model="mess[keys]"> {{opt.oneoption}}
		</div>
			<input @keyup="changeInput1(keys, $event)" type="text" :name="response._type + keys" v-model="mess[keys]">{{response.placeholder}}
	</div>
	<div v-else-if="response._type == 'text'">
    <input  @keyup="changeInput1(keys, $event)" :type="response._type" :name="response._type + keys"> {{response.name}}
  </div>
  <div v-else-if="response._type == 'file'">
		<input  :type="response._type" :name="response._type + keys" @change="processFile($event)" multiple>
    <div v-for='(file, key) in files'>{{file.name}}<span v-on:click='deleteFile(key)' style="color: red"> X </span></div>
	</div>

</div>
	
</template>

<script>

export default {
  data(){
  	return{
  		errors: 0,
      files: [],
  	}
  },
  props:[
  	'response',
  	'keys',
  	'mess',
  	],
  methods:{
  	changeInput(key, event){
  		this.$set(this.mess, key, event.target.value);
  		if(event.target.value != ''){
  			this.$emit('changeInputFields', this.mess);
  			this.errors = 1;
        let err = {
          'error': this.errors,
          'key': key
        };
        this.$emit('changeEror', err);
  		}else{
  			this.errors = 0;
        let err = {
          'error': this.errors,
          'key': key
        };
        this.$emit('changeEror', err);
  		}
  		// console.log(event)
  	},
  	changeInput1(key, event){
  		this.$set(this.mess, key, event.target.value);
  		if(event.target.value != ''){
  			this.$emit('changeInputFields', this.mess);
  			this.errors = 1;
        let err = {
          'error': this.errors,
          'key': key
        };
        this.$emit('changeEror', err);
  		}else{
  			this.errors = 0;
        let err = {
          'error': this.errors,
          'key': key
        };
        this.$emit('changeEror', err);
  		}
  	},
    processFile(event){
      console.log(event.target.files);
      for(let i in event.target.files){
         if(i !== 'item' && i !=='length'){
         this.files.push(event.target.files[i]);
         }
      }
    },
    deleteFile(key){
      this.files.splice(key, 1);
    }
  

  },
}
</script>
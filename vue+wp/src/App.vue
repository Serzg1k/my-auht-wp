<template>
  <div id="app">
    <form @submit.prevent="formSubmit">
    <template v-for="(resp, key) in response">
      <template v-if="errors[key] == 1">
        <chose-input :response="response[key]" :keys="key" :mess="message" @changeInputFields="changeInput" @changeEror="changeEror"></chose-input>
      </template>
    </template>
  {{message}}
  {{errors}}
  <input v-if="sendButton" type="submit" value="send" >
  </form>
    <router-view/>
 
  </div>
</template>

<script>
import ChoseInput from './components/ChoseInput'

export default {
  data(){
    return{
      message: {},
      response:{},
      
      errors:{
        0:1
      },
    }
  },
  components: {
    ChoseInput
  },
  methods:{
    changeInput(mes){
      this.message = mes
    },
    formSubmit(){
      console.log('submit');
    },
    changeEror(key){
      let e = Number(key.key);
      if(key.error == 1){
        this.$set(this.errors, e+1, key.error);
        
      }else{
        this.$delete(this.errors, e+1);
      }
      
    }

  },
  computed:{
    sendButton(){
      let lenghtError = 0;
      let lenghtRes = 0;
      for(let i in this.errors){
         lenghtError++;
      }
      for(let i in this.response){
        lenghtRes++;
      }
     if(lenghtError == lenghtRes){
      return true;
     }
      
    }
  },
  mounted(){
    let url = 'http://brief/wp-json/wp/v2/pages/4';
    let xhr = new XMLHttpRequest();
    xhr.open('GET', url, false);
    xhr.send();
    if (xhr.status != 200) {

      } else {
        var response = ( JSON.parse(xhr.responseText).green_uv_repet_welcome_image );
        for(let resp in response){
           this.$set(this.response, resp, response[resp]);
        }
        
      }
  }

}
</script>


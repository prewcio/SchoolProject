<template>
  <div class="container test" v-if="this.success === 1">
    <div class="exeTest">
      <div v-if="this.currentUrl === '/' + this.userName + '/exercise'">
        <h1>Exercises</h1>
        <form id="checkWord" @submit.prevent="exerciseCheck()" v-if="correct!==2">
            <h2 style="color:white">{{currentWord}}</h2>
            <input name="insWord" ref="insWord" placeholder="Enter this but in Polish">
            <h3 style="color:red" v-if="correct===-1">Nope! Correct: {{translatedWord}}</h3>
            <h3 style="color:green" v-if="correct===1">Correct!</h3>
            <input type="submit" id="submitEx" value="Check" v-if="correct===0">
            <button @click="excludeExercise(currentWord.toLowerCase())" v-if="correct!==0">Przejdź dalej</button>
        </form>
          <h3 style="color:green" v-if="correct===2">You have answered all questions correctly!</h3>
          <button v-if="correct===2" @click="backRedirect()">Go back!</button>
      </div>
      <div v-else-if="this.currentUrl === '/' + this.userName + '/test'">
        <h1>Tests</h1>
          <form id="checkTest" @submit.prevent="testCheck()" v-if="correct!==2">
            <h2 style="color:white">{{currentWord}}</h2>
            <input name="insWord" ref="insWord" placeholder="Enter this but in Polish">
            <input type="submit" id="submitTest" value="Next Word">
            <h4 style="color:white">Question: {{question}}/{{wordsPool.length}}</h4>
          </form>
          <h3 v-if="correct===2" style="color: white">Your score: {{score}}/{{wordsPool.length}} ({{scorePrec}}%) {{pass}}</h3>
      </div>
      <div v-else>
        <h1>Select Page</h1>
        <button @click="redirect('exercise')">Exercise</button>
        <button @click="redirect('test')">Test</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ExerTest",
  data: function () {
    return {
      success: 0,
      correct: 0,
      score: 0,
      scorePrec: 0,
      question: 0,
      currentUrl: "",
      userName: "",
      currentWord: "",
      pass: "no",
      translatedWord: "",
      insWord: "",
      wordsPool: [],
      transWordsPool: [],
      excludeWordsExer: [],
      csrf: document
        .querySelector('meta[name="csrf-token"]')
        .getAttribute("content"),
    };
  },
  mounted() {
    this.checkIfLogged();
    axios
        .get("/api/en/getWords")
        .then((response) => {
            this.wordsPool = response.data.words;
            this.transWordsPool = response.data.translated;
            this.exercises();
            this.test();
        })
    this.currentUrl = window.location.pathname;
  },
  methods: {
    exercises: function (){
        this.correct = 0;
        this.$refs.insWord.value="";
        this.$refs.insWord.disabled=false;
        let rand = Math.floor(Math.random()*45);
        if(!this.excludeWordsExer.includes(this.wordsPool[rand])) {
            this.currentWord = this.wordsPool[rand].charAt(0).toUpperCase() + this.wordsPool[rand].slice(1);
            this.translatedWord = this.transWordsPool[rand].charAt(0).toUpperCase() + this.transWordsPool[rand].slice(1);
        } else {
            this.exercises();
        }
    },
    exerciseCheck: function (){
        let word = this.$refs.insWord.value;
        this.$refs.insWord.disabled=true;
        if(this.translatedWord.toLowerCase()===word.toLowerCase()){
            this.correct=1;
        } else {
            this.correct=-1;
        }
    },
    excludeExercise: function (word){
        if(this.correct===1) {
            this.excludeWordsExer.push(word);
        }
        console.log(this.excludeWordsExer.length);
        console.log(this.excludeWordsExer);
        if(this.excludeWordsExer.length<this.wordsPool.length) {
            this.exercises();
        } else {
            this.correct=2;
        }
    },
      test: function (){
          this.$refs.insWord.value="";
          this.$refs.insWord.disabled=false;
          let rand = Math.floor(Math.random()*45);
          if(!this.excludeWordsExer.includes(this.wordsPool[rand])) {
              this.currentWord = this.wordsPool[rand].charAt(0).toUpperCase() + this.wordsPool[rand].slice(1);
              this.translatedWord = this.transWordsPool[rand].charAt(0).toUpperCase() + this.transWordsPool[rand].slice(1);
          } else {
              this.test();
          }
      },
      testCheck: function (){
          let word = this.$refs.insWord.value;
          this.$refs.insWord.disabled=true;
          if(this.translatedWord.toLowerCase()===word.toLowerCase()){
              this.score++;
          }
          this.excludeTest(this.currentWord.toLowerCase());
          this.question++;
      },
      excludeTest: function (word){
          this.excludeWordsExer.push(word);
          console.log(this.excludeWordsExer.length);
          console.log(this.excludeWordsExer);
          if(this.excludeWordsExer.length<this.wordsPool.length) {
              this.test();
          } else {
              this.correct=2;
              this.scorePrec=Math.floor((this.score/this.wordsPool.length)*100);
              console.log(Math.floor((this.score/this.wordsPool.length)*100));
              if(this.scorePrec>55){
                  this.pass="Passed";
              } else {
                  this.pass="Failed";
              }
          }
      },
      redirect: function (params) {
          console.log("/" + params);
          window.location.href = "/" + this.userName + "/" + params;
      },
      backRedirect: function () {
          window.location.href = "/" + this.userName;
      },
    checkIfLogged: function () {
      axios
        .post("/api/checkLogged", {
          token: this.csrf,
        })
        .then((response) => {
          console.log(response.data);
          if (response.data.success === 0) {
            window.location.href = "/login";
          } else {
            this.success = response.data.success;
            console.log(this.success);
            this.userName = response.data.username;
          }
        })
        .catch(function (error) {
          console.log(error);
        });
    },
  },
};
</script>

<template>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header">{{ title }}</div>
          <span class="badge badge-success">{{ category_name }}</span>
          <div class="card-body text-center drill-body">
            <button class="btn btn-primary" @click="doDrill" v-if="!isStarted">START</button>
            <p v-if="isCountDown" style="font-size: 100px;">{{countDownNum}}</p>
            <template v-if="isStarted && !isCountDown && !isEnd">
              <p>{{timerNum}}</p>
              <p class="problem-text">
                <span
                  v-for="(word,index) in problemWords"
                  :key="index"
                  :class="{'text-primary': index < currentWordNum}"
                >{{word}}</span>
              </p>
            </template>
            <template v-if="isEnd">
              <p>あなたのスコア</p>
              <p>{{typingScore}}</p>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import keyCodeMap from "../master/keymap";
export default {
  props: ["title", "drill", "category_name"],
  data: function() {
    return {
      countDownNum: 3,
      timerNum: 10,
      missNum: 0,
      wpm: 0,
      isStarted: false,
      isEnd: false,
      isCountDown: false,
      currentWordNum: 0, // 現在回答中の文字数目
      currentProblemNum: 0 // 現在の問題番号
    };
  },
  computed: {
    // 問題テキスト 50行目
    problemText: function() {
      return this.drill["problem" + this.currentProblemNum];
    },
    // 問題テキスト(配列形式)
    problemWords: function() {
      return Array.from(this.drill["problem" + this.currentProblemNum]);
    },
    // 問題の解答キーコード配列
    problemKeyCodes: function() {
      if (!Array.from(this.drill["problem" + this.currentProblemNum]).length) {
        return null;
      }

      let problemKeyCodes = [];
      console.log(Array.from(this.drill["problem" + this.currentProblemNum]));
      Array.from(this.drill["problem" + this.currentProblemNum]).forEach(
        text => {
          $.each(keyCodeMap, (KeyText, KeyCode) => {
            if (text === keyText) {
              problemKeyCodes.push(keyCode);
            }
          });
        }
      );

      console.log(problemKeyCodes);
      return problemKeyCodes;
    },
    //問題の文字数
    totalWordNum: function() {
      return this.problemKeyCodes.length;
    },
    // タイピングスコア
    typingScore: function() {
      return this.wpm * 2 * (1 - this.missNum / (this.wpm * 2));
    }
  },
  method: {
    doDrill: function() {
      this.isStarted = true;
      this.countDown();
    },
    countDown: function() {
      //効果音
      const countSound = new Audio("../sounds/hyoushigi1.mp3");
      const startSound = new Audio("../sounds/costume-drama1.mp3");

      this.isCountDown = true;

      this.soundPlay(countSound);

      let timer = windows.setInterVal(() => {
        this.countDownNum -= 1;

        if (this.countDownNum <= 0) {
          this.isCountDown = false;

          this.soundPlay(startSound);

          windows.clearInterval(timer);
          this.countTimer();
          this.showFirstProblem();

          return;
        }

        this.soundPlay(countSound);
      }, 1000);
    },
    showFirstProblem: function() {
      //
      //効果音読み込み
      const okSound = new Audio("../../sounds/incorrect1.mp3");
      const ngSound = new Audio("../../sounds/incorrect1.mp3");
      const nextSound = new Audio("../../sounds/incorrect1.mp3");

      // 入力イベント時に入力キーと解答をチェック 127行目
      $(window).on("keypress", e => {
        console.log(e.which);
        if (e.which === this.problemKeyCodes[this.currentWordNum]) {
          console.log("正解！");

          this.soundPlay(okSound);

          ++this.currentWordNum;
          ++this.wpm;
          console.log("現在回答の文字数目:" + this.currentWordNum);

          // 全文字正解終わったら、次の問題へ
          if (this.totalWordNum === this.currentWordNum) {
            console.log("次の問題へ");
            ++this.currentProblemNum;
            this.currentWordNum = 0;

            this.soundPlay(nextSound);
          }
        } else {
          console.log("不正解です");

          this.soundPlay(ngSound);
          ++this.missNum;

          console.log("現在回答の文字数目：" + this.currentWordNum);
        }
      });
    },
    soudPlay: function(sound) {
      sound.currentTime = 0;
      soud.play();
    },
    countTimer: function() {
      const endSound = new Audio("../../sounds/costume-drama1.mp3");
      let timer = window.setInterval(() => {
        this.timerNum -= 1;

        if (hits.timerNum <= 0) {
          this.isend = true;

          windows.clearInterVal(timer);
          endSound.play();
        }
      }, 1000);
    }
  }
};
</script>

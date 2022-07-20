<template>

<!--   TODO adaptar slider a mobile-->

   <div class="m-5 text-center">
       <h1>Nuestros objetivos son los tuyos</h1>
   </div>

    <div id="slider">
        <div class="slider">
            <ul class="slides" :style="{left:-width*current+'px'}">
                <li v-for="(slide,i) in slides">
                    <img :src="slide" alt="">
                </li>
            </ul>
            <ul class="bullets">
                <li v-for="(slide,i) in slides" @click="selectSlide(i)" v-html="i===current ? '&#9679;' : '&omicron;'"></li>
            </ul>
            <a class="prev" href="#" @click.prevent="prevSlide"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-arrow-left-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 0 0 16A8 8 0 0 0 8 0zm3.5 7.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z"/>
            </svg></a>
            <a class="next" href="#" @click.prevent="nextSlide"><svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor" class="bi bi-arrow-right-circle-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
            </svg></a>
        </div>
    </div>
</template>

<script>
export default {
name: "SliderImage",
    el: '#slider',
    data() {
        return {
            slides: [
                "/images/home/1.png",
                "/images/home/2.png",
                "/images/home/3.png",
                "/images/home/4.png",
            ],
            current: 0,
            width: 1280,
            timer: 0,
        };
    },
    methods: {
        nextSlide: function() {
            this.current++;
            if (this.current >= this.slides.length)
                this.current = 0;
            this.resetPlay();
        },
        prevSlide: function() {
            this.current--;
            if (this.current < 0)
                this.current = this.slides.length - 1;
            this.resetPlay();
        },
        selectSlide: function(i) {
            this.current = i;
            this.resetPlay();
        },
        resetPlay: function() {
            clearInterval(this.timer);
            this.play();
        },
        play: function() {
            let app = this;
            this.timer = setInterval(function() {
                app.nextSlide();
            }, 10000);
        }
    },
    created: function() {
        this.play();
    }
}
</script>

<style scoped lang="scss">

body{
    background-color:#2C3E50;
}
#slider{
    width:100%;
}

.slider {
    margin: 1vw auto;
    padding: 0;
    width: 1280px;
    height: 600px;
    position: relative;
    overflow: hidden;
    ul.slides {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
        display: table;
        position: absolute;
        top: 0;
        transition: left 800ms;
        li {
            list-style-type: none;
            display: table-cell;
            img{
                width: 1280px;
            }
        }
    }
    ul.bullets {
        width: inherit;
        position: absolute;
        bottom: 0;
        left: 0;
        padding: 0;
        margin: 0 0 10px 0;
        text-align: center;
        z-index: 1;
        li {
            list-style-type: none;
            display: inline;
            color: #fff;
            cursor: pointer;
            padding: 0 5px;
            font-size: 20px;
            font-family: sans-serif;
        }
    }
    .prev,
    .next{
        text-decoration: none;
        color: #fff;
        position: absolute;
        z-index: 1;
        font-size: 42px;
        top: 50%;
        text-shadow: 2px 2px 5px rgba(0,0,0,0.5);

    }

    .prev{
        left: 20px;
    }
    .next{
        right: 20px;
    }
    & .prev:hover,.next:hover{
        color: #08D9D6;
    }
}


</style>

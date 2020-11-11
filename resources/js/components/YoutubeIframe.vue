<template>
    <div>
        <youtube-player
            ref="p"
            id="p"
            :yturl="url"
            :width="width"
            :height="height"
            :player-vars="playerVar"
            @ready="onPlayerReady"
            @playing="onPlaying"
            @paused="onPaused"
            @cued="onCued"
            @onPlaybackRateChange="onPlaybackRateChange"
            @ended="onPlayerEnd"
            @error="onPlayerError"></youtube-player>
    </div>
</template>
<script>
    import Vue from 'vue';
    import YoutubePlayerPlugin, { Player } from 'vue-youtube-iframe-api';
    
    Vue.use(YoutubePlayerPlugin);
    export default {
        props: {
            pause: {
                type: Boolean,
                default: () => false
            },
            url: {
                type: String
            },
            height: {
                type: String,
                default: () => '300px'
            },
            width: {
                type: String,
                default: () => '100%'
            }
        },
        components: {
            YoutubePlayer: Player
        },
        computed: {
            player(){
                return this.$refs.p.player;
            }
        },
        data() {
            return {
                playerVar: {
                    controls: 0,
                    origin: window.location.origin,
                    rel: 0,
                    modestbranding: 1,
                    enablejsapi: 1
                },
                ytUrl: 'https://www.youtube.com/watch?v=2zbksa_GG9c', // 'https://www.youtube.com/watch?v=VdQY7BusJNU', 
            }
        },
        methods: {
            onPlayerReady() {
                this.$emit('ready', this.$refs.p.player);
            },
            onPlaying() {
                this.$emit('playing');
                this.player.addEventListener('timeupdate', this.timeUpdate);


            },
            onPaused() {
                this.$emit('paused');
                this.player.removeEventListener('timeupdate');
            },
            onCued(){
                this.$emit('cued');
            },
            onPlaybackRateChange(){
                console.log('Playback Rate Change');
            },
            timeUpdate(){
                console.log('time updating')
                let newTime = this.player.getCurrentTime() * (100 / this.player.getDuration());
                this.$emit('timeUpdate', newTime);
            },
            onPlayerEnd(){
                this.$emit('ended')
            },
            onPlayerError(obj) {
                console.log('There is an error loading player');
                this.$emit('error', obj);
            },            
        },
        mounted(){
            
        }
    }
</script>
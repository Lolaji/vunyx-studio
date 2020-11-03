<template>
    <div class="video-section">
        <div class="row justify-content-center">
            <!-- Video Screen -->
            <div class="video-screen col-md-10 pl-0 pr-0">
                <youtube-iframe
                    :url="url"
                    :pause="pause"
                    @ready="onPlayerReady"
                    @playing="playing"
                    @paused="paused"
                    @ended="ended"
                    @error="error"></youtube-iframe>
                    
                    <slot name="interactiveContainer"></slot>
            </div>

            <div class="col-md-10 seek-bar-container">
                <seek-bar
                    ref="seekBar"
                    class="seekbar"
                    v-model="seekBarValue"
                    :min="0.0"
                    :max="playerDuration"
                    :step="0.01"
                    @change="seekbarDragEnd"
                ></seek-bar>
            </div>

            <!-- Video controls -->
            <div class="video-control col-md-10">
                <div class="row">
                    <div class="col-md-9">
                        <div class="row control text-white">
                            <div class="col-1">
                                <button
                                    type="button"
                                    class="btn btn-link btn-play-pause"
                                    @click="playPause">
                                    <i ref="playPauseIcon" class="fa fa-play"></i>
                                </button>
                            </div>
                            <div class="col-1">
                                <div class="volume-indicator">
                                    <i ref="volumeIcon" class="fa fa-volume-down"></i>
                                </div>
                            </div>
                            <div class="col-sm-4 volume-bar-container">
                                <volume-slider
                                    ref="volumeSlider"
                                    class="player-volume"
                                    v-model="volume.value"
                                    :min="0"
                                    :max="playerVolume"
                                    @change="volumeDragEnd"
                                ></volume-slider>

                            </div>
                            <div class="col-md-4 time-text">
                                <span class="currentTime">{{timeText.current}}</span> /
                                <span class="duration">{{timeText.duration}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img
                            src="/img/logo.png"
                            class="image float-right"
                            height="40"
                            width="40" alt="Vunyx logo"/>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import datePlugin from '../plugin/Date';

    import VolumeSlider from 'vue-range-slider';
    import SeekBar from 'vue-range-slider';
    // import 'vue-range-component/dist/vue-range-slider.css';
    import YoutubeIframe from "./YoutubeIframe.vue";

    export default {
        props: {
            seekTo: {
                type: [Number, String]
            },
            url: {
                type: String
            }
        },
        components: {
            YoutubeIframe,
            SeekBar,
            VolumeSlider,
        },
        watch: {
            seekBarValue(nData, oData){
                this.seekToTime = nData;
            },
            seekTo(nData, oData){
                let newTime = parseInt(nData);
                this.playerInstance.seekTo(nData);
                this.timeText.current = datePlugin.spanTime(newTime).rand;
                this.seekBarValue = newTime;
            }
        },
        data(){
            return {
                volume: {
                    value: 50
                },

                seekBarTimeInterval: null,
                seekToTime: 0,
                seekBarValue: 0,
                stopSeeking: false,
                pause: false,
                playerInstance:{},
                playerDuration: 0,
                playerVolume: 100,

                timeText: {
                    duration: '00:00',
                    current: '00:00'
                },

            }
        },
        methods: {
            onPlayerReady(player) {
                this.playerInstance = player;
                this.$emit('ready', player);
            },
            playPause() {
                let playPauseIconClass = this.$refs.playPauseIcon.classList;

                switch (this.playerInstance.getPlayerState()) {
                    case 1: 
                        this.playerInstance.pauseVideo();
                        playPauseIconClass.remove('fa-pause');
                        playPauseIconClass.add('fa-play');
                        break;
                    case 0:
                    case 2:
                    case 5:
                        this.playerInstance.playVideo();
                        playPauseIconClass.remove('fa-play');
                        playPauseIconClass.add('fa-pause');
                        break;
                }
            },
            playing(){// Triggers when the the video is played by clicking the video screen
                this.playerDuration = this.playerInstance.getDuration();
                this.seekBarValue = this.playerInstance.getCurrentTime();
                this.timeText.duration = datePlugin.spanTime(this.playerInstance.getDuration()).rand;
                
                let playPauseIconClass = this.$refs.playPauseIcon.classList;
                
                playPauseIconClass.remove('fa-play');
                playPauseIconClass.add('fa-pause');

                // Changing the volume icon
                this.changeVolumeIcon();

                this.updateSeekBarTime(true);

                this.$emit('playing', this.playerInstance);
            },
            paused(){// Triggers when the the video is played by clicking the video screen
                let playPauseIconClass = this.$refs.playPauseIcon.classList;
                playPauseIconClass.remove('fa-pause');
                playPauseIconClass.add('fa-play');
                this.updateSeekBarTime(false);
                this.$emit('paused', this.playerInstance);
            },
            updateSeekBarTime(update=false){
                if (update){
                    this.seekBarTimeInterval = setInterval( () => {
                        let curTime = datePlugin.spanTime(this.playerInstance.getCurrentTime())
                        if (!this.stopSeeking) {
                            this.seekBarValue = this.playerInstance.getCurrentTime();
                        }
                        this.timeText.current = curTime.rand;
                        this.$emit( 'get-current-time', curTime.text);
                    }, 0.1);
                } else {
                    clearInterval(this.seekBarTimeInterval);
                }
            },
            async seekbarDragEnd(value){
                this.seekBarValue = value;
                this.stopSeeking = true;
                clearInterval(this.seekBarTimeInterval);
                this.$emit('time-change', value);
                await this.playerInstance.seekTo(value);

                await this.updateSeekBarTime(true);
                this.stopSeeking = false;
            },
            volumeDragEnd(){
                this.changeVolumeIcon()
            },

            seekBarOnDrag(){
                $('.range-slider.seekbar .range-slider-knob').mousedown(() => {
                    this.stopSeeking = true;
                }).mouseup(() => {
                    this.stopSeeking = false;
                });
            },
            ended() {
                clearInterval(this.seekBarTimeInterval);
                let playPauseIconClass = this.$refs.playPauseIcon.classList;
                playPauseIconClass.remove('fa-pause');
                playPauseIconClass.add('fa-play');
            },

            changeVolumeIcon(){
                let volumeIcon = this.$refs.volumeIcon.classList;
                this.playerInstance.setVolume(this.volume.value);

                if (this.volume.value > 70) {
                    volumeIcon.remove('fa-volume-down') 
                    volumeIcon.remove('fa-volume-off');
                    volumeIcon.add('fa-volume-up');
                } else if ((this.volume.value <= 70) && (this.volume.value != 0) ) {
                    volumeIcon.remove('fa-volume-up'); 
                    volumeIcon.remove('fa-volume-off');
                    volumeIcon.add('fa-volume-down');
                } else {
                    volumeIcon.remove('fa-volume-up') 
                    volumeIcon.remove('fa-volume-down');
                    volumeIcon.add('fa-volume-off');
                }
            },
            
            error() {

            }
        },
        mounted(){
            this.seekBarOnDrag();
        }
    };
</script>

<style lang="scss">
    .seek-bar-container {
        padding: 0;
        margin-left: -10px;
        margin-right: -10px;
        margin-top: -19px;
        width: 100%;
        height: 0;
        // background: #2a2929;

        z-index: 999;
    }
    .volume-indicator {
        color: #e1c238;
        padding-left: 8px;
        padding-top: 8px;
    }
    .btn-play-pause {
        color: #e1c238;
        &:hover {
            color: #e1c238;
        }
    }
    .volume-bar-container {
        padding-top: 10px;
    }
    .time-text{
        padding-top: 10px;
        font-size: 13px;
        font-weight: 600;
    }
</style>

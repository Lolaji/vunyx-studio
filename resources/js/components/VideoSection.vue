<template>
    <div class="video-section">
        <div class="row justify-content-center">
            <!-- Video Screen -->
            <div class="video-screen col-md-9 pl-0 pr-0">
                <youtube-iframe></youtube-iframe>
            </div>

            <div class="col-md-9 seek-bar-container">
                <seek-bar
                    ref="seekBar"
                    v-model="seekBar.value"
                    :height="2"
                    :dot-size="10"
                    :tooltip="false"
                    :bg-style="seekBar.bgStyle"
                    :slider-style="seekBar.sliderStyle"
                    :process-style="seekBar.processStyle"
                ></seek-bar>
            </div>

            <!-- Video controls -->
            <div class="video-control col-md-9">
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
                                    <i class="fa fa-volume-up"></i>
                                </div>
                            </div>
                            <div class="col-sm-4 volume-bar-container">
                                <volume-slider
                                    ref="volumeSlider"
                                    v-model="volume"
                                    :height="4"
                                    :dot-size="10"
                                    :tooltip="false"
                                    :bg-style="bgStyle"
                                    :slider-style="sliderStyle"
                                    :process-style="processStyle"
                                ></volume-slider>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <img
                            src="img/logo.png"
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

    import 'vue-range-component/dist/vue-range-slider.css';
    import VolumeSlider from 'vue-range-component';
    import SeekBar from 'vue-range-component';
    import YoutubeIframe from "./YoutubeIframe.vue";

    export default {
        components: {
            YoutubeIframe,
            SeekBar,
            VolumeSlider,
        },
        data(){
            return {
                volume: 60,
                seekBar: {
                    value: 70,
                    bgStyle: {
                        backgroundColor: '#f9e691',//'#2a2929',
                        boxShadow: 'inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)'
                    },
                    processStyle: {
                        backgroundColor: '#e1c238',
                    },
                    sliderStyle: {
                        backgroundColor: '#e1c238',
                    }
                },
                bgStyle: {
                    // backgroundColor: '#e1c238',
                    boxShadow: 'inset 0.5px 0.5px 3px 1px rgba(0,0,0,.36)'
                },
                processStyle: {
                    backgroundColor: '#e1c238',
                },
                sliderStyle: {
                    backgroundColor: '#e1c238',
                }
            }
        },
        methods: {
            playPause() {
                console.log(this.$refs.playPauseIcon);
            }
        }
    };
</script>

<style lang="scss">
    .seek-bar-container {
        padding: 0;
        margin-top: -6px;
        width: 100%;
        height: 0px;
        background: #2a2929;
    }
    .volume-indicator {
        color: #e1c238;
        padding-left: 8px;
        padding-top: 7px;
    }
    .btn-play-pause {
        color: #e1c238;
        &:hover {
            color: #e1c238;
        }
    }
    .volume-bar-container {
        padding-top: 13px;
    }
</style>

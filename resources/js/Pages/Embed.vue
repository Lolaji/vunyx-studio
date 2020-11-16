<template>
    <div 
        class="embed-container col-12" 
        >
        <video-section
            :url="project.video.url"
            :height="embedContainerStyle.height"
            :seek-to="video.seekTo"
            @ready="playerReady"
            @get-current-time="getVideoCurrentTime"
            @playing="videoPlaying"
            @paused="videoPaused"
            @time-change="VideoTimeChange">
                <template #interactiveContainer>
                    <div ref="iElement" v-for="(ie, key) in interactiveElementData" :key="key">
                        <i-element
                            :type="ie.type"
                            :action="ie.action"
                            :href="ie.href"
                            :link-time="ie.linkTime"
                            :styles="ie.style"
                            :from="ie.time.from"
                            :to="ie.time.to"
                            :animate-classes="ie.animateClasses"
                            :video-current-time="video.currentTimeInSeconds"
                            :is-video-playing="video.playing"
                            :on-edit="ie.onEdit"
                            @on-link-time="elementClick">
                            <template v-if="ie.type=='text'">
                                <div v-html="ie.text"></div>
                            </template>
                            <template v-else>{{ie.text}}</template>
                        </i-element>
                    </div>
                </template>
        </video-section>
    </div>
</template>

<script>
import datePlugin from '../plugin/Date';

import VideoSection from '../components/VideoSec';
import IElement from '../components/interactive-elements/IElement';
export default {
    props: ['project', 'height', 'width'],
    components: {
        VideoSection,
        IElement
    },
    data(){
        return {
            video: {
                instance: null,
                playing: false,
                currentTime: null,
                seekTo: '',
                duration: 0,
                currentTimeInSeconds: null
            },
            interactiveElementData: [],
            embedContainerStyle: {
                height: '',
                width: ''
            }
        }
    },
    methods: {
        /**
         * Interactive Element Methods
         */
        elementClick(data){
            let sec = datePlugin.spanTimeToSeconds(data);
            this.video.seekTo = sec;
            this.video.instance.seekTo(sec);
        },

        getVideoCurrentTime(time){
            if (this.video.instance.getPlayerState() == 1) {
                this.video.currentTime = time;
                this.video.currentTimeInSeconds = this.video.instance.getCurrentTime();
            }
        },
        playerReady(player) {
            this.video.instance = player;
        },
        videoPlaying(player) {
            this.video.playing = true;
            this.video.duration = player.getDuration();
        },
        videoPaused(player){
            this.video.playing = false;
        },
        VideoTimeChange(currentTime) {// video section component method, call when video seekbar is dragged
            // update timeline from
            
        },
    },
    beforeCreate() {
        $('body')
            .removeClass('sidebar-mini')
            .removeClass('layout-fixed');
            // .addClass('login-page');
    },
    updated(){
        console.log(window.innerHeight);
    },
    created(){
        $('title').html(`${this.project.title} | Vunyx`);

        this.embedContainerStyle.height = (! _.isNull(this.height)?this.height : (window.innerHeight-42)+'px');
        this.embedContainerStyle.width = (! _.isNull(this.height)?this.width : (window.innerWidth)+'px');

        this.$nextTick(()=> {
            window.onresize = () => {
                console.log('Height changed to: '+window.innerHeight);
                this.embedContainerStyle.height = (! _.isNull(this.height)?this.height : (window.innerHeight-42)+'px');
                this.embedContainerStyle.width = (! _.isNull(this.height)?this.width : (window.innerWidth)+'px');
            }
        });

        Object.entries(this.project.elements).forEach(([index, value]) => {
            this.interactiveElementData.push({
                id: value.id,
                type: value.type,
                title: value.title,
                text: value.text,
                action: value.action,
                href: value.href,
                linkTime: value.link_time,
                // onEdit: false,
                // canSave: false,
                // editContainer: this.isElementHasContainer(value.type),
                style: JSON.parse(value.style),
                time: {
                    from: value.from_time,
                    to: value.to_time
                },
                animateClasses: {
                    enter: value.enter_animate_class,
                    leave: value.leave_animate_class
                }
            });
        });
    }
}
</script>

<style lang="scss" scoped>
.embed-container {
    // width: 100%;
    padding: 0;
    margin: 0;
    background: #444444;
}
</style>
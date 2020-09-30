<template>
    <studio-layout>
        <!-- Main Sidebar Container -->
        <template #leftSideBar>
            <interactive-sidebar
                @create="createInteractiveElement"></interactive-sidebar>
        </template>
        
        <template #mcontent>
            <section class="content no-mp">
                <div class="col-md-12">
                    <div class="row">

                        <div class="interactive-container col-md-8">

                            <!-- Interactive Editing Video Section -->
                            <div class="interactive-main col-md-12">
                                <video-section
                                    @ready="playerReady"
                                    @get-current-time="getVideoCurrentTime"
                                    @playing="videoPlaying">
                                        <template #interactiveContainer>
                                            <!-- <a 
                                                :href="interactiveElementData.buyNow.href"
                                                class="btn interactive-element" 
                                                :style="interactiveElementData.buyNow.style">{{interactiveElementData.buyNow.title}}</a> -->

                                                <div ref="iElement" v-for="(ie, key) in interactiveElementData" :key="key">
                                                    <!-- <link-button v-if="ie.type == 'button'"
                                                        :href="ie.href"                                                    
                                                        :style="ie.style"
                                                        :title="ie.title"></link-button> -->

                                                    <i-element
                                                        :type="ie.type"
                                                        :href="ie.href"
                                                        :styles="ie.style">{{ie.text}}</i-element>
                                                </div>
                                        </template>
                                </video-section>

                                <!-- Interactive Data Section -->
                                <div class="row">
                                    <div class="interactive-data-section col-md-12">
                                        <!-- Interactive Timeline Ruler -->
                                        <div class="row mb-3">
                                            <div class="col-md-3">&nbsp;</div>
                                            <div class="col-md-6 pl-0 pr-0">
                                                <!-- <div class="row">
                                                    <div class="interactive-timeline ruler">
                                                        <div class="slider" style="margin-left: 1%"></div>

                                                        <span class="tick" v-for="i in 99" :key="i" :style="'margin-left:'+i+'%'"></span>
                                                    </div>
                                                </div> -->
                                                <ion-slider
                                                    skin="square"
                                                    :grid="true"
                                                    :min="0"
                                                    :max="video.duration"
                                                    :step="0.01"
                                                    :from="0"
                                                    :prettify-enabled="true"
                                                    :prettify="prettify"
                                                    @ready="timelineReady"></ion-slider>
                                            </div>
                                            <div class="col-md-3">&nbsp;</div>
                                        </div>

                                        <!-- Interactive Timeline data position -->
                                        <div class="row interactive-layer-container">

                                            <div class="col-md-12">
                                                
                                                <div 
                                                    class="row layer mb-0 pb-0" 
                                                    v-for="(e, index) in interactiveElementData" 
                                                    :key="index" 
                                                    :class="{active: (index == layerIndex)}">
                                                        <!-- <div class="row"> -->
                                                            <div class="col-md-3">
                                                                <div class="layer-btn">
                                                                    <button 
                                                                        @click="editIE(index)"
                                                                        class="btn btn-xs btn-primary"><i class="fa fa-pencil-alt"></i></button>
                                                                    <!-- <button 
                                                                        @click="showHide(index)"
                                                                        class="btn btn-xs btn-primary"><i class="fa fa-pencil-alt"></i></button> -->
                                                                    <button 
                                                                        @click="removeLayer(index)"
                                                                        class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button>
                                                                </div>
                                                                <div class="layer-name pt-1 pl-1">
                                                                    <span class="icon"><i class="fa fa-link"></i></span>
                                                                    <span class="title">{{e.title}}</span>
                                                                    <!-- <span class="icon"><i class="fa fa-angle-down"></i></span> -->
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 pt-2">
                                                                <div class="row">
                                                                    <div class="interactive-timeline interactive-position">
                                                                        <span class="time-position" style="margin-left: 50%;"></span>
                                                                    </div>
                                                                </div>                          
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="time-input">
                                                                    <div class="row pt-2">
                                                                        <input type="text" v-model="e.time.from" class="col form-control form-control-sm mx-1" placeholder="00:00:00.00">
                                                                        <input type="text" v-model="e.time.to" class="col form-control form-control-sm mx-1" placeholder="00:00:00.00">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <!-- </div> -->
                                                </div>
                                            
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>

                        <!-- Right sidebar -->
                        <div class="interactive-container col-md-4">
                            <div class="interactive-editor">
                                <div class="ie-header">
                                    <nav class="nav">
                                        <a 
                                            class="nav-link active" 
                                            id="interactive-tab" 
                                            href="#interactive-panel" 
                                            data-toggle="tab" 
                                            aria-controls="interactive-panel"
                                            role="tab"
                                            aria-selected="true">Interactive</a>

                                        <a 
                                            class="nav-link" 
                                            id="design-tab" 
                                            href="#design-panel"
                                            role="tab"
                                            data-toggle="tab"
                                            aria-controls="design-panel"
                                            aria-selected="false">Design</a>
                                    </nav>
                                </div>
                                <div class="ie-body">

                                    <div class="tab-content" v-if="layerIndex != null">

                                        <div class="tab-panel pt-2 fade show active px-3" id="interactive-panel" role="tabpanel" aria-labelledby="interactive-tab">
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="">Title</label>
                                                    <div class="col-8">
                                                        <input type="text" v-model="interactiveElementData[layerIndex].title" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="">Text</label>
                                                    <div class="col-8">
                                                        <input type="text" v-model="interactiveElementData[layerIndex].text" class="form-control">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="">Action</label>
                                                    <div class="col-8">
                                                        <select v-model="interactiveElementData[layerIndex].action" class="form-control">
                                                            <option value="1">Link to external webpage</option>
                                                            <option value="2">Link to specific time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" v-if="interactiveElementData[layerIndex].action == 1">
                                                <div class="row">
                                                    <label class="label col-3" for="">Hypertext</label>
                                                    <div class="col-8">
                                                        <input type="url" v-model="interactiveElementData[layerIndex].href" class="form-control" placeholder="https://vunyx.com">
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-else>
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="label col-3" for="">From</label>
                                                        <div class="col-8">
                                                            <input type="url" v-model="interactiveElementData[layerIndex].time.from" class="form-control" placeholder="https://vunyx.com">  
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="label col-3" for="">To</label>
                                                        <div class="col-8">
                                                            <input type="url" v-model="interactiveElementData[layerIndex].time.to" class="form-control" placeholder="https://vunyx.com">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="form-group">
                                                <div class="icheck-light-yellow d-inline">
                                                    <input type="radio" id="checkboxPrimary3">
                                                    <label for="checkboxPrimary3">Primary checkbox</label>
                                                </div>
                                            </div> -->

                                        
                                        </div>

                                        <div class="tab-panel fade" id="design-panel" role="tabpanel" aria-describedby="design-tab">
                                            <ul class="list-group">
                                                
                                                <div>
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#position">
                                                        Position
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse show" id="position">

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="label col-1 pt-1" for="">X</label>
                                                                <div class="col-8">
                                                                    <div class="input-group ie">
                                                                        <input type="text" v-model="ieStyle.left" class="form-control col-4">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text vx-text-color">{{measurement.percent}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="label col-1 pt-1" for="">Y</label>
                                                                <div class="col-8">
                                                                    <div class="input-group ie">
                                                                        <input type="text" v-model="ieStyle.top" class="form-control col-4">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text vx-text-color">{{measurement.percent}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div>
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#background">
                                                        Text &amp; Background
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse" id="background">
                                                        <text-color-picker
                                                            id="textColor"
                                                            class="py-1"
                                                            :model="ieStyle.color"
                                                            @change="value => {ieStyle.color = value}">
                                                                <template #label>Text Color</template>
                                                        </text-color-picker>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label for="" class="col-4 label">Size</label>
                                                                <div class="col-8">
                                                                    <div class="input-group ie">
                                                                        <input type="text" v-model="ieStyle.fontSize" class="form-control col-4">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text vx-text-color">px</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label for="" class="col-4 label">Weight</label>
                                                                <div class="col-8">
                                                                    <div class="input-group ie">
                                                                        <select v-model="ieStyle.fontWeight" class="form-control col-6">
                                                                            <option value="100">100</option>
                                                                            <option value="200">200</option>
                                                                            <option value="300">300</option>
                                                                            <option value="400">400</option>
                                                                            <option value="500">500</option>
                                                                            <option value="600">600</option>
                                                                            <option value="700">700</option>
                                                                            <option value="800">800</option>
                                                                            <option value="900">900</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <bg-color-picker
                                                            id="bgColor"
                                                            class=""
                                                            :model="ieStyle.backgroundColor"
                                                            @change="value => { ieStyle.backgroundColor = value}">
                                                                <template #label>Background</template>
                                                        </bg-color-picker>
                                                    </div>
                                                </div>

                                                <div>
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#border">
                                                        Border
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse" id="border">

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label class="label col-4 pt-1" for="">Radius</label>
                                                                <div class="col-8">
                                                                    <div class="input-group ie">
                                                                        <input type="text" v-model="ieStyle.borderRadius" class="form-control col-4">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text vx-text-color">{{measurement.percent}}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="form-group">
                                                            <div class="row">
                                                                <label for="" class="col-4 label">Width</label>
                                                                <div class="col-8">
                                                                    <div class="input-group ie">
                                                                        <input type="text" v-model="ieStyle.borderWidth" class="form-control col-4">
                                                                        <div class="input-group-append">
                                                                            <span class="input-group-text vx-text-color">px</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <text-color-picker
                                                            id="borderColor"
                                                            class=""
                                                            :model="ieStyle.borderColor"
                                                            @change="value => {ieStyle.borderColor = value}">
                                                                <template #label>Color</template>
                                                        </text-color-picker>

                                                        <!-- Border Style -->
                                                        <div class="form-group my-2">
                                                            <div class="row">
                                                                <label for="" class="col-4 label">Style</label>
                                                                <div class="col-8">
                                                                    <div class="input-group ie">
                                                                        <select v-model="ieStyle.borderStyle" class="form-control col-6">
                                                                            <option value="">None</option>
                                                                            <option value="solid">Solid</option>
                                                                            <option value="dotted">Dotted</option>
                                                                            <option value="double">Double</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <!--/ Border Style -->

                                                    </div>
                                                </div>
                                                
                                            </ul>
                                        </div>

                                    </div>

                                    <div class="ie-message-contaner text-center" v-else>
                                        <span> Select Interactive Layer to Edit </span>
                                    </div>
                                </div>
                                <div class="ie-footer">
                                    <div class="col-md-12">
                                        <div class="row justify-content-between">
                                            <button class="btn btn-sm btn-link text-danger">Cancel</button>
                                            <button class="btn btn-sm btn-link text-white">Save</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </template>
    </studio-layout>
</template>

<script>
    
    import datePlugin from '../../plugin/Date';

    import StudioLayout from '../../Layouts/StudioLayout';
    import InteractiveSidebar from '../../components/InteractiveSidebar';

    import IonSlider from '../../components/IonRangeSlider';
    
    import VideoSection from '../../components/VideoSec';
    import IElement from '../../components/interactive-elements/IElement';
    import TextColorPicker from '../../components/ColorPicker';
    import BgColorPicker from '../../components/ColorPicker';

    import 'vue-range-component/dist/vue-range-slider.css';
    import VPositionSlider from 'vue-range-component';
    import HPositionSlider from 'vue-range-component';

    // import LinkButton from '../../components/interactive-elements/LinkButton';
    // const LinkButtonClass = Vue.extend(LinkButton);

    export default {
        props:['page_title'],
        components: {
            StudioLayout,
            InteractiveSidebar,
            IonSlider,
            VideoSection,
            IElement,
            TextColorPicker,
            BgColorPicker,
            VPositionSlider,
            HPositionSlider
        },
        data() {
            return {
                layerIndex: null,
                video: {
                    instance: null,
                    currentTime: '',
                    duration: 0
                },
                measurement: {
                    px: 'px',
                    percent: '%'
                },
                ieStyle: {
                    top: '20',
                    left: '30',
                    color: '#444',

                    borderWidth: '1',
                    borderColor: '#23f6f6',
                    borderStyle: 'solid',
                    borderRadius: '0',

                    fontSize: '',
                    fontWeight: '',

                    backgroundColor: '#23f6f6',
                },
                //Interactive element Styles
                interactiveElementData: [
                    {
                        type: 'link',
                        title: 'Buy Now Link',
                        text: 'Buy Now',
                        action: 1,
                        href: '#',
                        style: {
                            top: '20%',
                            left: '30%',
                            color: '#444',

                            fontSize: '15px',
                            fontWeight: '500',

                            borderWidth: '1px',
                            borderColor: '#23f6f6',
                            borderStyle: 'solid',
                            borderRadius: '0',

                            backgroundColor: '#23f6f6',
                        },
                        time: {
                            from: '00:00:30.00',
                            to: '00:01:30.00'
                        }
                    },
                    {
                        type: 'link',
                        title: 'Back Link',
                        text: 'Go Back',
                        action: 1,
                        href: '#',
                        style: {
                            top: '40%',
                            left: '2%',
                            color: '#fff',

                            fontSize: '15px',
                            fontWeight: '500',
                            
                            borderWidth: '',
                            borderColor: '',
                            borderStyle: '',
                            borderRadius: '40%',

                            backgroundColor: '#444',

                        },
                        time: {
                            from: '00:00:30.00',
                            to: '00:02:30.00'
                        }
                    }
                ],

                //timeline
                timelineInstance: null,
            }
        },
        watch: {
            ieStyle: {
                handler(nData, oData){
                    if ( ! _.isNull(this.layerIndex) ) {

                        let selectedIEStyle = this.interactiveElementData[this.layerIndex].style,
                            px = this.measurement.px,
                            percent = this.measurement.percent;

                        Object.entries(selectedIEStyle).forEach(([index, value]) => {

                            switch(index){
                                case 'left':
                                case 'top':
                                case 'borderRadius':
                                    selectedIEStyle[index] = nData[index]+percent;
                                    break;
                                case 'borderWidth':
                                case 'fontSize':
                                    selectedIEStyle[index] = nData[index]+px;
                                    break;
                                default:
                                    selectedIEStyle[index] = nData[index];
                                    break;
                            }

                        });
                    }
                },
                deep: true
            }
        },
        methods: {
            createInteractiveElement (elemType) {
                //pause the video if playing
                if (this.video.instance.getPlayerState() == 1)
                    this.video.instance.pauseVideo();
                
                switch(elemType){
                    case 'link':
                        this.interactiveElementData.push({
                            type: 'link',
                            title: 'Buy Now Link',
                            text: 'Buy Now',
                            action: 1,
                            href: '#',
                            style: {
                                top: '2%',
                                left: '2%',
                                color: 'red',

                                fontSize: '15px',
                                fontWeight: '500',
                                
                                borderWidth: '1px',
                                borderColor: '#23f6f6',
                                borderStyle: 'solid',
                                borderRadius: '0',

                                backgroundColor: 'transparent'
                            },
                            time: {
                                from: (!_.isEmpty (this.video.currentTime))? this.video.currentTime : '00:00:00.00',
                                to: (!_.isEmpty (this.video.currentTime))? this.video.currentTime : '00:00:00.00'
                            }
                        })
                        break;
                    case 'hotsport':
                        
                        break;
                }
            },
            editIE (index) {
                // Get the index of this.interactiveElementData
                this.layerIndex = index;
                // Populate the this.ieStyle data property
                Object.entries(this.interactiveElementData[index].style).forEach(([index, value]) => {
                    this.ieStyle[index] = value.replace(/(px|\%)?$/, '');
                });
            },
            removeLayer(index) {
                this.layerIndex = null;
                this.interactiveElementData.splice(index, 1);
            },
            insertElement() {
                let instance = new LinkButtonClass({
                    propsData: {
                        title: this.interactiveElementData.buyNow.title,
                        styles: this.interactiveElementData.buyNow.style,
                        href: this.interactiveElementData.buyNow.href
                    }
                });

                instance.$mount();

                this.$refs.iElement.appendChild(instance.$el);

            },
            isLayerExist(index) {
                // return this.interactiveElementData
            },
            getVideoCurrentTime(time){
                this.video.currentTime = time;
                //update timeline slider
                this.timelineInstance.update({
                    from: this.video.instance.getCurrentTime(),
                });
            },
            playerReady(player) {
                this.video.instance = player
            },
            videoPlaying(player) {
                this.video.duration = player.getDuration();
                
                //update timeline slider
                this.timelineInstance.update({
                    max: player.getDuration(),
                });
            },

            // timeline
            timelineReady(instance) {
                this.timelineInstance = instance;
            },
            prettify (sec) {
                let time = datePlugin.spanTime(sec);
                return time.text;
            }
        },
        mounted() {
            
        }
    }
</script>
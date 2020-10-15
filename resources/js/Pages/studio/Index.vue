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
                                    :seek-to="video.seekTo"
                                    @ready="playerReady"
                                    @get-current-time="getVideoCurrentTime"
                                    @playing="videoPlaying"
                                    @time-change="VideoTimeChange">
                                        <template #interactiveContainer>
                                            <div ref="iElement" v-for="(ie, key) in interactiveElementData" :key="key">
                                                <i-element
                                                    :type="ie.type"
                                                    :href="ie.href"
                                                    :styles="ie.style">
                                                    <template v-if="ie.type=='text'">
                                                        <div v-html="ie.text"></div>
                                                    </template>
                                                    <template v-else>{{ie.text}}</template>
                                                </i-element>
                                            </div>
                                        </template>
                                </video-section>

                                <!-- Interactive Data Section -->
                                <div class="row">
                                    <div class="interactive-data-section col-md-12">
                                        <!-- Interactive Timeline Ruler -->
                                        <div class="row mb-3">
                                            <div class="col-md-2">&nbsp;</div>
                                            <div class="col-md-8 ie-timeline-container">
                                                <!-- <div class="row">
                                                    <div class="interactive-timeline ruler">
                                                        <div class="slider" style="margin-left: 1%"></div>

                                                        <span class="tick" v-for="i in 99" :key="i" :style="'margin-left:'+i+'%'"></span>
                                                    </div>
                                                </div> -->
                                                <timeline
                                                    extra-classes="vx-timeline"
                                                    skin="square"
                                                    :grid="true"
                                                    :min="0"
                                                    :max="video.duration"
                                                    :step="0.01"
                                                    :from="0"
                                                    :prettify-enabled="true"
                                                    :prettify="prettify"
                                                    @ready="timelineReady"
                                                    @finish="timelineDrag"></timeline>
                                            </div>
                                            <div class="col-md-2">&nbsp;</div>
                                        </div>

                                        <!-- Interactive Layer -->
                                        <div class="row interactive-layer-container">

                                            <div class="col-md-12">
                                                
                                                <interactive-layer
                                                    v-for="(e, index) in interactiveElementData" 
                                                    :key="index"
                                                    :index="index"
                                                    :classes="{active: (index == layerIndex)}"
                                                    :data="e"
                                                    :duration="video.duration"
                                                    @edit="editLayer"
                                                    @clone="cloneLayer"
                                                    @remove="removeLayer"
                                                    @input-update="layerInputUpdate"></interactive-layer>
                                            
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
                                            aria-selected="true">Interaction</a>

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
                                                    <div class="col-12 text-editor-container" v-if="interactiveElementData[layerIndex].type == 'text'">
                                                        <text-editor
                                                            v-model="interactiveElementData[layerIndex].text"
                                                            ></text-editor>
                                                    </div>
                                                    <div class="col-8" v-else>
                                                        <input 
                                                            type="text" v-model="interactiveElementData[layerIndex].text" class="form-control">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="">Action</label>
                                                    <div class="col-8">
                                                        <select v-model="interactiveElementData[layerIndex].action" class="form-control">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="1">Link to external webpage</option>
                                                            <option value="2">Link to specific time</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group" v-if="interactiveElementData[layerIndex].action == 1">
                                                <div class="row">
                                                    <label class="label col-3" for="">Web Link</label>
                                                    <div class="col-8">
                                                        <input type="url" v-model="interactiveElementData[layerIndex].href" class="form-control" placeholder="https://vunyx.com">
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-else-if="interactiveElementData[layerIndex].action == 2">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="label col-3" for="">Link time</label>
                                                        <div class="col-8">
                                                            <input type="text" v-model="interactiveElementData[layerIndex].linkTime" class="form-control" placeholder="HH:MM:SS.MS">  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="tab-panel fade" id="design-panel" role="tabpanel" aria-describedby="design-tab">
                                            <ul class="list-group">
                                                <!-- Position -->
                                                <div>
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#position">
                                                        Position
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse show" id="position">

                                                        <x-position-slider
                                                            :from="ieStyle.left"
                                                            :selected-layer-index="layerIndex"
                                                            @change="(from) => ieStyle.left = from">
                                                                <template #label>
                                                                    <i class="fa fa-arrows-alt-h"></i>
                                                                </template>
                                                            </x-position-slider>

                                                        <y-position-slider
                                                            :from="ieStyle.top"
                                                            :selected-layer-index="layerIndex"
                                                            @change="(from) => ieStyle.top = from">
                                                                <template #label>
                                                                    <i class="fa fa-arrows-alt-v"></i>
                                                                </template>
                                                            </y-position-slider>

                                                        <!-- <div class="form-group">
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
                                                        </div> -->
                                                    </div>
                                                </div>

                                                <!-- Text & Background -->
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
                                                                        <input type="number" v-model="ieStyle.fontSize" class="form-control col-4">
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
                                                            :use-transparent="true"
                                                            :model="ieStyle.backgroundColor"
                                                            @change="value => { ieStyle.backgroundColor = value}">
                                                                <template #label>Background</template>
                                                        </bg-color-picker>
                                                    </div>
                                                </div>

                                                <!-- Border -->
                                                <div>
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#border">
                                                        Border
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse" id="border">

                                                        <border-radius-slider
                                                            :from="ieStyle.borderRadius"
                                                            :selected-layer-index="layerIndex"
                                                            @change="(from) => ieStyle.borderRadius = from">
                                                                <template #label>
                                                                    Curve
                                                                </template>
                                                            </border-radius-slider>

                                                        <!-- <div class="form-group">
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
                                                        </div> -->

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

                                                <!-- Border -->
                                                <div v-if="interactiveElementData[layerIndex].editContainer">
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#cca">
                                                        Container
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse" id="cca">

                                                        <height-slider
                                                            :from="ieStyle.height"
                                                            :selected-layer-index="layerIndex"
                                                            @change="(from) => ieStyle.height = from">
                                                                <template #label>
                                                                    Height
                                                                </template>
                                                        </height-slider>

                                                        <width-slider
                                                            :from="ieStyle.width"
                                                            :selected-layer-index="layerIndex"
                                                            @change="(from) => ieStyle.width = from">
                                                                <template #label>
                                                                    Width
                                                                </template>
                                                        </width-slider>


                                                        <!-- <div class="form-group">
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
                                                        </div> -->

                                                        <!-- Border Style -->
                                                        <!-- <div class="form-group my-2">
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
                                                        </div> -->
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

    import Timeline from '../../components/IonRangeSlider';
    
    import VideoSection from '../../components/VideoSec';
    import IElement from '../../components/interactive-elements/IElement';
    import InteractiveLayer from '../../components/InteractiveLayer';
    import TextColorPicker from '../../components/ColorPicker';
    import BgColorPicker from '../../components/ColorPicker';

    import YDApi from '../../plugin/youtube-data-api/index';

    import TextEditor from '../../components/CkEditor';
    import HeightSlider from '../../components/form/IeRangeSlider';
    import WidthSlider from '../../components/form/IeRangeSlider';
    import XPositionSlider from '../../components/form/IeRangeSlider';
    import YPositionSlider from '../../components/form/IeRangeSlider';
    import BorderRadiusSlider from '../../components/form/IeRangeSlider';

    // import LinkButton from '../../components/interactive-elements/LinkButton';
    // const LinkButtonClass = Vue.extend(LinkButton);

    export default {
        props:['page_title'],
        components: {
            StudioLayout,
            InteractiveSidebar,
            Timeline,
            VideoSection,
            IElement,
            InteractiveLayer,
            TextColorPicker,
            TextEditor,
            BgColorPicker,
            HeightSlider,
            WidthSlider,
            XPositionSlider,
            YPositionSlider,
            BorderRadiusSlider
        },
        data() {
            return {
                layerIndex: null,
                stopTimelineUpdate: false,
                video: {
                    instance: null,
                    currentTime: '',
                    seekTo: '',
                    duration: 0
                },
                measurement: {
                    px: 'px',
                    percent: '%'
                },
                ieStyle: {
                    height: '40',
                    width: '40',

                    top: '20',
                    left: '30',
                    color: '#444',

                    borderWidth: '1',
                    borderColor: '#23f6f6',
                    borderStyle: 'solid',
                    borderRadius: '0',

                    fontSize: '',
                    fontWeight: '',
                    texAlign: '',

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
                        linkTime: '00:00:00.00',
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
                            from: '00:00:30.33',
                            to: '00:01:30.40'
                        }
                    },
                    {
                        type: 'link',
                        title: 'Back Link',
                        text: 'Go Back',
                        action: 1,
                        href: '#',
                        linkTime: '00:00:00.00',
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
                            from: '00:00:10.00',
                            to: '00:00:40.00'
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
                                case 'height':
                                case 'width':
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
                            action: '',
                            href: '',
                            linkTime: '00:00:00.00',
                            editContainer: false,
                            style: {
                                top: '2%',
                                left: '2%',
                                color: '#25EB25',

                                fontSize: '15px',
                                fontWeight: '500',
                                textAlign: 'center',
                                
                                borderWidth: '1px',
                                borderColor: '#23f6f6',
                                borderStyle: 'solid',
                                borderRadius: '0',

                                backgroundColor: 'transparent'
                            },
                            time: {
                                from: (!_.isEmpty (this.video.currentTime))? datePlugin.spanTimeWithMillisec(this.video.instance.getCurrentTime()).text : '00:00:00.00',
                                to: (!_.isEmpty (this.video.currentTime))? datePlugin.spanTimeWithMillisec(this.video.instance.getCurrentTime()+10).text : '00:00:00.00'
                            }
                        })
                        break;
                    case 'text':
                        this.interactiveElementData.push({
                            type: 'text',
                            title: 'Text Element',
                            text: '<p>Welcome to Vunyx studio</p>',
                            editContainer: true,
                            style: {
                                height: '40%',
                                width: '40%',

                                top: '2%',
                                left: '2%',
                                color: '#25EB25',

                                fontSize: '15px',
                                fontWeight: '500',
                                // textAlign: 'center',

                                padding: '10px',
                                
                                borderWidth: '0px',
                                borderColor: '#23f6f6',
                                borderStyle: 'solid',
                                borderRadius: '0',

                                backgroundColor: 'transparent'
                            },
                            time: {
                                from: (!_.isEmpty (this.video.currentTime))? datePlugin.spanTimeWithMillisec(this.video.instance.getCurrentTime()).text : '00:00:00.00',
                                to: (!_.isEmpty (this.video.currentTime))? datePlugin.spanTimeWithMillisec(this.video.instance.getCurrentTime()+10).text : '00:00:00.00'
                            }
                        });
                        break;
                }

            },
            //layer methods
            editLayer ({index, data}) {
                // Get the index of this.interactiveElementData
                this.layerIndex = index;
                // Populate the this.ieStyle data property
                Object.entries(data.style).forEach(([index, value]) => {
                    this.ieStyle[index] = value.replace(/(px|\%)?$/, '');
                });
            },
            cloneLayer({index, data}) {
                // data.title = ' - clone'
                let clone = _.cloneDeep(data);

                clone.title += ' - duplicate'
                this.interactiveElementData.push(clone);
            },
            removeLayer(index) {
                this.layerIndex = null;
                this.interactiveElementData.splice(index, 1);
            },
            layerInputUpdate({type, event}, index){
                console.log('Input update layer type: '+ type);
                this.interactiveElementData[index].time[type] = event.target.value;
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
            
            getVideoCurrentTime(time){
                this.video.currentTime = time;
                //check if to stop timeline update
                //update timeline slider
                if (this.video.instance.getPlayerState() == 1) {
                    if (!this.stopTimelineUpdate) {
                        this.updateTimelineProgress(this.video.instance.getCurrentTime());
                    }
                }
            },
            playerReady(player) {
                this.video.instance = player;
            },
            videoPlaying(player) {
                this.video.duration = player.getDuration();
                
                //update timeline slider
                this.timelineInstance.update({
                    max: player.getDuration(),
                });
            },
            VideoTimeChange(currentTime) {// video section component method, call when video seekbar is dragged
                // update timeline from
                if (this.video.instance.getPlayerState() == 2) {
                    this.timelineInstance.update({
                        from: currentTime,
                    });
                }
            },
            // timeline
            timelineReady(instance) {
                this.timelineInstance = instance;
            },
            updateTimelineProgress(from){
                this.timelineInstance.update({
                    from: from,
                });
            },
            timelineDrag(e) {
                // this.video.instance.seekTo(e.from);
                this.video.seekTo = e.from;
                this.updateTimelineProgress(e.from)
            },
            prettify (sec) {
                let time = datePlugin.spanTime(sec);
                return time.text;
            },
            timelineDragOnVideoPlaying(){
                //.vx-timeline span.irs-handle
                $('.ie-timeline-container').mousedown( () => {
                    if (!_.isNull(this.video.instance)){
                        if (this.video.instance.getPlayerState() == 1){
                            this.stopTimelineUpdate = true;
                        }
                    }
                }).mouseup(() => {
                    this.stopTimelineUpdate = false;
                });
            }
        },
        mounted() {
            // YDApi.listVideo();

            this.$nextTick(() => {
                $('.ie-body,.interactive-layer-container').overlayScrollbars({
                    autoHide: 'leave'
                });
            });

            this.timelineDragOnVideoPlaying();
        }
    }
</script>
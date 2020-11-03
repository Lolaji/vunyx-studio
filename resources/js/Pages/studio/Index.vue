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
                                    :url="project.video.url"
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

                                <!-- Interactive Data Section -->
                                <div class="row">
                                    <div class="interactive-data-section col-md-12">
                                        <!-- Interactive Timeline Ruler -->
                                        <div class="row mb-3">
                                            <div class="col-md-2">&nbsp;</div>
                                            <div class="col-md-8 ie-timeline-container">
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

                                            <div 
                                                is="transition-group" 
                                                class="col-md-12"
                                                enter-active-class="animate__animated animate__fadeIn"
                                                leave-active-class="animate__animated animate__fadeOut">
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

                                        <!-- Interactive Panel -->
                                        <div class="tab-panel pt-2 fade show active px-3" id="interactive-panel" role="tabpanel" aria-labelledby="interactive-tab">
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="">Title</label>
                                                    <div class="col-8">
                                                        <input 
                                                            type="text" 
                                                            v-model="interactiveElementData[layerIndex].title" 
                                                            class="form-control"
                                                            @change="canSave">
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="">Text</label>
                                                    <div class="col-12 text-editor-container" v-if="interactiveElementData[layerIndex].type == 'text'">
                                                        <text-editor
                                                            v-model="interactiveElementData[layerIndex].text"
                                                            @change="canSave"></text-editor>
                                                    </div>
                                                    <div class="col-8" v-else>
                                                        <input 
                                                            type="text" 
                                                            v-model="interactiveElementData[layerIndex].text" 
                                                            class="form-control"
                                                            @change="canSave">

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="">Action</label>
                                                    <div class="col-8">
                                                        <select v-model="interactiveElementData[layerIndex].action" class="form-control" @change="canSave">
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
                                                        <input 
                                                            type="url" 
                                                            v-model="interactiveElementData[layerIndex].href" 
                                                            class="form-control" 
                                                            placeholder="https://vunyx.com"
                                                            @change="canSave">
                                                    </div>
                                                </div>
                                            </div>

                                            <div v-else-if="interactiveElementData[layerIndex].action == 2">
                                                <div class="form-group">
                                                    <div class="row">
                                                        <label class="label col-3" for="">Link time</label>
                                                        <div class="col-8">
                                                            <input 
                                                                type="text" 
                                                                v-model="interactiveElementData[layerIndex].linkTime" 
                                                                class="form-control" 
                                                                placeholder="HH:MM:SS.MS"
                                                                @change="canSave">  
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="enterAnimation">Enter Animation</label>
                                                    <div class="col-8">
                                                        <select v-model="interactiveElementData[layerIndex].animateClasses.enter" id="enterAnimation" class="form-control" @change="canSave">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="animate__animated animate__fadeIn">Fade In</option>
                                                            <option value="animate__animated animate__fadeOut">Fade Out</option>
                                                            <option value="animate__animated animate__backInLeft">Back In Left</option>
                                                            <option value="animate__animated animate__backInRight">Back In Right</option>
                                                            <option value="animate__animated animate__backOutLeft">Back Out Left</option>
                                                            <option value="animate__animated animate__backOutRight">Back Out Right</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <label class="label col-3" for="leaveAnimation">Leave Animation</label>
                                                    <div class="col-8">
                                                        <select v-model="interactiveElementData[layerIndex].animateClasses.leave" id="leaveAnimation" class="form-control" @change="canSave">
                                                            <option value="">-- Select Action --</option>
                                                            <option value="animate__animated animate__fadeIn">Fade In</option>
                                                            <option value="animate__animated animate__fadeOut">Fade Out</option>
                                                            <option value="animate__animated animate__backInLeft">Back In Left</option>
                                                            <option value="animate__animated animate__backInRight">Back In Right</option>
                                                            <option value="animate__animated animate__backOutLeft">Back Out Left</option>
                                                            <option value="animate__animated animate__backOutRight">Back Out Right</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Design Panel -->
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
                                                                <label for="size" class="col-4 label">Size</label>
                                                                <div class="col-8">
                                                                    <div class="input-group ie">
                                                                        <input type="number" v-model="ieStyle.fontSize" id="size" class="form-control col-4">
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

                                                        <opacity-slider
                                                            :from="ieStyle.opacity"
                                                            :min="0"
                                                            :max="1"
                                                            :step="0.01"
                                                            :selected-layer-index="layerIndex"
                                                            @change="(from) => ieStyle.opacity = from">
                                                                <template #label>
                                                                    Opacity
                                                                </template>
                                                        </opacity-slider>

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
                                            <button 
                                                :disabled="layerIndex === null"
                                                @click="cancel"
                                                class="btn btn-sm btn-link text-danger">CANCEL</button>
                                            <button 
                                                :disabled="layerIndex === null || saving"
                                                @click="save(layerIndex)"
                                                class="btn btn-sm btn-link text-white">
                                                    <transition 
                                                        enter-active-class="animate__animated animate__fadeIn"
                                                        leave-active-class="animate__animated animate__fadeOut">
                                                        <span v-if="saving">
                                                            <i class="fa fa-spinner fa-spin"></i>
                                                        </span>
                                                    </transition> 
                                                    SAVE
                                            </button>
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
    import swalAlert from '../../plugin/vue-swal';

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
    // Sliders
    import HeightSlider from '../../components/form/IeRangeSlider';
    import WidthSlider from '../../components/form/IeRangeSlider';
    import OpacitySlider from '../../components/form/IeRangeSlider';
    import XPositionSlider from '../../components/form/IeRangeSlider';
    import YPositionSlider from '../../components/form/IeRangeSlider';
    import BorderRadiusSlider from '../../components/form/IeRangeSlider';

    // import LinkButton from '../../components/interactive-elements/LinkButton';
    // const LinkButtonClass = Vue.extend(LinkButton);

    export default {
        props:['page_title', 'project', 'elements'],
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
            OpacitySlider,
            XPositionSlider,
            YPositionSlider,
            BorderRadiusSlider
        },
        data() {
            return {
                saving: false,
                removing: {//unused yet
                    status: false,
                    index: null
                },

                layerIndex: null,
                lastLayerEditIndex: null,
                stopTimelineUpdate: false,
                video: {
                    instance: null,
                    playing: false,
                    currentTime: null,
                    seekTo: '',
                    duration: 0,
                    currentTimeInSeconds: null
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

                    opacity: 1,

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
                    // {
                    //     id: null,
                    //     type: 'link',
                    //     title: 'Buy Now Link',
                    //     text: 'Buy Now',
                    //     action: 1,
                    //     href: '#',
                    //     linkTime: '00:00:00.00',
                    //     onEdit: false,
                    //     canSave: true,
                    //     editContainer: false,
                    //     style: {
                    //         top: '20%',
                    //         left: '30%',
                    //         color: '#444',

                    //         fontSize: '15px',
                    //         fontWeight: '500',

                    //         borderWidth: '1px',
                    //         borderColor: '#23f6f6',
                    //         borderStyle: 'solid',
                    //         borderRadius: '0',

                    //         backgroundColor: '#23f6f6',
                    //     },
                    //     time: {
                    //         from: '00:00:30.33',
                    //         to: '00:01:30.40'
                    //     },
                    //     animateClasses: {
                    //         enter: 'animate__animated animate__fadeIn',
                    //         leave: 'animate__animated animate__fadeOut'
                    //     }
                    // }
                ],

                //timeline
                timelineInstance: null,
            }
        },
        watch: {
            ieStyle: {
                handler(nData, oData){
                    if ( ! _.isNull(this.layerIndex) ) {
                        this.interactiveElementData[this.layerIndex].canSave = true; //determines if the element should be save in the database
                        
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
                let index = null;
                let data = {};
                //pause the video if playing
                if (this.video.instance.getPlayerState() == 1)
                    this.video.instance.pauseVideo();
                
                switch(elemType){
                    case 'link':
                        this.interactiveElementData.push({
                            id: null,
                            type: 'link',
                            title: 'Buy Now Link',
                            text: 'Buy Now',
                            action: '',
                            href: "",
                            linkTime: '00:00:00.00',
                            onEdit: false,
                            canSave: true,
                            editContainer: false,
                            style: {
                                top: '50%',
                                left: '45%',
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
                            },
                            animateClasses: {
                                enter: '',
                                leave: ''
                            }
                        })
                        break;
                    case 'text':
                        this.interactiveElementData.push({
                            id: null,
                            type: 'text',
                            title: 'Text Element',
                            text: '<p>Welcome to Vunyx studio</p>',
                            onEdit: false,
                            canSave: true,
                            editContainer: true,
                            style: {
                                height: '40%',
                                width: '40%',

                                top: '45%',
                                left: '45%',
                                color: '#25EB25',

                                fontSize: '15px',
                                fontWeight: '500',
                                // textAlign: 'center',

                                padding: '10px',

                                opacity: 1,
                                
                                borderWidth: '0px',
                                borderColor: '#23f6f6',
                                borderStyle: 'solid',
                                borderRadius: '0',

                                backgroundColor: 'transparent',
                            },
                            time: {
                                from: (!_.isEmpty (this.video.currentTime))? datePlugin.spanTimeWithMillisec(this.video.instance.getCurrentTime()).text : '00:00:00.00',
                                to: (!_.isEmpty (this.video.currentTime))? datePlugin.spanTimeWithMillisec(this.video.instance.getCurrentTime()+10).text : '00:00:00.00'
                            },
                            animateClasses: {
                                enter: '',
                                leave: ''
                            }
                        });
                        break;
                }

                index = this.interactiveElementData.length-1;
                data = this.interactiveElementData[index];
                this.editLayer({index, data});
            },
            save(index){
                console.log(index);
                this.saving = true;
                if (!_.isNull(index)) {
                    let element = this.interactiveElementData[index],
                        id = element.id,
                        data = {
                            type: element.type,
                            title: element.title,
                            text: element.text,
                            action: element.action,
                            href: element.href,
                            link_time: element.linkTime,
                            style: JSON.stringify(element.style),
                            from_time: element.time.from,
                            to_time: element.time.to,
                            enter_animate_class: element.animateClasses.enter,
                            leave_animate_class: element.animateClasses.leave
                        };

                    if (element.canSave){
                        this.$store.dispatch('element/save', {id, data}).then(res => {
                            console.log(res);
                            if (res.success){
                                if (!_.isNull(res.id)){
                                    element.id = res.id;
                                }
                                element.canSave = false;
                                this.saving = false;
                                swalAlert.setTitle(res.message)
                                    .setIcon('success')
                                    .setPosition('top-right')
                                    .toast();
                            }
                        });
                    } else {
                        this.saving = false;
                        swalAlert.setTitle('No changes made')
                                .setIcon('warning')
                                .setPosition('top-right')
                                .toast();
                    }
                } else {
                    this.saving = false;
                    swalAlert.setTitle('No layer selected')
                                .setIcon('warning')
                                .setPosition('top-right')
                                .toast();
                }

            },
            canSave(){//update when form is changed
                this.interactiveElementData[this.layerIndex].canSave = true; //determin if the element should be save to database
            },
            cancel(){
                this.interactiveElementData[this.layerIndex].onEdit = false;
                this.layerIndex = null;
            },

            /**
             * Interactive Element Methods
             */
            elementClick(data){
                let sec = datePlugin.spanTimeToSeconds(data);
                this.video.seekTo = sec;
                this.updateTimelineProgress(sec);
                this.video.instance.seekTo(sec);
            },

            /**
             * Layer Methods
             */
            async editLayer ({index, data}) {
                let fromSec = datePlugin.spanTimeToSeconds(data.time.from);

                this.deActiveLastLayerEdit();
                // Get the index of this.interactiveElementData
                this.layerIndex = index;
                data.onEdit = true;
                this.lastLayerEditIndex = index;
                // Populate the this.ieStyle data property
                Object.entries(data.style).forEach(([index, value]) => {
                    this.ieStyle[index] = (typeof(value) == 'string')?value.replace(/(px|\%)?$/, ''): value;
                });

                // pause video on edit

                await this.video.instance.seekTo(fromSec);

                if (this.video.playing)
                    await this.video.instance.pauseVideo();

                this.updateTimelineProgress(fromSec);
                
            },
            cloneLayer({index, data}) {
                // data.title = ' - clone'
                let clone = _.cloneDeep(data);

                clone.title += ' - duplicate'
                this.interactiveElementData.push(clone);
            },
            removeLayer(index) {
                let element = this.interactiveElementData[index];
                if (!_.isNull(element.id)){
                    this.$store.dispatch('element/remove', element.id).then(res => {
                        if (res.success){
                            this.layerIndex = null;
                            this.interactiveElementData.splice(index, 1);

                            swalAlert.setTitle(res.message)
                                        .setIcon('success')
                                        .toast();
                        } else {
                            swalAlert.setTitle(res.message)
                                        .setIcon('error')
                                        .toast();
                        }
                        //set lastLayerEditIndex to null if it
                        // matches the index parameter that was remove/deleted
                        // from the interactiveElementData Object
                        if (index === this.lastLayerEditIndex){
                            this.lastLayerEditIndex = null;
                        }
                    });
                } else {
                    this.layerIndex = null;
                    this.interactiveElementData.splice(index, 1);

                    this.removing.stutus = true;
                    this.removing.index = null;
                }
            },
            layerInputUpdate({type, event}, index){
                this.interactiveElementData[index].time[type] = event.target.value;
            },
            deActiveLastLayerEdit() {
                if (!_.isNull(this.lastLayerEditIndex))
                    this.interactiveElementData[this.lastLayerEditIndex].onEdit = false;
            },
            /**
             * Determin if the element has a container
             * 
             * -- NOTE --: This method should be updated when new interactive is added to the platform
             */
            isElementHasContainer(type){
                switch(type) {
                    case 'link':
                        return false;
                        break;
                    case 'text':
                        return true;
                        break;
                }
            },

            insertElement() {//This method is unused
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
                if (this.video.instance.getPlayerState() == 1) {
                    this.video.currentTime = time;
                    this.video.currentTimeInSeconds = this.video.instance.getCurrentTime();

                    //check if to stop timeline update
                    //update timeline slider
                    if (!this.stopTimelineUpdate) {
                        this.updateTimelineProgress(this.video.instance.getCurrentTime());
                    }
                }
            },
            playerReady(player) {
                this.video.instance = player;
            },
            videoPlaying(player) {
                this.video.playing = true;
                this.video.duration = player.getDuration();
                
                //update timeline slider
                this.timelineInstance.update({
                    max: player.getDuration(),
                });
            },
            videoPaused(player){
                this.video.playing = false;
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
                this.video.currentTimeInSeconds = this.video.instance.getCurrentTime();
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
            },
        },
        created(){
            this.$store.commit('element/SET_PROJECT_ID', this.project.id);

            Object.entries(this.project.elements).forEach(([index, value]) => {
                this.interactiveElementData.push({
                    id: value.id,
                    type: value.type,
                    title: value.title,
                    text: value.text,
                    action: value.action,
                    href: value.href,
                    linkTime: value.link_time,
                    onEdit: false,
                    canSave: false,
                    editContainer: this.isElementHasContainer(value.type),
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
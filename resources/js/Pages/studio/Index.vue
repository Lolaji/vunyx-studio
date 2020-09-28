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
                                    @get-current-time="getVideoCurrentTime">
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
                                                <ion-slider></ion-slider>
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
                                            id="customization-tab" 
                                            href="#customization-panel" 
                                            role="tab"
                                            data-toggle="tab"
                                            aria-controls="customization-panel"
                                            aria-selected="false">Customization</a>
                                    </nav>
                                </div>
                                <div class="ie-body">

                                    <div class="tab-content" v-if="layerIndex != null">

                                        <div class="tab-panel pt-2 fade show active" id="interactive-panel" role="tabpanel" aria-labelledby="interactive-tab">
                                            
                                            <div class="form-group form-inline">
                                                <label class="label col-3" for="">Title</label>
                                                <input type="text" v-model="interactiveElementData[layerIndex].title" class="form-control">
                                            </div>

                                            <div class="form-group form-inline">
                                                <label class="label col-3" for="">Text</label>
                                                <input type="text" v-model="interactiveElementData[layerIndex].text" class="form-control">
                                            </div>

                                            <div class="form-group form-inline">
                                                <label class="label col-3" for="">Action</label>
                                                <select v-model="interactiveElementData[layerIndex].action" class="form-control col-md-5">
                                                    <option value="1">Link to external webpage</option>
                                                    <option value="2">Link to specific time</option>
                                                </select>
                                            </div>

                                            <div class="form-group form-inline" v-if="interactiveElementData[layerIndex].action == 1">
                                                <label class="label col-3" for="">Hypertext</label>
                                                <input type="url" v-model="interactiveElementData[layerIndex].href" class="form-control" placeholder="https://vunyx.com">
                                            </div>

                                            <div v-else>
                                                <div class="form-group form-inline">
                                                    <label class="label col-3" for="">From</label>
                                                    <input type="url" v-model="interactiveElementData[layerIndex].time.from" class="form-control" placeholder="https://vunyx.com">
                                                </div>

                                                <div class="form-group form-inline">
                                                    <label class="label col-3" for="">To</label>
                                                    <input type="url" v-model="interactiveElementData[layerIndex].time.to" class="form-control" placeholder="https://vunyx.com">
                                                </div>
                                            </div>
                                            
                                            <!-- <div class="form-group">
                                                <div class="icheck-light-yellow d-inline">
                                                    <input type="radio" id="checkboxPrimary3">
                                                    <label for="checkboxPrimary3">Primary checkbox</label>
                                                </div>
                                            </div> -->

                                        
                                        </div>

                                        <div class="tab-panel fade" id="customization-panel" role="tabpanel" aria-describedby="customization-tab">
                                            <ul class="list-group">
                                                
                                                <div>
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#position">
                                                        Position
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse show" id="position">

                                                        <div class="form-group form-inline">
                                                            <label class="label col-3" for="">X</label>
                                                            <input type="text" v-model="interactiveElementData[layerIndex].style.left" class="form-control">
                                                        </div>

                                                        <div class="form-group form-inline">
                                                            <label class="label col-3" for="">Y</label>
                                                            <input type="text" v-model="interactiveElementData[layerIndex].style.top" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div>
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#background">
                                                        Color
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse" id="background">
                                                        <text-color-picker
                                                            class="pt-1"
                                                            :model="interactiveElementData[layerIndex].style.color">
                                                                <template #label>Text Color</template>
                                                        </text-color-picker>

                                                        <bg-color-picker
                                                            class="pt-1"
                                                            :model="interactiveElementData[layerIndex].style.backgroundColor">
                                                            <template #label>Background</template>
                                                        </bg-color-picker>
                                                    </div>
                                                </div>
                                                <div>
                                                    <li class="list-group-item" data-toggle="collapse" data-target="#padding">
                                                        Padding
                                                        <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                                    </li>
                                                    <div class="content collapse" id="padding">
                                                        Editor Form Here
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
    import Vue from 'vue';
    import StudioLayout from '../../Layouts/StudioLayout';
    import InteractiveSidebar from '../../components/InteractiveSidebar';

    import IonSlider from '../../components/IonRangeSlider';
    
    import VideoSection from '../../components/VideoSec';
    import IElement from '../../components/interactive-elements/IElement';
    import TextColorPicker from '../../components/ColorPicker';
    import BgColorPicker from '../../components/ColorPicker';

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
            BgColorPicker
        },
        data() {
            return {
                layerIndex: null,
                video: {
                    instance: null,
                    currentTime: ''
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
                            border: '1px solid #23f6f6',
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
                            // border: '1px solid #e4e4e4',
                            borderRadius: '40%',
                            backgroundColor: '#444',

                        },
                        time: {
                            from: '00:00:30.00',
                            to: '00:02:30.00'
                        }
                    }
                ]
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
                                border: '1px solid #23f6f6',
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
            },
            removeLayer(index) {
                console.log(index)
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
            isLayerExist(index){
                // return this.interactiveElementData
            },
            getVideoCurrentTime(time){
                this.video.currentTime = time;
            },
            playerReady(player) {
                this.video.instance = player
            }
        },
        mounted() {
            // this.insertElement()
        }
    }
</script>
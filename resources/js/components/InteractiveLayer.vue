<template>
    <div>
        <div 
            class="row layer mb-0 pb-0" :class="classes">
                
                <div class="col-3">
                    <div class="layer-btn">
                        <button 
                            @click="edit(index, data)"
                            class="btn btn-xs btn-info"><i class="fa fa-pencil-alt"></i></button>
                        <button 
                            @click="clone(index, data)"
                            class="btn btn-xs btn-primary"><i class="fa fa-clone"></i></button>
                        <button 
                            @click="remove(index)"
                            class="btn btn-xs btn-danger"><i class="fa fa-trash-alt"></i></button>
                    </div>
                    <div class="layer-name pt-1 pl-1">
                        <span class="icon">
                            <ie-icon :type="data.type"></ie-icon>
                        </span>
                        <span class="title">{{data.title}}</span>
                        <!-- <span class="icon"><i class="fa fa-angle-down"></i></span> -->
                    </div>
                </div>
                <div class="col-6 pt-2">
                    <div class="row">
                        <div 
                            ref="timelineContainer"
                            class="interactive-timeline interactive-position">
                                <span 
                                    ref="elemPosition"
                                    class="time-position"></span>
                        </div>
                    </div>                          
                </div>
                <div class="col-3">
                    <div class="time-input">
                        <div class="row pt-2">
                            <input 
                                type="text" 
                                :value="data.time.from" 
                                @input="timeInputUpdate('from', $event)" 
                                class="col form-control form-control-sm mx-1" 
                                :class="{
                                    col: isToExist,
                                    'col-6': !isToExist,
                                }"
                                placeholder="HH:MM:SS.MS">

                            <input 
                                v-if="isToExist"
                                type="text" 
                                :value="data.time.to" 
                                @input="timeInputUpdate('to', $event)" 
                                class="col form-control form-control-sm mr-1" 
                                placeholder="HH:MM:SS.MS">
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    import datePlugin from '../plugin/Date';
    import IeIcon from '../components/InteractiveIcon';
    import 'jquery-ui/themes/base/all.css'

    export default {
        props: {
            index: {
                type: Number
            },
            data: {
                type: Object,
                default: () => {}
            },
            classes: {
                type: [String, Object]
            },
            duration: {
                type: [String, Number]
            },
            hasTo: {
                type: Boolean,
                default: () => false
            }
        },
        components: {IeIcon},
        computed: {
            isToExist(){//check this.to exists
                return this.data.time.to != undefined;
            }
        },
        data(){
            return {
                layerIndex: null,
                from: '',
                to: '',
                type: 'link'
            }
        },
        methods: {
            edit (index, data) {
                this.$emit('edit', {index, data});
            },
            clone(index, data) {
                this.$emit('clone', {index, data});
            },
            remove(index) {
                this.$emit('remove', index);
            },
            getFromTo(ft, data) {
                console.log(ft+' : '+data);
            },
            positionElementIndicator() {
                let elemPosition = this.$refs.elemPosition;
                let timelineContainerRect = this.$refs.timelineContainer.getBoundingClientRect();
                    // attrData = $(elemPosition).data();
                
                let fromArr = this.from.split(':'),
                    toArr = this.to.split(':'),
                    fromSeconds = null,
                    toSeconds = null,
                    startPercent = 0,
                    endPercent = 0,
                    width = 1;
                
                fromSeconds = (parseInt(fromArr[0]) * 3600)+(parseInt(fromArr[1]) * 60)+ parseFloat(fromArr[2]);
                toSeconds = (parseInt(toArr[0]) * 3600)+(parseInt(toArr[1]) * 60)+parseFloat(toArr[2]);

                if (this.duration > 0) {
                    startPercent = (100 * (fromSeconds/parseFloat(this.duration)));
                    endPercent = (100 * (toSeconds / parseFloat(this.duration)));
                    width = endPercent - startPercent;
                }


                elemPosition.style.left = (startPercent/100)*timelineContainerRect.width + 'px';
                // elemPosition.style.marginLeft = startPercent + '%';
                if (this.isToExist) {//checks this.to exists
                    elemPosition.style.width = ((width == 0)? (0.50/100)*timelineContainerRect.width : (width/100)*timelineContainerRect.width) + 'px';
                } else {
                    // elemPosition.innerHTML = '<span><i class="fa fa-question"></i></span>';
                    elemPosition.style.width = 20 + 'px';
                }

                console.log(startPercent);
                console.log(width);
            },
            timeInputUpdate (type, event) {
                let value = event.target.value;
                if (type == 'from'){
                    this.from = value;
                } else {
                    this.to = value;
                }
                this.positionElementIndicator();

                this.$emit('input-update', {type, value}, this.index);
            },

            //Time Position resizing and draging
            resize (e, ui) {
                console.log(e.target.style.left, ui);
                let left = parseFloat(e.target.style.left.replace(/px?$/, ''));
                let width = ui.size.width;

                this.updateTime(left, width);
            },
            draggable (e, ui) {
                if (ui.position.left < 0) {
                    console.log('Left less than 0')
                    this.$refs.elemPosition.style.left = '0px';
                }
                console.log(e.target.style.width, ui.position);
                let left = ui.position.left;
                let width = parseFloat(e.target.style.width.replace(/px?$/, ''));

                this.updateTime(left, width);
            },
            updateTime(left, width) {
                let containerWidth = this.$refs.timelineContainer.getBoundingClientRect().width;
                let duration = parseFloat(this.duration);

                let leftPercent = (left/containerWidth)*100;
                let widthPercent = (width/containerWidth)*100;

                let startSec = (leftPercent/100)*duration;
                let endSec = ((widthPercent/100)*duration)+startSec;

                let enterTime = datePlugin.spanTimeWithMillisec(startSec).text;
                let leaveTime = datePlugin.spanTimeWithMillisec(endSec).text;

                this.from = enterTime;
                this.to = leaveTime;

                this.$emit('input-update', {type: 'from', value:enterTime}, this.index);
                this.$emit('input-update', {type: 'to', value:leaveTime}, this.index);
            }
        },
        updated(){
            this.from = this.data.time.from;
            if (this.isToExist)
                this.to = this.data.time.to;

            this.positionElementIndicator();
        },
        mounted(){
            this.from = this.data.time.from;
            if (this.isToExist) //check this.to exists
                this.to = this.data.time.to;

            this.positionElementIndicator();

            $(this.$refs.elemPosition).resizable({
                handles: 'e,w',
                minHeight: 14,
                containment: 'parent',
                resize: (e, ui) => {
                    this.resize(e, ui);
                }
            });

            $(this.$refs.elemPosition).draggable({
                axis: 'x',
                containment: 'parent',
                drag: (e, ui) => {
                    this.draggable(e, ui);
                }
            })

        }
    }
</script>
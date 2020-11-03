<template>
    <div>
        <div 
            class="row layer mb-0 pb-0" :class="classes">
                
                <div class="col-md-3">
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
                <div class="col-md-6 pt-2">
                    <div class="row">
                        <div class="interactive-timeline interactive-position">
                            <span 
                                ref="elemPosition"
                                class="time-position"></span>
                        </div>
                    </div>                          
                </div>
                <div class="col-md-3">
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
                                class="col form-control form-control-sm mx-1" 
                                placeholder="HH:MM:SS.MS">
                        </div>
                    </div>
                </div>
        </div>
    </div>
</template>

<script>
    import IeIcon from '../components/InteractiveIcon';
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
            isToExist(){
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

                elemPosition.style.marginLeft = startPercent + '%';
                if (this.isToExist) {
                    elemPosition.style.width = ((width == 0)? 0.50 : width) + '%';
                } else {
                    // elemPosition.innerHTML = '<span><i class="fa fa-question"></i></span>';
                    elemPosition.style.width = 20 + 'px';
                }

                console.log(startPercent);
                console.log(width);
            },
            timeInputUpdate (type, event) {
                if (type == 'from'){
                    this.from = event.target.value;
                } else {
                    this.to = event.target.value;
                }
                this.positionElementIndicator();

                this.$emit('input-update', {type, event}, this.index);
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
            if (this.isToExist)
                this.to = this.data.time.to;

            this.positionElementIndicator();
        }
    }
</script>

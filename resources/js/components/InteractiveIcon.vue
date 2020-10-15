<template>
    <i :class="iconClasses"></i>
</template>

<script>
export default {
    props: {
        type: {
            type: String,
            required: true,
        },
        classes: {
            type: String
        }
    },
    data(){
        return {
            iconClasses: ''
        }
    },
    mounted() {
        switch(this.type){
            case 'link':
                this.iconClasses = (this.classes)? this.classes+' fa fa-link': 'fa fa-link'
                break;

            case 'text':
                this.iconClasses = (this.classes)? this.classes+' fi flaticon-font': 'fi flaticon-font'
                break;

            case 'hotspot':
                this.iconClasses = (this.classes)? this.classes+' fi flaticon-hardware-hotspot': 'fi flaticon-hardware-hotspot'
                break;

            case 'question':
                this.iconClasses = (this.classes)? this.classes+' fas fa-question-circle': 'fas fa-question-circle'
                break;
            
            case 'chapter':
                this.iconClasses = (this.classes)? this.classes+' fas fa-list': 'fas fa-list'
                break;

            case 'image':
                this.iconClasses = (this.classes)? this.classes+' fas fa-image': 'fas fa-image'
                break;
        }
    }
}
</script>
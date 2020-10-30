<template>
    <img 
        :src="LogoUrl" 
        alt="vunyx logo" 
        class="brand-image">
</template>
<script>
export default {
    computed: {
        LogoUrl(){
            return window.location.origin+'/img/logo.png'
        }
    },
    mounted(){
        console.log(this.LogoUrl)
    }
}
</script>
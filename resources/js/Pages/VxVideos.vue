
<template>
    <studio-layout>
        <template #leftSideBar>
            <main-sidebar></main-sidebar>
        </template>

        <template #ContentHeader>
            <content-header
                :page-title="page_title"></content-header>
        </template>

        <template #mcontent>
            <section class="container">
                <!-- Default box -->
                <div class="card card-solid">

                    <div class="card-body pb-0">
                        <div class="row d-flex align-items-stretch">

                            <div 
                                class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch" 
                                v-for="(video, index) in videos" :key="index">
                                <div class="card bg-light ie-project">
                                    <div class="card-body p-0">
                                        <img :src="video.video_img" width="320" height="200" alt="">
                                    </div>
                                    <div class="card-footer">
                                        <div class="row justify-content-between">
                                            <div class="col-10">
                                                <span class="text-muted font-weight-bold">{{video.video_title}}</span><br>
                                                <span class="text-muted">{{video.video_description}}</span>
                                            </div>
                                            
                                            <div class="col-1">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="vx-link no-icon dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <a 
                                                            href="#"
                                                            class="dropdown-item text-muted"
                                                            @click.prevent="addInteractive(index)"> Add Interactive</a>
                                                        <!-- <div class="dropdown-divider"></div>
                                                        <a class="dropdown-item text-muted" href="#"> <i class="fa fa-trash text-danger"></i> Delete</a> -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                    <!-- /.card-body -->
                    <!-- <div class="card-footer">
                        <nav aria-label="Contacts Page Navigation">
                            <ul class="pagination justify-content-center m-0">
                                <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">4</a></li>
                                <li class="page-item"><a class="page-link" href="#">5</a></li>
                                <li class="page-item"><a class="page-link" href="#">6</a></li>
                                <li class="page-item"><a class="page-link" href="#">7</a></li>
                                <li class="page-item"><a class="page-link" href="#">8</a></li>
                            </ul>
                        </nav>
                    </div> -->
                    <!-- /.card-footer -->
                </div>
                <!-- /.card -->
            </section>
        </template>
    </studio-layout>    
</template>

<script>

import StudioLayout from '../Layouts/StudioLayout';
import MainSidebar from "../components/MainSidebar.vue";
import ContentHeader from "../components/ContentHeader.vue";

export default {
    props:['page_title', 'vxVideos'],
    components: {
        StudioLayout,
        MainSidebar,
        ContentHeader
    },
    computed: {
        videos(){
            return _.cloneDeep(this.vxVideos);
        }
    },
    data(){
        return {
            
        }
    },
    methods: {
        addInteractive(index){
            let video = this.videos[index];
            let vurl = video.video_src.split('/');
            let user_id = video.user_id;
            let data = {
                title: video.video_title,
                description: video.video_description,
                video: {
                    platform: 'youtube',
                    vid: vurl[4],
                    url: `https://www.youtube.com/watch?v=${vurl[4]}`,
                    image: video.video_img
                }
            }

            this.$store.dispatch('project/addInteractive', {user_id, data}).then(res => {
                console.log(res);
            });
        }
    },
    mounted() {
        console.log(this.vxVideos)

        // axios.post('http://localhost:3000/api/user', {
        //     name: 'Adeolu',
        //     email: 'adeolu@gmail.com',
        //     password: ''
        // }).then(res => {
        //     console.log(res.data);
        // }).catch(err => {
        //     if (err.response)
        //         console.error(err.response.data.message);
        // });
    }
}
</script>
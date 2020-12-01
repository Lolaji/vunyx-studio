
<template>
    <studio-layout>
        <template #leftSideBar>
            <main-sidebar
                :username="username"></main-sidebar>
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
                                v-for="(project, index) in interactiveProjects" :key="index">
                                <div class="card bg-light ie-project">
                                    <div class="card-header text-muted border-bottom-0">
                                        <div class="row justify-content-between p-0">
                                            <div class="col-11 p-0">
                                                <input 
                                                    type="text" 
                                                    ref="titleForm"
                                                    class="form-control title-form text-muted" 
                                                    :disabled="true" 
                                                    :value="project.title">
                                            </div>
                                            <div class="col-1 p-0">
                                                <inertia-link 
                                                    :href="`/studio/${project.uuid}`" 
                                                    class="vx-link float-right">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </inertia-link>

                                            </div>
                                        </div>
                                        <!-- {{project.video.video_title}} -->
                                    </div>
                                    <div class="card-body p-0">
                                        <img :src="project.video.image" width="320" height="200" alt="">
                                    </div>
                                    <div class="card-footer">
                                        <div class="row justify-content-between">
                                            <div class="col-10">
                                                <transition
                                                    enter-active-class="animate__animated animate__zoomIn"
                                                    leave-active-class="animate__animated animate__zoomOut">
                                                    <span class="event-indicator" :class="action" v-show="!!action && !!p_index && p_index == index">
                                                        <i class="fa fa-spinner fa-spin"></i>
                                                        <span>{{action}}...</span> 
                                                    </span>
                                                </transition>
                                                <br v-if="!!action && !!p_index && p_index == index">
                                                <span 
                                                    class="badge"
                                                    :class="[(project.is_published)?'badge-success':'badge-danger']"
                                                    >{{(project.is_published)? 'Published': 'Un-Publish'}}</span>
                                                <span class="badge border text-muted">15:45</span><br>
                                                <span class="text-muted">Last edited: 6 days ago</span>
                                            </div>
                                            
                                            <div class="col-1">
                                                <div class="dropdown">
                                                    <a href="javascript:void(0)" class="vx-link no-icon dropdown-toggle" data-toggle="dropdown">
                                                        <i class="fa fa-ellipsis-v"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <inertia-link 
                                                            :href="'/studio/'+project.uuid"
                                                            class="dropdown-item text-muted"><i class="fa fa-edit"></i> Edit</inertia-link>

                                                        <a class="dropdown-item text-muted" href="#" @click.prevent="accessPage"> <i class="ion-stats-bars"></i> Analytics</a>
                                                        <a 
                                                            class="dropdown-item text-muted" 
                                                            target="__blank" 
                                                            :href="`/player/${project.uuid}`"> <i class="fa fa-eye"></i> Preview</a>
                                                        <!-- <a class="dropdown-item text-muted" href="#"> <i class="fa fa-share"></i> Share</a> -->
                                                        <a 
                                                            class="dropdown-item text-muted" 
                                                            :href="`/main/settings/${project.uuid}`"> <i class="fa fa-cogs"></i> Settings</a>

                                                        <div class="dropdown-divider"></div>

                                                        <!-- <a class="dropdown-item text-muted" href="#"> <i class="fa fa-clone"></i> Duplicate</a> -->

                                                        <a 
                                                            href="javascript:void(0)"
                                                            class="dropdown-item text-muted"
                                                            @click.prevent="deleteProject(index, project.id)"> <i class="fa fa-trash text-danger"></i> Delete</a>
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

import swal from '../plugin/vue-swal';

import StudioLayout from '../Layouts/StudioLayout';
import MainSidebar from "../components/MainSidebar.vue";
import ContentHeader from "../components/ContentHeader.vue";
export default {
    props:['page_title', 'username', 'projects'],
    components: {
        StudioLayout,
        MainSidebar,
        ContentHeader
    },
    data(){
        return {
            action: null,
            p_index: null,
            video_id: null,
            interactiveProjects:[]
        }
    },
    methods: {
        saveVideoTitle() {
            console.log(this.video_id);
            this.editTitle = false
        },
        deleteProject(index, id){
            swal.setTitle('Are you sure?')
                .setText('You will not be able to revert this.')
                .setIcon('error')
                .confirm(() => {
                    this.action = 'deleting';
                    this.p_index = index;
                    this.$store.dispatch('project/delete', id).then(res => {
                        console.log(res);
                        if (res.success) {
                            this.interactiveProjects.splice(index, 1);
                            swal.setTitle(res.message)
                                .setIcon('success')
                                .toast();
                        } else {
                            swal.setTitle(res.message)
                                .setIcon('error')
                                .toast();
                        }
                        this.action = null;
                        this.p_index = null;
                    });
                });
        }
    },
    created(){
        $('title').html(`${this.page_title} | Vunyx`);
        this.interactiveProjects = _.cloneDeep(this.projects);
    }
}
</script>

<style lang="scss" scoped>
    .ie-project {
        .card-header {
            .vx-link {
                display: none;
            }
            .form-control {
                height: 25px;        
                padding: 0 1px 2px;
                border: none;
                border-radius: 0;
                background: transparent;
                &.title-form {
                    border-bottom-width: 1px;
                    border-bottom-style: solid;
                    border-bottom-color: transparent;
                    
                    &:disabled {
                        border-bottom-color: transparent;
                    }
                    &:focus {
                        border-bottom-color: #e1c238;
                    }
                }
            }
        }
        &:hover {
            .card-header .vx-link {
                display: block;

                animation: fadeIn 1s;
            }
        }
        .event-indicator {
            font-size: 13px;

            &.updating{
                color: #129e30;
            }

            &.duplicating{
                color: #2bc0c5;
            }

            &.deleting{
                color: #e2322c;
            }
        }
    }
</style>
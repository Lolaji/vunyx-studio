<template>
    <studio-layout>
        <template #leftSideBar>
            <main-sidebar :username="username"></main-sidebar>
        </template>

        <template #ContentHeader>
            <content-header :page-title="page_title"></content-header>
        </template>

        <template #mcontent>
            <section class="container">
                <div class="row justify-content-center">
                    <div class="col-md-10">
                        <div class="card">
                            <div class="card-header p-2">
                                <ul class="nav nav-pills">
                                    <li class="nav-item">
                                        <a
                                            class="nav-link active"
                                            href="#publish"
                                            data-toggle="tab">
                                                Publish
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a
                                            class="nav-link"
                                            href="#general"
                                            data-toggle="tab">
                                                General
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <div class="tab-content">
                                    <div class="active tab-pane" id="publish">
                                        <div class="col-md-12 border-bottom pb-3">
                                            <div class="row">
                                                <div class="col-md-7">
                                                    <div class="form-group">
                                                        <label for="">Video URL</label>
                                                        <input 
                                                            type="text" 
                                                            class="form-control input:video-url" 
                                                            readonly
                                                            @click="$event.target.select()"
                                                            :value="video_url">
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="">Watch Availability</label>
                                                        <select 
                                                            v-model="watch_access"
                                                            class="form-control">
                                                                <option value="0">Public</option>
                                                                <option value="1">Restricted</option>
                                                        </select>
                                                        <small class="form-text text-muted">{{ watch_access_desc[watch_access] }}</small>
                                                    </div>
                                                    <transition
                                                        enter-active-class="animate__animated animate__zoomIn"
                                                        leave-active-class="animate__animated animate__zoomOut">

                                                        <div class="row" v-if="watch_access == 1">
                                                            <div class="col-12">
                                                            
                                                                <div class="input-group pb-1">
                                                                    <input 
                                                                        type="text" 
                                                                        v-model="viewer_username" 
                                                                        id="username" 
                                                                        class="form-control" 
                                                                        placeholder="Enter Username">

                                                                    <div class="input-group-append">
                                                                        <button 
                                                                            type="button" 
                                                                            class="btn btn-info"
                                                                            @click="addViewer">Add</button>
                                                                    </div>
                                                                </div>

                                                                <ul class="list-group">
                                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                                        {{username}}
                                                                        <span class="badge badge-pill vx-bg-color">Owner</span>
                                                                    </li>

                                                                    <li 
                                                                        v-for="(viwer, index) in viewers"
                                                                        :key="index"
                                                                        class="list-group-item justify-content-between align-content-center">
                                                                            {{viwer.username}}
                                                                            
                                                                            <button 
                                                                                class="btn btn-xs vx-link float-right"
                                                                                @click="removeViewer(viwer.id, index)"><i class="fa fa-trash"></i></button>
                                                                    </li>
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 pt-3">
                                            <!-- <div class="row justify-content-center">
                                                <div class="col-10 row border justify-content-center">
                                                    
                                                    <div class="col-2">
                                                        <a href="javascript:void(0)" class="share-link btn btn-link btn-light border rounded-circle text-dark">
                                                            <i class="fa fa-code"></i>
                                                        </a>
                                                    </div>
                                                    <div class="col-2">
                                                        Share 1
                                                    </div>
                                                    <div class="col-2">
                                                        Share 1
                                                    </div>
                                                    <div class="col-2">
                                                        Share 1
                                                    </div>
                                                </div>
                                            </div> -->
                                            <div class="row">
                                                <div class="col-7">
                                                    <div class="form-group">
                                                        <label for="">Enbeded Code</label>
                                                        <textarea 
                                                            readonly
                                                            v-model="embed_code" 
                                                            cols="20" 
                                                            rows="4" 
                                                            class="form-control"
                                                            @click="$event.target.select()"></textarea>
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group">
                                                        <label for="">Embed Access</label>
                                                        <select 
                                                            v-model="embed_access"
                                                            class="form-control">
                                                                <option value="0">All domains</option>
                                                                <option value="1">Restricted</option>
                                                        </select>
                                                        <small class="form-text text-muted">{{ embed_access_desc[embed_access] }}</small>
                                                    </div>

                                                    <transition
                                                        enter-active-class="animate__animated animate__zoomIn"
                                                        leave-active-class="animate__animated animate__zoomOut">

                                                        <div class="row" v-if="embed_access == 1">
                                                            <div class="col-12">
                                                            
                                                                <div class="input-group pb-1">
                                                                    <input 
                                                                        type="text" 
                                                                        v-model="domain_name" 
                                                                        id="domain" 
                                                                        class="form-control" 
                                                                        placeholder="https://vunyx.com">

                                                                    <div class="input-group-append">
                                                                        <button 
                                                                            type="button"
                                                                            class="btn btn-info" 
                                                                            @click="addDomain">Add</button>
                                                                    </div>
                                                                </div>

                                                                <ul class="list-group">
                                                                    <li
                                                                        v-if="embed_domains.length == 0"
                                                                        class="list-group-item text-center text-muted">No Domain Added.</li>

                                                                    <li 
                                                                        v-for="(domain, index) in embed_domains"
                                                                        :key="index"
                                                                        class="list-group-item d-flex justify-content-between align-items-center">

                                                                            {{domain.domain}}

                                                                            <button 
                                                                                class="btn btn-xs vx-link float-right"
                                                                                @click="removeDomain(domain.id, index)"><i class="fa fa-trash"></i></button>
                                                                    </li>
                                                                    
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </transition>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.tab-pane -->

                                    <div class="tab-pane" id="general">
                                        General
                                    </div>
                                    <!-- /.tab-pane -->
                                </div>
                                <!-- /.tab-content -->
                            </div>
                            <!-- /.card-body -->

                            <div class="card-footer border-top bg-light">
                                <div class="row justify-content-end">
                                    <inertia-link 
                                        href="/main/project"
                                        class="btn btn-sm btn-default mr-2">CANCEL</inertia-link>

                                    <button 
                                        type="button" 
                                        class="btn btn-sm btn-primary"
                                        :disabled="load.setting"
                                        @click="save"> 
                                            <i 
                                                class="fa"
                                                :class="{
                                                    'fa-save': !load.setting,
                                                    'fa-spinner': load.setting,
                                                    'fa-spin': load.setting
                                                }"></i> 
                                                {{(load.setting)?'SAVING...': 'SAVE'}}</button>
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
import swal from '../plugin/vue-swal';
import NetworkErrorHandler from '../plugin/error-handler/network';
import ErrorHandlerReusable from '../plugin/reusable/error';

import StudioLayout from '../Layouts/StudioLayout';
import MainSidebar from "../components/MainSidebar.vue";
import ContentHeader from "../components/ContentHeader.vue";
export default {
    props: ["page_title", "username", 'project'],
    mixins: [ErrorHandlerReusable],
    components: {
        StudioLayout,
        MainSidebar,
        ContentHeader
    },
    data(){
        return {
            video_url: '',
            embed_code: '',
            watch_access: 0,
            embed_access: 0,
            viewers: [],
            embed_domains: [],
            viewer_username: '',
            domain_name: '',
            load: {
                setting: false
            },
            watch_access_desc: [
                'Anyone with the link can watch.',
                'Any registered users you selected can watch.',
            ],
            embed_access_desc: [
                'Can be embeded on any website',
                'Can be embeded on any selected website.',
            ],
        }
    },
    methods: {
        save(){
            this.load.setting = true;
            let data = {
                project_id: this.project.id,
                data: {
                    domain_access: this.embed_access,
                    watch_access: this.watch_access
                }
            }

            this.$store.dispatch('project/setting/save', data).then(res => {
                console.log(res);
                if (res.success) {
                    swal.setTitle(res.message).setIcon('success').toast();
                } else {
                    swal.setTitle(res.message).setIcon('error').toast();
                }
                this.load.setting = false;
            }).catch(error => {
                this.handleNetworkError(error);
                this.load.setting = false;
            });
        },
        addViewer(){
            this.clearFormError('username');
            let data = {
                project_id: this.project.id,
                data: {
                    username: this.viewer_username
                }
            }

            console.log(data);
            this.$store.dispatch('project/addViewer', data).then(res => {
                console.log(res);
                if (res.success) {
                    this.viewer_username = '';
                    this.viewers.push(res.result);
                    swal.setTitle(res.message).setIcon('success').toast();
                } else {
                    if (res.message instanceof Object) {
                        this.formError('username', res.message.username);
                    } else {
                        swal.setTitle(res.message).setIcon('error').toast();
                    }
                }
            }).catch(error => {
                this.handleNetworkError(error);
            });
        },
        addDomain(){
            this.clearFormError('domain');
            let data = {
                domain: this.domain_name
            }

            this.$store.dispatch('project/addDomain', {
                project_id: this.project.id,
                data: data
            }).then(res => {
                console.log(res);
                if (res.success) {
                    this.domain_name = '';
                    this.embed_domains.push(res.result)

                    swal.setTitle(res.message).setIcon('success').toast();
                } else {
                    if (res.message instanceof Object) {
                        this.formError('domain', res.message.domain);
                    } else {
                        swal.setTitle(res.message).setIcon('error').toast();
                    }
                }
            }).catch(error => {
                this.handleNetworkError(error);
            });
        },
        removeViewer(id, index) {
            this.$store.dispatch('project/removeViewer', id).then(res => {
                if (res.success){
                    this.viewers.splice(index, 1);
                    swal.setTitle(res.message).setIcon('success').toast();
                } else {
                    swal.setTitle(res.message).setIcon('error').toast();
                }
            }).catch(error => {
                this.hamdleNetworkError(error);
            })
        },
        removeDomain(id, index) {
            this.$store.dispatch('project/removeDomain', id).then(res => {
                if (res.success){
                    this.embed_domains.splice(index, 1);

                    swal.setTitle(res.message).setIcon('success').toast();
                } else {
                    swal.setTitle(res.message).setIcon('error').toast();
                }
            }).catch(error => {
                this.handleNetworkError(error);
            });
        },

        formError (field, message) {
            let attrId = $(`#${field}`);
            let parent = null;
            attrId.addClass('is-invalid')
            parent = attrId.parent('.input-group');
            parent.find('.invalid-feedback').remove();
            parent.append(`<span class="invalid-feedback">${message}</span>`);
        },
        clearFormError (field){
            $(`#${field}`).removeClass('is-invalid')
            $(`#${field}`).next('.invalid-feedback').remove();
        }
    },
    created() {
        $("title").html(`${this.page_title} | Vunyx`);
        this.video_url = window.location.origin+'/player/'+this.project.uuid;

        this.watch_access = this.project.setting.watch_access;
        this.embed_access = this.project.setting.embed_access;

        
        this.viewers = _.cloneDeep(this.project.watch_users);
        this.embed_domains = _.cloneDeep(this.project.embed_domains);

        this.embed_code = `<iframe src="${window.location.origin+'/embed/'+this.project.uuid}" frameborder="0" height="500" width="320"></iframe>`;
    }
};
</script>

<style lang="scss" scoped>
input,
textarea {
    &:read-only {
        background: transparent !important;
    }
}
.share-link {
    padding: 10px 15px;
    font-size: 20px;
}
</style>

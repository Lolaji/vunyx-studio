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
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
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
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="">Publish</label>
                                                <select 
                                                    v-model="watch_access"
                                                    class="form-control">
                                                        <option value="0">Public</option>
                                                        <option value="1">Restricted</option>
                                                        <option value="2">Embeded Only</option>
                                                </select>
                                                 <small class="form-text text-muted">{{ watch_access_desc[watch_access] }}</small>
                                            </div>
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

                    <div class="card-footer">
                        <div class="row justify-content-end">
                            <button type="button" class="btn btn-sm btn-primary"> <i class="fa fa-save"></i> SAVE</button>
                        </div>
                    </div>
                </div>
            </section>
        </template>
    </studio-layout>
</template>

<script>
import StudioLayout from '../Layouts/StudioLayout';
import MainSidebar from "../components/MainSidebar.vue";
import ContentHeader from "../components/ContentHeader.vue";
export default {
    props: ["page_title", "username", 'project'],
    components: {
        StudioLayout,
        MainSidebar,
        ContentHeader
    },
    data(){
        return {
            watch_access: 0,
            watch_access_desc: [
                'Anyone with the link can watch.',
                'Anyone you selected can watch.',
                'You can only embed into website'
            ],
            video_url: ''
        }
    },
    methods: {},
    created() {
        $("title").html(`${this.page_title} | Vunyx`);
        this.video_url = window.location.origin+'/player/'+this.project.uuid;
    }
};
</script>

<style lang="scss">
input {
    &:read-only {
        background: transparent !important;
    }
}
</style>

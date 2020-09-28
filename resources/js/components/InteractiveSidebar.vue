<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="col-md-12 brand-link">
            <div class="row justify-content-center">
                <img src="img/logo.png" alt="vunyx logo" class="brand-image"
                style="opacity: .8">
            </div>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-header text-center py-2">INTERACTIVE CONTROLS</li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('link')">
                        <i class="nav-icon fas fa-link"></i>
                        <p>Link</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('hotspot')">
                        <i class="nav-icon fas fa-hubspot"></i>
                        <p>Hotspot</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('question')">
                        <i class="nav-icon fas fa-question-circle"></i>
                        <p>Question</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('chapter')">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Chapter</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('image')">
                        <i class="nav-icon fas fa-image"></i>
                        <p>Image</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('text')">
                        <i class="nav-icon fas fa-layers-text"></i>
                        <p>Text</p>
                    </a>
                </li>
            
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
<script>
    export default {
        methods: {
            createElem(elemType){
                this.$emit('create', elemType);
            }
        },
    }
</script>
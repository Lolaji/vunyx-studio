<template>
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="index3.html" class="col-md-12 brand-link">
            <div class="row justify-content-center">
                <logo></logo>
            </div>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                <!-- <div class="image">
                    <img src="" class="img-circle elevation-2" alt="User Image">
                </div> -->
                <div class="info">
                    <a href="#" class="d-block">{{username}}</a>
                </div>
            </div>
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                        with font-awesome or any other icon font library -->

                    <!-- <li class="nav-item">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboad</p>
                        </a>
                    </li> -->

                    <li class="nav-item">
                        <inertia-link
                            href="/main/project" 
                            class="nav-link">
                                <i class="nav-icon fa fa-project-diagram"></i>
                                <p>Projects</p>
                            </inertia-link>
                    </li>

                    <!-- <li class="nav-item">
                        <inertia-link
                            href="/main/vx-videos" 
                            class="nav-link">
                                <i class="nav-icon fa fa-sync-alt"></i>
                                <p>Vunyx Videos</p>
                            </inertia-link>
                    </li> -->
                
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
</template>
<script>
import Logo from './Logo';
    import IeIcon from './InteractiveIcon';
    export default {
        props:['username'],
        components: {
            Logo,
            IeIcon
        },
    }
</script>
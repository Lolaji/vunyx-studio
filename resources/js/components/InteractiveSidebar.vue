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
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                    with font-awesome or any other icon font library -->
                <li class="nav-header text-center py-2">INTERACTIVE CONTROLS</li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('link')">
                        <ie-icon type="link" classes="nav-icon"></ie-icon>
                        <p>Link</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('text')">
                        <ie-icon type="text" classes="nav-icon"></ie-icon>
                        <p>Text</p>
                    </a>
                </li>

                <!-- <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('image')">
                        <ie-icon type="image" classes="nav-icon"></ie-icon>
                        <p>Image</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('hotspot')">
                        <ie-icon type="hotspot" classes="nav-icon"></ie-icon>
                        <p>Hotspot</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('question')">
                        <ie-icon type="question" classes="nav-icon"></ie-icon>
                        <p>Quiz &amp; Poll</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('chapter')">
                        <ie-icon type="chapter" classes="nav-icon"></ie-icon>
                        <p>Chapter</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" @click.prevent="createElem ('custom-form')">
                        <ie-icon type="chapter" classes="nav-icon"></ie-icon>
                        <p>Custom Form</p>
                    </a>
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
        components: {
            Logo,
            IeIcon
        },
        methods: {
            createElem(elemType){
                this.$emit('create', elemType);
            }
        },
    }
</script>
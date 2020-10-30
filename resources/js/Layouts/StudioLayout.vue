<template>
    <div class="wrapper">

        <!-- Navbar -->
        <nav-bar></nav-bar>
        <!-- /.navbar -->

        <slot name="leftSideBar"></slot>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <slot name="ContentHeader"></slot>
            <!-- Main content -->
            <slot name="mcontent"></slot>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        
    </div>
</template>

<script>
    require('../../assets/plugins/bootstrap/js/bootstrap.bundle.min.js');
    require('../../assets/plugins/sparklines/sparkline.js');
    require('../../assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js');
    require('../../assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js');
    require('../../assets/dist/js/adminlte.js');
    require('../../assets/dist/js/demo.js');

    import NavBar from '../components/NavBar';
    export default {
        components: {
            NavBar,
        },
        mounted(){
            $('[data-toggle="tooltip"]').tooltip();
        }
    }
</script>
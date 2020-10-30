<template>
    <nav class="main-header navbar navbar-expand navbar-dark navbar-black">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="https://vunyx.com" class="nav-link">Home</a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <!-- <a href="" class="nav-link">Projects</a> -->
                <inertia-link 
                    href="/main/project"
                    class="nav-link">Projects</inertia-link>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- <li class="nav-item">
                <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#">
                <i class="fas fa-th-large"></i>
                </a>
            </li> -->
        </ul>
    </nav>
</template>
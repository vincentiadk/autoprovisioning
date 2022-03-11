<div class="nav-left-sidebar sidebar-dark">
    <div class="menu-list">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-divider">
                        Menu
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link page" href="#"><i class="fa fa-fw fa-user-circle"></i>Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/panel/configuration"><i class="fa fa-envelope"></i>Inbox</router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link page" to="/panel/configuration/form"><i class="ti-harddrive"></i>Generate Configuration</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page" href="{{ url('panel/gpon') }}"><i class="ti-harddrive"></i>GPON</a>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/panel/metro"><i class="ti-signal"></i>Metro</router-link>
                   
                    </li>
                    <li class="nav-item">
                        
                        <a class="nav-link page" href="{{ url('panel/logs') }}"><i class="fa fa-fw fa-rocket"></i>Log</a>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link" to="/panel/user"><i class="fa fa-users"></i>User Management</router-link>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link page" href="{{ url('panel/role') }}"><i class="fa fa-users"></i>Role</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
<!-- ============================================================== -->
<!-- end left sidebar -->
<!-- ============================================================== -->

<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
    <div class="modal animated bounceInRight text-left " id="modal_validation" data-backdrop="static" role="dialog"
        aria-labelledby="myModalLabel50" style="color:white" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content ">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel50">Error!</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-danger">
                    <ul id="validasi_content"></ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-light" data-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
    <div id="app">
    </div>
    <!--@loginevent="checkLogin" -->
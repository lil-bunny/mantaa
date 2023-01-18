@extends('admin::layouts.admin_dashboard')

@section('content')

<!-- BEGIN: Page Main-->
<div id="main">
    <div class="row">
        <div class="content-wrapper-before gradient-45deg-indigo-purple"></div>
        <div class="col s12">
            <div class="container">
                <div class="section">
                    
                    
                    <div class="row">
                        <div class="col s12 m4 l4">
                            <div class="card padding-4 animate fadeLeft">
                                <div class="row">
                                    <div class="col s5 m5">
                                        <h5 class="mb-0">5</h5>
                                        <p class="no-margin">Active</p>
                                        <p class="mb-0 pt-8">50</p>
                                    </div>
                                    <div class="col s7 m7 right-align">
                                        <i
                                            class="material-icons background-round mt-5 mb-5 gradient-45deg-purple-amber gradient-shadow white-text">perm_identity</i>
                                        <p class="mb-0">Total Users</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4 l4">
                            <div class="card pt-0 pb-0 animate fadeLeft">
                                <div class="card padding-4 animate fadeLeft">
                                    <div class="row">
                                        <div class="col s5 m5">
                                            <h5 class="mb-0">3</h5>
                                            <p class="no-margin">Active</p>
                                            <p class="mb-0 pt-8">20</p>
                                        </div>
                                        <div class="col s7 m7 right-align">
                                            <i
                                                class="material-icons background-round mt-5 mb-5 gradient-45deg-purple-amber gradient-shadow white-text">perm_identity</i>
                                            <p class="mb-0">Sites</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col s12 m4 l4">
                            <div class="card pt-0 pb-0 animate fadeLeft">
                                <div class="card padding-4 animate fadeLeft">
                                    <div class="row">
                                        <div class="col s5 m5">
                                            <h5 class="mb-0">3</h5>
                                            <p class="no-margin">Active</p>
                                            <p class="mb-0 pt-8">20</p>
                                        </div>
                                        <div class="col s7 m7 right-align">
                                            <i
                                                class="material-icons background-round mt-5 mb-5 gradient-45deg-purple-amber gradient-shadow white-text">perm_identity</i>
                                            <p class="mb-0">Advertisements</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col s12 m6 l12">
                            <section class="users-list-wrapper section">
                                
                                <div class="users-list-table">
                                    <div class="card">
                                    
                                            <!-- <div class="card-content pb-1"> -->
                                            <h4 class="card-title mb-0">Recent Advertisements</h4>
                                            
                                            <!-- datatable start -->
                                            <div class="responsive-table">
                                                <table id="users-list-datatable" class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Serial No</th>
                                                            <th>Date & Time</th>
                                                            <th>Title</th>
                                                            <th>City</th>
                                                            <th>Status</th>
                                                            <th>Actions</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <th>1</th>
                                                            <td>09/08/2021 08:00 PM</td>
                                                            <td>Lorem Ipsum</td>
                                                            <td>lorem Ipsum</td>
                                                            <td>Pending</td>
                                                            <td>    
                                                                <a class="waves-effect waves-light modal-trigger" href="#modal1"><i class="material-icons red-text">delete</i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!-- datatable ends -->
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>    
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Page Main-->
@endsection

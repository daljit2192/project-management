@extends('frontend.layouts.app')

@section('title', app_name() . ' | Contact Us')

@section('content')
<div id="page-wrapper">
    <div class="row">
                <div class="col-lg-12">
                       <h1 class="page-header">Project List</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
    <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Project Name</th>
                                        <th>Project Status</th>
                                        <th>Project Creator</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>envato.com</td>
                                        <td>Pending</td>
                                        <td>John</td>
                                        <td>
                                            <a href="#myModal" class="edit" data-toggle="modal" data-target="#myModal">
                                                <i class="fa fa-pencil-square-o"></i>
                                            </a>
                                            <!-- Large modal -->
                                            <div id="myModal" tabindex="-1" role="dialog"<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Project Changes</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form>
                                                      <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                                        <input type="text" class="form-control" id="recipient-name">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Message:</label>
                                                        <textarea class="form-control" id="message-text"></textarea>
                                                      </div>
                                                    </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Send message</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>

                                            <!--delete icon-->              
                                            <a class="delete" href="#"><i class="fa fa-times"></i></a>
                                            <!--view icon-->
                                            <a href="#myModal-d" class="view" data-toggle="modal" data-target="#myModal-d"><i class="fa fa-eye"></i></a>
                                         <!-- Large modal -->
                                            <div id="myModal-d" tabindex="-1" role="dialog"<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Project Changes</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form>
                                                      <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                                        <input type="text" class="form-control" id="recipient-name">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Message:</label>
                                                        <textarea class="form-control" id="message-text"></textarea>
                                                      </div>
                                                    </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Send message</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                    
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>envato.com</td>
                                        <td>Pending</td>
                                        <td>John</td>
                                        <td>
                                            <!--edit icon-->
                                            <!--edit icon-->
                                            <a href="#myModal-1" class="edit" data-toggle="modal" data-target="#myModal-1"><i class="fa fa-pencil-square-o"></i></a></a>
                                                    <!-- Large modal -->
                                            <div id="myModal-1" tabindex="-1" role="dialog"<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLabel">Project Changes</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                        <form>
                                                        <div class="form-group">
                                                            <label for="recipient-name" class="col-form-label">Recipient:</label>
                                                            <input type="text" class="form-control" id="recipient-name">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="message-text" class="col-form-label">Message:</label>
                                                            <textarea class="form-control" id="message-text"></textarea>
                                                        </div>
                                                    </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Send message</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <a class="delete" href="#"><i class="fa fa-times"></i></a>
                                            <a href="#myModal-c" class="view" data-toggle="modal" data-target="#myModal-c"><i class="fa fa-eye"></i></a>
                                                        <!-- Large modal -->
                                            <div id="myModal-c" tabindex="-1" role="dialog"<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                              <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                  <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Project Changes</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                      <span aria-hidden="true">&times;</span>
                                                    </button>
                                                  </div>
                                                  <div class="modal-body">
                                                    <form>
                                                      <div class="form-group">
                                                        <label for="recipient-name" class="col-form-label">Recipient:</label>
                                                        <input type="text" class="form-control" id="recipient-name">
                                                      </div>
                                                      <div class="form-group">
                                                        <label for="message-text" class="col-form-label">Message:</label>
                                                        <textarea class="form-control" id="message-text"></textarea>
                                                      </div>
                                                    </form>
                                                  </div>
                                                  <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="button" class="btn btn-primary">Send message</button>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                    
                                        </td>
                                    </tr>    
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                </div>
                    <!-- /.row -->
             </div>
                       <!-- /.panel-body -->
                   </div>
@endsection
 
<div class="modal fade" id="add_new_larger_modals" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="add_new_larger_modals_tile"></h4>
            </div>
            <form id="add_new_form" action="{{ route('vendor.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf 
            <div class="modal-body">
                <div id="add_new_larger_modals_body">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Name <small class="text-danger">*</small></label>                                 
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Title" />                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Email <small class="text-danger">*</small></label>                                 
                                    <input type="email" name="email" id="email" class="form-control" placeholder="Email" />                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">Phone <small class="text-danger">*</small></label>                                 
                                    <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone" />                                   
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label class="form-label">User Type <small class="text-danger">*</small></label>                                 
                                    <select class="form-control" name="user_type" id="user_type" onchange="is_edited()">
                                        <option value="">-- Please select --</option>
                                        <option value="vendors" selected>Sales Vendor</option>
                                        <option value="pvendors">Purchase Vendor</option>
                                    </select>                             
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-round waves-effect" data-dismiss="modal">CLOSE</button>
                <div class="swal-button-container">
                    <button type="submit" class="btn btn-success btn-round waves-effect dsld-btn-loader">SUBMIT</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

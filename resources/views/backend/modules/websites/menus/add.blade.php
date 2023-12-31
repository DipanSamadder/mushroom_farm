 
<div class="modal fade" id="add_new_larger_modals" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="add_new_larger_modals_tile"></h4>
            </div>
            <form id="add_new_form" action="{{ route('menus.store') }}" method="POST" enctype="multipart/form-data" >
            @csrf 
            <div class="modal-body">
                <div id="add_new_larger_modals_body">
                    <div class="body">
                        <div class="row clearfix">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form-label">Name <small class="text-danger">*</small></label>                                 
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Title" />                                   
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Url <small class="text-danger">*</small></label>                                 
                                    <input type="text" name="url" id="url" class="form-control" placeholder="Url" />                                   
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Type </label> 
                                    <select class="form-control show-tick ms select2" name="type" id="type2">
                                         <option value="topbar_menu">Topbar Menu</option>
                                        <option value="header_menu">Header Menu</option>
                                        <option value="footer_menu">Footer Menu</option>
                                        <option value="important_link">Important Menu</option>
                                        <option value="quick_link">Quick Menu</option>
                                    </select>                            
                                </div>
                            </div><div class="col-sm-4">
                                <div class="form-group">
                                    <label class="form-label">Parent </label>    
                                    <select class="form-control show-tick ms select2" name="parent" id="parent">
                                        <option value="0">-- Please select --</option>
                                        @foreach(App\Models\Menu::where('status', 0)->get() as $key => $value)
                                            <option value="{{ $value->id }}">{{ $value->name}}</option>
                                        @endforeach
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

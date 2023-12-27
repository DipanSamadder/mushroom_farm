 
<div class="modal fade media" id="DSLDImageGeT" tabindex="-1" role="dialog" style="z-index: 999999">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="DSLDLargeModalTitle">All Media</h4>
                <button class="btn btn-info btn-round mb-4" onclick="get_media_files();"><i class="zmdi zmdi-hc-fw"></i> Reload</button>
            </div>
            <div class="modal-body">
                <div class="card">
                    <div class="body">
                    <form class="form-inline" id="search_media">
                        <!-- <div class="form-group">                                
                            <input type="date" class="form-control ms  mr-2" name="get_date" onchange="filter()">
                        </div> -->
                        <div class="col-lg-4">
                            <div class="form-group">                                
                                <select class="form-control" name="sort" onchange="filter_media()">
                                    <option value="newest">New to Old</option>
                                    <option value="oldest">Old to New</option>
                                    <option value="smallest">Samllest</option>
                                    <option value="largest">Largest</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">                                
                                <select class="form-control" name="media_type" onchange="filter_media()">
                                    <option value="all">All</option>
                                    <option value="image">Image</option>
                                    <option value="document">Documents</option>
                                    <option value="video">Video</option>
                                    <option value="audio">Audio</option>
                                    <option value="archive">Archive</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="form-group">                                    
                                <input type="text" class="form-control" name="msearch" onblur="filter_media()" placeholder="Search File name">
                            </div>
                        </div>
                    </form>
                       
                        <div id="modal_load_files"></div>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



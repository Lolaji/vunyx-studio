<template>
    <div class="interactive-container col-md-4">
        <div class="interactive-editor">
            <div class="ie-header">
                <nav class="nav">
                    <a 
                        class="nav-link active" 
                        id="interactive-tab" 
                        href="#interactive-panel" 
                        data-toggle="tab" 
                        aria-controls="interactive-panel"
                        role="tab"
                        aria-selected="true">Interactive</a>

                    <a 
                        class="nav-link" 
                        id="customization-tab" 
                        href="#customization-panel" 
                        role="tab"
                        data-toggle="tab"
                        aria-controls="customization-panel"
                        aria-selected="false">Customization</a>
                </nav>
            </div>
            <div class="ie-body">
                <div class="tab-content">

                    <div class="tab-panel pt-2 fade show active" id="interactive-panel" role="tabpanel" aria-labelledby="interactive-tab">
                        
                        <div class="form-group form-inline">
                            <label class="label col-3" for="">Title</label>
                            <input type="text" class="form-control">
                        </div>

                        <div class="form-group form-inline">
                            <label class="label col-3" for="">Action</label>
                            <select class="form-control col-md-5">
                                <option value="">Action 1</option>
                                <option value="">Action 2</option>
                                <option value="">Action 3</option>
                                <option value="">Action 4</option>
                                <option value="">Action 5</option>
                            </select>
                        </div>

                        <div class="form-group form-inline">
                            <label class="label col-3" for="">Hypertext</label>
                            <input type="url" class="form-control" placeholder="https://vunyx.com">
                        </div>
                        
                        <div class="form-group">
                            <div class="icheck-light-yellow d-inline">
                                <input type="radio" id="checkboxPrimary3">
                                <label for="checkboxPrimary3">Primary checkbox</label>
                            </div>
                        </div>
                    </div>

                    <div class="tab-panel fade" id="customization-panel" role="tabpanel" aria-describedby="customization-tab">
                        <ul class="list-group">
                            <div>
                                <li class="list-group-item" data-toggle="collapse" data-target="#padding">
                                    Padding
                                    <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                </li>
                                <div class="content collapse show" id="padding">
                                    Form here
                                </div>
                            </div>
                            <div>
                                <li class="list-group-item" data-toggle="collapse" data-target="#margin">
                                    Margin
                                    <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                </li>
                                <div class="content collapse" id="margin">
                                    Form here
                                </div>
                            </div>
                            <div>
                                <li class="list-group-item" data-toggle="collapse" data-target="#background">
                                    Background
                                    <span class="icon float-right"><i class="fa fa-angle-down"></i></span>
                                </li>
                                <div class="content collapse" id="background">
                                    Form here
                                </div>
                            </div>
                        </ul>
                    </div>

                </div>
            </div>
            <div class="ie-footer">
                <div class="col-md-12">
                    <div class="row justify-content-between">
                        <button class="btn btn-sm btn-link text-danger">Cancel</button>
                        <button class="btn btn-sm btn-link text-white">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
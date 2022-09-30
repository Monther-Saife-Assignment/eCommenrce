<!--                Start Name Field
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <div class="arrange1">
                                        <label class="control-label" for="">Name</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="arrange2">
                                    <input type="text" name="name" class="form-control" autocomplete="off" required="required" placeholder=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    End Name Field 

                    Start Description Field 
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <div class="arrange1">
                                        <label class="control-label" for="">Description</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="arrange2">
                                    <input type="text" name="description" class="form-control" autocomplete="off" required="required" placeholder=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    End Description Field 

                    Start Ordering Field 
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <div class="arrange1">
                                        <label class="control-label" for="">Ordering</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="arrange2">
                                    <input type="int" name="description" class="form-control" autocomplete="off" required="required" placeholder=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    End Ordering Field 


                    Start Visibility Field 
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <div class="arrange1">
                                        <label class="control-label" for="">Visibility</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="arrange2">
                                    <input type="int" name="visibility" class="form-control" autocomplete="off" required="required" placeholder=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    End Visibility Field 

                    Start Allow_Comments Field 
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <div class="arrange1">
                                        <label class="control-label" for="">Allow_Comments</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="arrange2">
                                    <input type="int" name="description" class="form-control" autocomplete="off" required="required" placeholder=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    End Allow_Comments Field 

                    Start Allow_Ads Field 
                    <div class="form-group">
                        <div class="row">
                            <div class="form-group">
                                <div class="col-md-2">
                                    <div class="arrange1">
                                        <label class="control-label" for="">Allow_Ads</label>
                                    </div>
                                </div>
                                <div class="col-md-10">
                                    <div class="arrange2">
                                    <input type="int" name="description" class="form-control" autocomplete="off" required="required" placeholder=""/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    End Allow_Ads Field 

                    Start Username Field 
                <div class="form-group">
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" value="Add Category" class="btn btn-primary" />
                </div>
                    End Username Field          -->

<!--
                <form class="form-horizontal" action="category.php?do=Insert" method="POST"> 

                Start Name Field 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Name</label>
                <div class="col-sm-10 col-sm-6">
                    <input type="text" name="name" class="form-control"
                    autocomplete="off" required="required" placeholder="Name Of The Category"/>
                </div>
                </div>
                End Name Field 

                Start Description Field 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Description</label>
                <div class="col-sm-10 col-sm-6">
                    <input type="text" name="description" class="form-control"
                    autocomplete="off" required="required" placeholder="Description Of The Category"/>
                </div>
                </div>
                End Description Field 

                Start Ordering Field 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Ordering</label>
                <div class="col-sm-10 col-sm-6">
                    <input type="text" name="ordering" class="form-control"
                    autocomplete="off" required="required" placeholder="Number To Arrange  The Category"/>
                </div>
                </div>
                End Ordering Field 

                Start Visibility Field 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Visibility</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input id="vis-yes" type="radio" name="visibility" value="0" checked/>
                        <label for="vis-yes">Yes</label>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input id="vis-no" type="radio" name="visibility" value="1"/>
                        <label for="vis-np">No</label>
                    </div>
                </div>
                End Visibility Field 

                Start Allow_Comments Field 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Allow_Commenting</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input id="com-yes" type="radio" name="commenting" value="0" checked/>
                        <label for="com-yes">Yes</label>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input id="com-no" type="radio" name="commenting" value="1"/>
                        <label for="com-np">No</label>
                    </div>
                </div>
                End Allow_Comments Field 

                Start Allow_Ads Field 
                <div class="form-group form-group-lg">
                <label class="col-sm-2 control-label" for="">Allow Ads</label>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input id="com-yes" type="radio" name="ads" value="0" checked/>
                        <label for="com-yes">Yes</label>
                    </div>
                </div>
                <div class="col-sm-10 col-md-6">
                    <div>
                        <input id="com-no" type="radio" name="ads" value="1"/>
                        <label for="com-np">No</label>
                    </div>
                </div>
                End Allow_Ads Field 

                Start Add Category 
                <div class="form-group">
                </div>
                <div class="col-sm-offset-2 col-sm-10">
                <input type="submit" value="Add Category" class="btn btn-primary" />
                </div>
                End Add Category 
-->
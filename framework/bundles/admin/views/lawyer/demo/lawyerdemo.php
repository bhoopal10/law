<?php echo Section::start('contentWrapper'); ?>
    <div class="span12">
        <div class="widget-box">
            <div class="widget-header">
                <h5 class="smaller">Demo</h5>

                <div class="widget-toolbar no-border">
                    <ul class="nav nav-tabs" id="myTab">
                        <li class="active">
                            <a data-toggle="tab" href="#associates">Associates</a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#cases">Cases</a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#hearings">Hearings</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#reports">Reports</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#clients">Clients</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#appointments">Appointments</a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#billing">Billing</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="widget-body">
                <div class="widget-main padding-6">
                    <div class="tab-content">
                        <div id="associates" class="tab-pane in active">
                            <iframe style="margin-left: 130px" width="987" height="500"  src="//www.youtube.com/embed/uVi1tlhMVeI?rel=0&showinfo=0"
                                    frameborder="0" allowfullscreen></iframe>
                        </div>

                        <div id="cases" class="tab-pane">
                            <iframe style="margin-left: 130px" width="987" height="500" src="//www.youtube.com/embed/LxGFUhNQj7E?rel=0&showinfo=0"
                            frameborder="0" allowfullscreen>
                            </iframe>
                        </div>

                        <div id="hearings" class="tab-pane">
                            <iframe style="margin-left: 130px" width="987" height="500"  src="//www.youtube.com/embed/Vj1cKG7JN_Y?rel=0&showinfo=0"
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div id="reports" class="tab-pane">
                            <iframe style="margin-left: 130px" width="987" height="500"  src="//www.youtube.com/embed/_v4_-fRYozQ?rel=0&showinfo=0"
                            frameborder="0" allowfullscreen>

                            </iframe>
                        </div>
                        <div id="clients" class="tab-pane">
                            <iframe style="margin-left: 130px" width="987" height="500"  src="//www.youtube.com/embed/drDG9MIf4Cs?rel=0&showinfo=0"
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div id="appointments" class="tab-pane">
                            <iframe style="margin-left: 130px" width="987" height="500"  src="//www.youtube.com/embed/3fvZWJqmAw0?rel=0&showinfo=0"
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                        <div id="billing" class="tab-pane">
                            <iframe style="margin-left: 130px" width="987" height="500" src="//www.youtube.com/embed/ZZ7Vqi_A3iE?rel=0&showinfo=0"
                                    frameborder="0" allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php Section::stop(); ?>
<?php echo render('admin::lawyer/template.main'); ?>
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper container-xxl p-0">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <!-- Dashboard Ecommerce Starts -->
            <section id="dashboard-ecommerce">
                <div class="row match-height">
                    <!-- Statistics Card -->
                    <div class="col-xl-12 col-md-6 col-12">
                        <div class="card card-statistics">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo __('Riepilogo');?></h4>
                            </div>
                            <div class="card-body statistics-body">
                                <div class="row">
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-primary me-2">
                                                <div class="avatar-content">
                                                    <i data-feather="user" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0" id="lbl_tot_paz">0</h4>
                                                <p class="card-text font-small-3 mb-0"><?php echo __("Miei Pazienti"); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-xl-0">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-info me-2">
                                                <div class="avatar-content">
                                                    <i data-feather="calendar" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0" id="lbl_appointments">0</h4>
                                                <p class="card-text font-small-3 mb-0"><?php echo __("Appuntamenti oggi"); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12 mb-2 mb-sm-0">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-danger me-2">
                                                <div class="avatar-content">
                                                    <i data-feather="dollar-sign" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0" id="lbl_money">0 €</h4>
                                                <p class="card-text font-small-3 mb-0"><?php echo __("Guadagno di questo mese"); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-sm-6 col-12">
                                        <div class="d-flex flex-row">
                                            <div class="avatar bg-light-success me-2">
                                                <div class="avatar-content">
                                                    <i data-feather="message-circle" class="avatar-icon"></i>
                                                </div>
                                            </div>
                                            <div class="my-auto">
                                                <h4 class="fw-bolder mb-0" id="lbl_unread_msg">0</h4>
                                                <p class="card-text font-small-3 mb-0"><?php echo __("Messaggi non letti"); ?></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Statistics Card -->
                </div>

                <div class="row match-height">
                    <!-- Revenue Report Card -->
                    <div class="col-lg-12 col-12">
                        <div class="card card-revenue-budget">
                            <div class="row mx-0">
                                <div class="col-md-12 col-12 revenue-report-wrapper">
                                    <div class="d-sm-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-title mb-50 mb-sm-0"><?php echo __("I Miei Pazienti"); ?></h4>
                                    </div>
                                    <div class="card">
                                        <div class="card-datatable table-responsive pt-0">
                                            <table class="user-list-table table">
                                                <thead class="table-light">
                                                <tr>
                                                    <th></th>
                                                    <th><?php echo __("Nome e Cognome"); ?></th>
                                                    <th><?php echo __("Diagnosi Attuale"); ?></th>
                                                    <th><?php echo __("In Cura dal"); ?></th>
                                                    <th><?php echo __("Data di Nascita"); ?></th>
                                                    <th><?php echo __("REGISTRATO SU APP"); ?></th>
                                                    <th><?php echo __("Azioni");?></th>
                                                </tr>
                                                </thead>
                                            </table>
                                        </div>
                                    </div>
                                    <!-- list and filter end -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--/ Revenue Report Card -->
                </div>
            </section>
            <!-- Dashboard Ecommerce ends -->

        </div>
    </div>
</div>
